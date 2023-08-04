<template>
    <card class="zoom">
        <template v-slot:header>
            <div class="text-truncate">{{ data.application_name }}</div>
        </template>
        <div @mouseleave="show = false" class="app-body">
            <div class="app-description-container">
                <div class="app-description">
                    <p>{{ data.application_description }}</p>
                    <button class="btn btn-primary">
                        <i class="bi bi-globe2"></i>
                        Visit
                    </button>
                </div>
            </div>
            <img :src="data.application_image" class="app-image">
        </div>
    </card>
</template>

<script>
    import Card from '@/components/Card.vue';
    export default {
        components: {
            Card,
        },
        props: ['data'],
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

.zoom {
    transition: transform .5s;
    margin: 0 auto;
    cursor: pointer;
}
.zoom .app-description{
    display: none;
}

.zoom:hover {
    transform: scale(1.06);
}
.zoom:hover img {
    transition: opacity 0.3s;
    opacity: 0.2;
}
.zoom:hover .app-description{
    display: block;
}

.app-image{
    height: 100%;
    width: 100%;
    filter: drop-shadow(2px 2px 2px #252525);
}
.app-description p{
    font-weight: bold;
    padding-top: 10px;
    padding-left: 10px;
    padding-right: 30px;
    text-align: justify;
    height: 150px;
}
.app-description-container{
    position: absolute;
    z-index: 1000;
    height: 220px;
}
.app-body{
    height: 220px;
}


</style>
