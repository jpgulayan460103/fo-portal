<template>
    <div class="mb-3">
        <label class="form-label">{{ label }}</label>
            <slot></slot>
        <div class="form-text" v-if="help">{{ help }}</div>
        <div class="form-text error" v-for="(error, index) in errors" :key="index">{{ error }}</div>
    </div> 
</template>

<script>
    export default {
        props: [
            'label',
            'help',
            'helpType',
            'errors',
        ],
        watch: {

        }

    }
</script>

<style scoped>
.error{
    color: red;
}
</style>