<template>
    <div class="container">
        <div class="slideshow-container">

            <!-- Full-width images with number and caption text -->
            <div class="mySlides fade" v-for="(item,index) in films" :key="index">
                <slider-item-component :item = "item"></slider-item-component>
            </div>


            <!-- Next and previous buttons -->
            <a class="prev" :onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" :onclick="plusSlides(1)">&#10095;</a>

        </div>

        <br>
        <div style="text-align:center;">
            <span class="dott" :onclick="currentSlide(1)"></span>
            <span class="dott" :onclick="currentSlide(2)"></span>
            <span class="dott" :onclick="currentSlide(3)"></span>
            <span class="dott" :onclick="currentSlide(4)"></span>
        </div>

    </div>
</template>

<script>
    export default {
        props:[
            'films'
        ],
        data(){
            return{
                imagePath: '/storage/',
                slideIndex1:1,
            }
        },
        computed:{

        },
        created() {
            this.showSlides(1);
            // let timer = setInterval("plusSlides(1)",5000);
        },
        methods:{
            plusSlides(n) {
                // this.slideIndex1 += n;
                // this.showSlides(this.slideIndex1);
            },
            currentSlide(n) {
                let slideIndex1 = 1;
                this.showSlides(slideIndex1);
                this.showSlides(slideIndex1 = n);
            },
            showSlides(n) {
                // let i;
                // let slides = document.getElementsByClassName('mySlides');
                // let dots = document.getElementsByClassName("dott");
                // if (n > slides.length) {this.slideIndex1 = 1}
                // if (n < 1) {this.slideIndex1 = slides.length}
                // for (i = 0; i < slides.length; i++) {
                //     slides[i].style.display = "none";
                // }
                // for (i = 0; i < dots.length; i++) {
                //     dots[i].className = dots[i].className.replace(" activee", "");
                // }
                // slides[this.slideIndex1-1].style.display = "block";
                // dots[this.slideIndex1-1].className += " activee";
            }
        }
    }








</script>

<style>
    /* * {box-sizing:border-box} */

    /* Slideshow container */


    /* Hide the images by default */
    .mySlides {
        display: none;
    }

    .mySlides2 {
        display: none;
    }

    /* Next & previous buttons */
    .prev, .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        margin-top: -22px;
        padding: 16px;
        color: white;
        font-weight: bold;
        font-size: 18px;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
        z-index: 150;
    }

    /* Position the "next button" to the right */
    .next {
        right: 0;
        border-radius: 3px 0 0 3px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .prev:hover, .next:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }


    /* The dots/bullets/indicators */
    .dott {
        cursor: pointer;
        height: 10px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbb;
        border-radius: 3px;
        display: inline-block;
        transition: background-color 0.6s ease;
    }

    .activee, .dott:hover {
        background-color: #00cdbe;
    }

    /* Fading animation */
    .fade {
        -webkit-animation-name: fade;
        -webkit-animation-duration: 1.5s;
        animation-name: fade;
        animation-duration: 1.5s;
    }

    @-webkit-keyframes fade {
        from {
            opacity: .4
        }
        to {
            opacity: 1
        }
    }

    @keyframes fade {
        from {
            opacity: .4
        }
        to {
            opacity: 1
        }
    }


</style>
