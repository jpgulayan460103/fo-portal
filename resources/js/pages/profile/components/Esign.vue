<template>
    <card>
        <template v-slot:header>Esignature Form</template>
        <form @submit.prevent="submitForm()">
            <form-item label="Electronic Signature" :errors="formErrors.esignature_file">
                <input type="file" ref="esign" @change="selectESign" class="form-control" :class="formErrors.esignature_file ? 'is-invalid' : ''" >
            </form-item>
            <form-item label="Digital Signature" :errors="formErrors.digi_cert_file">
                <input type="file" ref="dcert" @change="selectDCert" class="form-control" :class="formErrors.digi_cert_file ? 'is-invalid' : ''" >
            </form-item>
            <form-item label="Digital Signature Password" :errors="formErrors.digi_cert_password">
                <input type="text" v-model="formData.digi_cert_password" class="form-control" :class="formErrors.digi_cert_password ? 'is-invalid' : ''" >
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
                formErrors: {},
                selectedESign: null,
                selectedDCert: null,
            };
        },
        methods: {
            submitForm(){
                let formData = new FormData();

                formData.append("esign", this.selectedESign);
                formData.append("dcert", this.selectedDCert);
                formData.append("digi_cert_password", this.formData.digi_cert_password);

                axios.post(route('user.signatures.update'), formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(res => {

                })
                .catch(err => {
                    this.formErrors = err.response.data.errors;
                })
                ;
            },
            selectESign(){
                this.selectedESign = this.$refs.esign.files[0];
            },
            selectDCert(){
                this.selectedDCert = this.$refs.dcert.files[0];
            },

        }
    }
</script>
