<template>
    <div >
        <hooper :settings = 'hooperSettings'>
            <slide  v-for="(item,index) in films" :key="index">
                <a :href = "'/films/'+item.id">
                    <div class="carousel-item">
                        <div>
                            <div class="img-container">
                                <img :src="'/storage/'+item.img" alt="Avatar" class="image">
                                <div class="overlay">
                                    <div class="text">ПОДРОБНЕЕ</div>
                                </div>
                            </div>
                            <div class="film-title"><a :href = "'/films/'+item.id">{{item.name}}</a></div>
                        </div>
                    </div>
                </a>
            </slide>
            <hooper-navigation slot="hooper-addons"></hooper-navigation>
        </hooper>
    </div>
</template>

<script>
    import {Hooper, Slide, Navigation as HooperNavigation,} from 'hooper';
    import 'hooper/dist/hooper.css';

    export default {
        props:['films'],
        components: {
            Hooper,
            Slide,
            HooperNavigation},
        data(){
            return{
                // imagePath: '/storage/'+this.item.img,
                hooperSettings: {
                    infiniteScroll: true,
                    centerMode: true,
                    wheelControl:false,
                    breakpoints: {
                        2400: {
                            itemsToShow: 5
                        },
                        1800: {
                            itemsToShow: 6
                        },
                        1500: {
                            itemsToShow: 6
                        },
                        1100: {
                            itemsToShow: 5
                        },
                        0: {
                            itemsToShow: 4
                        }
                    }

                }
            }

        }
    }
</script>

<style scoped>
    .carousel-item{
        height: 100%;
        display: flex;
        justify-content: center;
    }
    .carousel-item img{
        background-color: #00cdbe;
        height: 300px;
        border-radius: 5px;

    }
    .carousel-item .film-title{
        display: flex;
        justify-content: center;
        font-family: var(--Abel);
    }
    .carousel-item .film-title :hover{
        color: var(--text-main);
    }
    .hooper{
        height: 350px;
    }
    .img-container {
        position: relative;
        /*width: 50%;*/
    }

    .image {
        display: block;
        height: auto;
    }

    .overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100%;
        width: 100%;
        opacity: 0;
        transition: .7s ease;
        background-color: #000;
    }

    .img-container:hover .overlay {
        opacity: 0.5;
    }

    .text {
        color: white;
        font-size: 20px;
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        text-align: center;
    }


</style>
