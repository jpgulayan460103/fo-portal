<template>
    <div>
        <form @submit.prevent="submitForm">
            <div class="mt-2 mb-2">
                <img src="images/logo.png" class="img-fluid" alt="">
            </div>
            <div class="mb-3">
                <label for="username">Username</label>
                <input  type="text" class="form-control" v-model="formData.username" required autocomplete="username" autofocus>
            </div>

            <div class="mb-3">
                <label for="password">Password</label>
                <input  type="password" class="form-control" v-model="formData.password" required autocomplete="current-password">
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Login
                </button>

                <div style="width: 100%; height: 10px; border-bottom: 1px solid black; text-align: center;margin-bottom: 10px">
                    <span style="background-color: #F3F5F6; padding: 0 10px;">
                        <b>OR</b>
                    </span>
                </div>

                <button type="button" class="btn btn-primary" @click="signWithGoogle">
                    <i class="bi bi-google"></i>
                    Sign in using DSWD Email
                </button>
                
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#register-modal">
                    <i class="bi bi-person-fill"></i>
                    Register
                </button>

                <button type="button" data-bs-toggle="modal" data-bs-target="#otp-modal" style="display: none;" ref="otpButton">
                    Otp
                </button>
            </div>
        </form>

        <modal modal-id="register-modal" modal-title="Register Account">
            <template v-slot:body>
                <form id="ad-login" @submit.prevent="activeDirectoryLogin">
                    <div class="mb-3">
                        <label for="username">DSWD Account</label>
                        <input  type="text" class="form-control" v-model="activeDirectory.username" required autocomplete="username" autofocus>
                        <div class="form-text">You can use your Active Diretory (AD) or Global Protect (GP) account.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input  type="password" class="form-control" v-model="activeDirectory.password" required autocomplete="current-password">
                    </div>
                </form>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="ad-login" class="btn btn-danger">
                    <i class="bi bi-person-fill"></i>
                    Register
                </button>
            </template>
        </modal>

        <modal modal-id="otp-modal" modal-title="Two-factor Authentication" :keyboard="'false'">
            <template v-slot:body>
                <div>
                    <p style="text-align: justify;">We just sent you a message via SMS to number <b>{{ validatedUser.mobile_number }}</b> with your authentication code. Enter the code in the form.</p>
                </div>
                <form id="otp-login" @submit.prevent="signWithActiveDirectory">
                    <form-item label="One-Time Password" :errors="formErrors.otpCode">
                        <input type="text" v-model="validCredentials.otpCode" class="form-control" :class="formErrors.otpCode ? 'is-invalid' : ''" required autocomplete="current-password">
                    </form-item>
                    <form-item label="Login Session" :errors="formErrors.remember">
                        <select class="form-control" v-model="validCredentials.remember" required>
                            <option value="stay-signin">Keep me sign in until I logout</option>
                            <option value="only-session">Only this time</option>
                        </select>
                    </form-item>
                </form>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="otp-login" class="btn btn-secondary">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Login
                </button>
            </template>
        </modal>
    </div>
</template>

<script>
    import Axios from 'axios';
    import debounce from 'lodash/debounce';
    import cloneDeep from 'lodash/cloneDeep';
    import Card from '@/components/Card.vue';
    import UserInformationForm from '@/components/UserInformationForm.vue';
    import Modal from '@/components/Modal.vue';
    import FormItem from '@/components/FormItem.vue';
import isEmpty from 'lodash/isEmpty';

    export default {
        components: {
            Card,
            UserInformationForm,
            Modal,
            FormItem,
        },
        props: [
            'googleAuthUrl',
            'errors'
        ],
        mounted() {

        },
        data() {
            return {
                formData: {},
                formErrors: {},
                validCredentials: {},
                validatedUser: {},
                allowResendOtp: false,
                activeDirectory: {
                    username: null,
                    password: null,
                }
            };
        },
        methods: {
            signWithGoogle(){
                window.location.href = this.googleAuthUrl;
            },

            submitForm(){
                Axios.post(route('auth.login'), this.formData)
                .then(res => {
                    if(isEmpty(res.data.otpCode)){
                        window.location.href = route('register.index');
                    }
                    this.validatedUser = res.data.user.user_information;
                    this.validCredentials = cloneDeep(this.formData);

                    this.validCredentials.otpCode = res.data.otpCode.otp_code;
                    this.validCredentials.referenceNumber = res.data.otpCode.reference_number;
                    this.formData = {};
                    this.allowResendOtp = true;
                    this.$refs.otpButton.click();
                })
                .catch(err => {})
            },

            activeDirectoryLogin(){
                Axios.post(route('auth.login'), {
                    ...this.activeDirectory,
                    isRegistration: true
                })
                .then(res => {
                    if(isEmpty(res.data.otpCode)){
                        window.location.href = route('register.index')
                    }

                    this.validatedUser = res.data.user.user_information;
                    this.validCredentials = cloneDeep(this.activeDirectory);

                    this.validCredentials.otpCode = res.data.otpCode.otp_code;
                    this.validCredentials.referenceNumber = res.data.otpCode.reference_number;
                    this.formData = {};
                    this.allowResendOtp = true;
                    this.$refs.otpButton.click();
                })
                .catch(err => {})
            },

            signWithActiveDirectory(){
                Axios.post(route('auth.login'), this.validCredentials)
                .then(res => {
                    window.location.reload();
                })
                .catch(err => {
                    this.formErrors = err.response.data.errors;
                })
            },

        },
    }
</script>
