<template>
    <card>
        <template v-slot:header>User Information</template>
        <form @submit.prevent="submitForm()">
            <form-item label="First Name" :errors="formErrors.firstname">
                <input type="text" v-model="formData.firstname" class="form-control" :class="formErrors.firstname ? 'is-invalid' : ''" >
            </form-item>
            <form-item label="Middle Name" :errors="formErrors.middlename">
                <input type="text" v-model="formData.middlename" class="form-control" :class="formErrors.middlename ? 'is-invalid' : ''" >
            </form-item>
            <form-item label="Last Name" :errors="formErrors.lastname">
                <input type="text" v-model="formData.lastname" class="form-control" :class="formErrors.lastname ? 'is-invalid' : ''" >
            </form-item>
            <form-item label="Ext Name" :errors="formErrors.extname">
                <input type="text" v-model="formData.extname" class="form-control" :class="formErrors.extname ? 'is-invalid' : ''" >
            </form-item>
            <form-item label="Mobile Number" :errors="formErrors.mobile_number">
                <input type="text" v-model="formData.mobile_number" class="form-control" :class="formErrors.mobile_number ? 'is-invalid' : ''" >
            </form-item>
            <form-item label="Designation" :errors="formErrors.designation">
                <input type="text" v-model="formData.designation" class="form-control" :class="formErrors.designation ? 'is-invalid' : ''" >
            </form-item>
            <button type="submit" class="btn btn-primary" :disabled="submit">
                <span>Update Esignature</span>
            </button>
        </form>
    </card>
</template>

<script>
    import Card from '@/components/Card.vue';
    import FormItem from '@/components/FormItem.vue';
    import axios from 'axios';
    
    export default {
        components: {
            Card,
            FormItem
        },
        mounted() {
            
        },
        data() {
            return {
                submit: false,
                formData: {},
                formErrors: {}
            };
        },
        methods: {
            submitForm(){
                axios.post(route('user.information.update'), this.formData)
            }
        }
    }
</script>
