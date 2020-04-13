<template>
    <div id="abcd" class="container">

        <h4 class="title-text">You may like</h4>


        <carousel :perPage="5">
            <slide v-for="rand in rands" :key="rand.ProductId">
                <figure class="card card-product px-3">
<!--                    <span class="badge-new"> NEW </span>-->
                    <div class="img-wrap"> <img :src="'../images'+rand.file"> </div>
                    <figcaption class="info-wrap text-center">
                        <h6 class="title text-truncate"><a @click.prevent="Redirect(rand.ProductId)" href="">{{rand.GeneralName}}</a></h6>
                    </figcaption>
                </figure> <!-- card // -->
            </slide>
        </carousel>

<!--        <vueper-slides class="no-shadow" :visible-slides="3" :slide-ratio="1/4" :dragging-distance="70">-->
<!--                        <vueper-slide v-for="rand in rands" :key="rand.ProductId" :title="rand.GeneralName" :image="'../images'+rand.file">-->
<!--                        </vueper-slide>-->
<!--        </vueper-slides>-->


    </div>
</template>

<script>

    import { Carousel, Slide } from 'vue-carousel';

    import { VueperSlides, VueperSlide } from 'vueperslides'
    import 'vueperslides/dist/vueperslides.css'
    

    export default {

        components: {
            Carousel,
            Slide,
            VueperSlides, VueperSlide
        },
        data(){
            return{
                rands:[]
            }
        },
        name: "RandomSlider",
        mounted() {
        },
        created() {
            this.Setup();
        },
        methods:{
            Setup(){
                axios.get('/random-products?lim=16')
                    .then((data) => {
                        this.rands = data.data;
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            },
            Redirect(ProductId){
                window.location.href  = 'http://marcopolo.test/detail/' + ProductId;
            }
        }
    }
</script>
