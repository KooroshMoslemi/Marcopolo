<template>
    <!-- ========================= SECTION MAIN ========================= -->
    <section class="section-main bg padding-y-sm">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="row row-sm">
<!--                        <aside class="col-md-3">-->
<!--                            <h5 class="text-uppercase">Product Categories</h5>-->
<!--                            <ul class="menu-category">-->
<!--                                <li> <a href="#">T-shirt and Dress </a></li>-->
<!--                                <li> <a href="#">Pants and Skirts </a></li>-->
<!--                                <li> <a href="#">Glasses and Watches </a></li>-->
<!--                                <li> <a href="#">Shoes  </a></li>-->
<!--                                <li> <a href="#">Hats  </a></li>-->
<!--                            </ul>-->

<!--                        </aside> &lt;!&ndash; col.// &ndash;&gt;-->
                        <div class="col-md-9">

                            <!-- ================= main slide ================= -->
                            <div class="owl-init slider-main owl-carousel" data-items="1" data-nav="true" data-dots="false">
                                <div class="item-slide">
                                    <img src="../../../public/images/banners/slide1.jpg">
                                </div>
                                <div class="item-slide">
                                    <img src="../../../public/images/banners/slide2.jpg">
                                </div>
                                <div class="item-slide">
                                    <img src="../../../public/images/banners/slide3.jpg">
                                </div>
                            </div>
                            <!-- ============== main slidesow .end // ============= -->

                        </div> <!-- col.// -->
                        <aside class="col-md-3">

                            <h6 class="title-bg bg-secondary"> Popular Products of the Week</h6>
                            <div style="height:280px;">

                                <figure v-for="pup in pups" :key="pup.ProductId" class="itemside has-bg border-bottom" style="height: 33%;">
                                    <img class="img-sm" :src="'../images'+pup.file">
                                    <figcaption class="p-2">
                                        <h6 class="title">{{pup.GeneralName}}</h6>
                                        <a @click.prevent="Redirect(pup.ProductId)" href="">More</a>
                                    </figcaption>
                                </figure>

<!--                                <figure class="itemside has-bg border-bottom" style="height: 33%;">-->
<!--                                    <img class="img-bg" src="../../../public/images/items/1.jpg" height="80">-->
<!--                                    <figcaption class="p-2">-->
<!--                                        <h6 class="title">One request, many offers </h6>-->
<!--                                        <a href="#">More</a>-->
<!--                                    </figcaption>-->
<!--                                </figure>-->
<!--                                <figure class="itemside has-bg border-bottom" style="height: 33%;">-->
<!--                                    <img class="img-bg" src="../../../public/images/items/2.jpg" height="80">-->
<!--                                    <figcaption class="p-2">-->
<!--                                        <h6 class="title">One request, many offers </h6>-->
<!--                                        <a href="#">More</a>-->
<!--                                    </figcaption>-->
<!--                                </figure>-->
                            </div>

                        </aside>
                    </div> <!-- row.// -->
                </div> <!-- card-body .// -->
            </div> <!-- card.// -->

        </div> <!-- container .//  -->
    </section>
    <!-- ========================= SECTION MAIN END// ========================= -->
</template>

<script>
    export default {
        data(){
            return{
                pups:[]
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
           this.Setup();
        },
        methods:{
            Setup(){
                axios.get('/popular-products')
                    .then((data) => {
                        this.pups = data.data;
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
