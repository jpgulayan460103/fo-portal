<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OneTimePassword;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Rules\ValidOtp;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    /**
     * Get username property.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }


    protected function validateOtp(Request $request)
    {
        $request->validate([
            'otpCode' => ['required', new ValidOtp],
        ]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        if($request->has('otpCode')){
            $this->validateOtp($request);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        
        $auth = $this->attemptLogin($request);

        if ($auth['status'] == "ok") {

            $user = User::with(['userInformation'])->where('username', $auth['data']['username'])->first();
            $auth['user'] = $user;
            if($user){
                if($request->has('otpCode')){
                    Auth::login($user, $request->remember);
                }else{
                    $oneTimePassword = $user->otpCodes()->create([
                        'otp_code' => random_int(100000, 999999),
                        'reference_number' => Str::random(10),
                    ]);
                    
                    $auth['otpCode'] = $oneTimePassword;

                    $this->sendOneTimePassword($user->userInformation->mobile_number, $oneTimePassword);
                }
                return $this->sendLoginResponse($request, $auth);
            }else{
                return $this->sendRegistrationResponse($request, $auth);
            }

        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendOneTimePassword(string $number, OneTimePassword $oneTimePassword) {
        $smsGatewayUrl = config('services.sms.gateway');
        $apiKey = config('services.sms.api_key');
        $clientId = config('services.sms.client_id');
        $senderId = config('services.sms.sender_id');
        $message = "Your One-Time Password (OTP) is $oneTimePassword->otp_code.";
        $receiverNumber = "639".substr($number, 2);

        $response = Http::get($smsGatewayUrl, [
            'ApiKey' => $apiKey,
            'ClientId' => $clientId,
            'SenderId' => $senderId,
            'Message' => $message,
            'MobileNumbers' => $receiverNumber,
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        return $this->ldapAuth($request->only('username', 'password'));
    }

    protected function sendLoginResponse(Request $request, $auth)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if($request->wantsJson()){
            return response($auth, 200);
        }else{
            redirect()->intended($this->redirectPath());
        }
    }

    public function sendRegistrationResponse(Request $request, $auth) {

        $userData = [
            'username' => $auth['data']['username'],
            'email_address' => $auth['data']['email_address'],
            'first_name' => $auth['data']['firstname'],
            'middle_name' => $auth['data']['middlename'],
            'last_name' => $auth['data']['lastname'],
            'ext_name' => null,
            'auth_type' => 'active_directory',
        ];

        if($request->wantsJson()){
            $request->session()->flash('userInformation', $userData);
            return response($userData, 200);
        }else{
            return redirect('/auth/google/register')->with('userInformation', $userData);
        }
    }

    protected function credentials(Request $request)
    {
        return [
            'username' => $request->username,
            'password' => "password",
        ];
    }

    public function maxAttempts()
    {
        return 2;   
    }

    public function decayMinutes()
    {
        return 1;
    }


    public function ldapAuth($credentials) : array
    {
        $adServer = config('services.ad.host');

        $ldap = ldap_connect($adServer);
        $username = $credentials['username'];
        $password = $credentials['password'];
        
        $ldaprdn = config('services.ad.domain') . "\\" . $username;

        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

        $bind = @ldap_bind($ldap, $ldaprdn, $password);

        if ($bind) {
            $filter="(sAMAccountName=$username)";
            $result = ldap_search($ldap,config('services.ad.search'), $filter);
            $info = ldap_get_entries($ldap, $result);
            for ($i=0; $i<$info["count"]; $i++)
            {
                if ($info['count'] > 1)
                    break;
                    $fullname = isset($info[$i]["cn"][0]) ? ucwords($info[$i]["cn"][0]) : "";
                    $firstname = isset($info[$i]["givenname"][0]) ? ucwords($info[$i]["givenname"][0]) : "";
                    $middlename = isset($info[$i]["initials"][0]) ? ucwords($info[$i]["initials"][0]) : "";
                    $lastname = isset($info[$i]["sn"][0]) ? ucwords($info[$i]["sn"][0]) : "";
                    $userDn = isset($info[$i]["distinguishedname"][0]) ? $info[$i]["distinguishedname"][0] : "";
                    $email_address = isset($info[$i]["mail"][0]) ? $info[$i]["mail"][0] : "";
                    $data = [
                        'status' => "ok",
                        'status_code' => 200,
                        'message' => "Successfully Logged in",
                        'error_code' => "success",
                        'data' => [
                            'fullname' => $fullname,
                            'firstname' => $firstname,
                            'middlename' => $middlename,
                            'lastname' => $lastname,
                            'user_dn' => $userDn,
                            'username' => $username,
                            'email_address' => $email_address,
                        ],
                        'errors' => []
                    ];
                    return $data;
                
            }
            @ldap_close($ldap);
        } else {
            return [
                'status' => "error",
                'status_code' => 422,
                'message' => "Invalid AD login details",
                'error_code' => "ad_account_error",
                'errors' => [
                    'username' => [
                        "Invalid AD username or password."
                    ]
                ]
            ];
        }

    }

    public function signInwithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackToGoogle(Request $request)
    {
        try {
     
            $googleAuth = Socialite::driver('google')->user();

            $user = User::where('username', $googleAuth->id)->first();
      
            if($user){
      
                Auth::login($user, true);
     
                return redirect('/');
      
            }else{

                if(isset($googleAuth->user['hd']) && $googleAuth->user['hd'] == "dswd.gov.ph"){

                    $userData = [
                        'username' => $googleAuth->id,
                        'email_address' => $googleAuth->user['email'],
                        'first_name' => $googleAuth->user['given_name'],
                        'middle_name' => null,
                        'last_name' => $googleAuth->user['family_name'],
                        'ext_name' => null,
                        'auth_type' => 'google',
                    ];

                    if($request->wantsJson()){
                        $request->session()->flash('userInformation', $userData);
                        return response($userData, 200);
                    }else{
                        return redirect('/auth/google/register')->with('userInformation', $userData);
                    }
                }else{
                    if($request->wantsJson()){
                        return response([
                            'message' => 'The given data was invalid',
                            'errors' => [
                                'login' => 'Must be DSWD corporate email account to sign in.'
                            ]
                        ], 422);
                    }else{
                        return redirect('/')->with(['error' => [
                            'login' => 'Sign in failed! Must be DSWD corporate email account to sign in.'
                        ]]);
                    }
                }

            }
     
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
