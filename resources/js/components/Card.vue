<template>
    <div class="card">
        <div class="card-header">
            <slot name="header"></slot>
        </div>

        <div class="card-body">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["header"],
    }
</script>
