<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\Position;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Rules\ValidCellphoneNumber;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    protected function store(Request $request)
    {
        $request->validate([
            'email_address' => ['required', 'string', 'email', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'office_id' => ['required'],
            'position_id' => ['required'],
            'auth_type' => ['required'],
            'mobile_number' => ['required', 'string', 'max:11', new ValidCellphoneNumber],
        ]);

        $data = $request->all();

        DB::transaction(function() use ($data){
            $user = User::create([
                'username' => $data['username'],
                'email_address' => $data['email_address'],
                'auth_type' => $data['auth_type'],
                'password' => Hash::make(Str::random(8)),
            ]);
    
            $user->userInformation()->create([
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'],
                'last_name' => $data['last_name'],
                'ext_name' => $data['ext_name'],
                'mobile_number' => $data['mobile_number'],
                'office_id' => $data['office_id'],
                'position_id' => $data['position_id'],
                'designation' => $data['designation'],
            ]);
            
            return $user;

        }, 5);
    }

    public function show()
    {
        $data = [
            'offices' => Office::all(),
            'positions' => Position::all(),
            'user_data' => session('userInformation')
        ];

        return view('auth.register', $data);
    }
}
