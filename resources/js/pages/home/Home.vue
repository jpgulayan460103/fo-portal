<template>
    <div class="container">
        <modal modal-id="register-modal" modal-title="">
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

        <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="errors && errors.login">
            <span v-if="errors.login">{{ errors.login }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        
        <div class="row">
            <div :class="[isEmpty(authUser) ? 'col-md-9' : 'col-md-12']">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" @keyup="searchApplication" v-model="queryString" placeholder="Search for application name." aria-label="Search for application name." aria-describedby="button-addon2">
                            <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3" :class="[isEmpty(authUser) ? 'col-md-6' : 'col-md-4']" v-for="(webApp, index) in webApplications" :key="index" @click="visitApplication(webApp.application_url)">
                        <web-app :data="webApp" />
                    </div>
                </div>
            </div>
            <div class="col-md-3" v-if="isEmpty(authUser)">
                <card>
                    <template v-slot:header>Welcome to DSWD FOXI Portal</template>
                    <login :google-auth-url="googleAuthUrl" :errors="errors" />
                </card>
            </div>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios';
    import debounce from 'lodash/debounce';
    import isEmpty from 'lodash/isEmpty';
    import WebApp from './components/WebApp.vue';
    import Login from '../auth/Login.vue';
    import UserControl from '../auth/UserControl.vue';
    import Card from '@/components/Card.vue';
    import Modal from '@/components/Modal.vue';

    export default {
        components: {
            WebApp,
            Login,
            Card,
            Modal,
            UserControl,
        },
        props: [
            'googleAuthUrl',
            'authUser',
            'errors'
        ],
        mounted() {
            this.getWebApplications();
        },
        data() {
            return {
                webApplications: [],
                queryString: "",
                activeDirectory: {
                    username: null,
                    password: null,
                }
            };
        },
        methods: {
            getWebApplications(){
                Axios.get(route('web-application.index'), {
                    params: {
                        keywords: this.queryString
                    }
                })
                .then(res => {
                    this.webApplications = res.data.webApplications;
                });
            },
            visitApplication(url){
                window.open(url, '_blank');
            },
            searchApplication: debounce(function() {
                this.getWebApplications();
            }, 500),
            activeDirectoryLogin(){
                Axios.post(route('auth.login'), this.activeDirectory)
                .then(res => {
                    window.location.href = route('register.index')
                })
                .catch(err => {})
            },
            isEmpty(value){
                return isEmpty(value);
            }
        }
    }
</script>
