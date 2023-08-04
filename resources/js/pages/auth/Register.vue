<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <card>
                    <template v-slot:header>Registration Form</template>
                    <user-information-form
                        form-title="PORTAL REGISTRATION"
                        :user-data="userData"
                        :positions="positions"
                        :offices="offices"
                    />
                </card>
            </div>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios';
    import debounce from 'lodash/debounce';
    import Card from '@/components/Card.vue';
    import UserInformationForm from '@/components/UserInformationForm.vue';

    export default {
        components: {
            Card,
            UserInformationForm,
        },
        props: [
            'userData',
            'positions',
            'offices',
        ],
        mounted() {

        },
        data() {
            return {
                formData: {},
                formErrors: {}
            };
        },
        methods: {

        }
    }
</script>
