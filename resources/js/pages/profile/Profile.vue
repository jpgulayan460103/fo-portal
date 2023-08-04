<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <esign />
            </div>
            <div class="col-md-4">
                <information />
            </div>
        </div>
    </div>
</template>

<script>
    import Esign from './components/Esign.vue';
    import Information from './components/Information.vue';
    export default {
        components: {
            Esign,
            Information
        },
        mounted() {
            
        },
        data() {
            return {
                submit: false,
            };
        },
        methods: {
            submitForm(){

            }
        }
    }
</script>
