<template>
    <form @submit.prevent="submitForm">

        <div class="row mb-3">

            <div class="col-md-12">
                <div class="mt-4">
                    <h1 style="font-weight: bolder; text-align: center;">{{ formTitle }}</h1>
                </div>
            </div>
        </div>

        <div class="row mb-3">

            <div class="col-md-4">
                <form-item label="First Name" :errors="formErrors.first_name">
                    <input type="text" class="form-control" v-model="formData.first_name" :class="formErrors.first_name ? 'is-invalid' : ''" required autocomplete="new-password">
                </form-item>
            </div>

            <div class="col-md-3">
                <form-item label="Middle Name" :errors="formErrors.middle_name">
                    <input type="text" class="form-control" v-model="formData.middle_name" :class="formErrors.middle_name ? 'is-invalid' : ''" autocomplete="new-password">
                </form-item>
            </div>

            <div class="col-md-4">
                <form-item label="Last Name" :errors="formErrors.last_name">
                    <input type="text" class="form-control" v-model="formData.last_name" :class="formErrors.last_name ? 'is-invalid' : ''" required autocomplete="new-password">
                </form-item>
            </div>
            
            <div class="col-md-1">
                <form-item label="Ext Name" :errors="formErrors.ext_name">
                    <input type="text" class="form-control" v-model="formData.ext_name" :class="formErrors.ext_name ? 'is-invalid' : ''" autocomplete="new-password">
                </form-item>
            </div>
            
        </div>

        <div class="row mb-3">

            <div class="col-md-3">
                <form-item label="Mobile Number" :errors="formErrors.mobile_number">
                    <input type="text" class="form-control" v-model="formData.mobile_number" :class="formErrors.mobile_number ? 'is-invalid' : ''" autocomplete="new-password">
                </form-item>
            </div>

            <div class="col-md-3">
                <form-item label="Office" :errors="formErrors.office_id">
                    <select class="form-control" v-model="formData.office_id" required>
                        <option v-for="(office, index) in offices" :key="index" :value="office.id">{{ office.name }}</option>
                    </select>
                </form-item>
            </div>

            <div class="col-md-3">
                <form-item label="Position" :errors="formErrors.position_id">
                    <select class="form-control" v-model="formData.position_id" required>
                        <option v-for="(position, index) in positions" :key="index" :value="position.id">{{ position.name }}</option>
                    </select>
                </form-item>
            </div>

            <div class="col-md-3">
                <form-item label="Designation" :errors="formErrors.designation">
                    <input type="text" class="form-control" v-model="formData.designation" :class="formErrors.designation ? 'is-invalid' : ''"  autocomplete="new-password">
                </form-item>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-2">
                <form-item label="Account Type">
                    <select class="form-control" v-model="authType" disabled>
                        <option value="google">Corporate Email</option>
                        <option value="active_directory">Active Directory</option>
                    </select>
                </form-item>
            </div>
            <div class="col-md-3">
                <form-item label="Username" :errors="formErrors.username">
                    <input type="text" class="form-control" :value="formData.username" disabled>
                </form-item>
            </div>
            <div class="col-md-3">
                <form-item label="Email Address" :errors="formErrors.email_address">
                    <input type="text" class="form-control" v-model="formData.email_address" :class="formErrors.email_address ? 'is-invalid' : ''" autocomplete="new-password" v-if="formData.auth_type != 'google'">
                    <input type="text" class="form-control" :value="formData.email_address" disabled v-else>
                </form-item>
            </div>

            <div class="col-md-2" v-if="authType">
                <form-item label="">
                    <div class="d-grid gap-2 mt-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-person-fill"></i>
                            Register
                        </button>
                    </div>
                </form-item>
            </div>

            <div class="col-md-2">
                <form-item label="">
                    <div class="d-grid gap-2 mt-2">
                        <a href="/" class="btn btn-danger">
                            <i class="bi bi-x-circle"></i>
                            Cancel
                        </a>
                    </div>
                </form-item>
            </div>
        </div>

    </form>
</template>

<script>
    import Axios from 'axios';
    import debounce from 'lodash/debounce';
    import cloneDeep from 'lodash/cloneDeep';
    import Card from '@/components/Card.vue';
    import FormItem from '@/components/FormItem.vue';

    export default {
        components: {
            Card,
            FormItem,
        },
        mounted() {
            this.formData = {
                ...this.formData,
                ...cloneDeep(this.userData)
            };
            this.authType = this.formData.auth_type;
        },
        props: [
            'formTitle',
            'userData',
            'positions',
            'offices',
        ],
        data() {
            return {
                formData: {
                    first_name: null,
                    middle_name: null,
                    last_name: null,
                    ext_name: null,
                    mobile_number: null,
                    office_id: null,
                    position_id: null,
                    designation: null,
                    username: null,
                    email_address: null,
                },
                formErrors: {},
                authType: null,
            };
        },
        methods: {
            submitForm: debounce(function() {
                Axios.post(route('register.store'), this.formData)
                .then(res => {
                    alert('You have successfully registered. You may now login.');
                    window.location.href = "/";
                })
                .catch(err => {
                    this.formErrors = err.response.data.errors;
                });
            }, 250),
        }
    }
</script>
