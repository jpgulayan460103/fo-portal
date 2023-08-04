<template>

    <div class="mt-2 mb-2">
        <div class="circle-container">
            <img src="images/logo.png" class="circle-img" style="width: 100%; height: 100%;">
        </div>
    </div>

</template>

<script>
    import Axios from 'axios';
    import debounce from 'lodash/debounce';

    export default {
        components: {

        },
        props: [
            'authUser'
        ],
        mounted() {

        },
        data() {
            return {

            };
        },
        methods: {

        }
    }
</script>

<style scoped>
.circle-container {
    width:75px;
    height:75px;
    text-align:center;
    border-radius:50%;
    overflow:hidden;
    margin-left: auto;
    margin-right: auto;
}
.circle-img img {
  min-width:75px;
  max-width:none;
  height:75px;
  margin:0 -100%;
}
</style>
