<template>
    <aside class="col-xl-2 col-md-3 col-sm-12">
        <div class="card mt-3">
            <div class="card-header">
                You may like
            </div>
            <div class="card-body row">

                <div v-for="rand in rands" :key="rand.ProductId" class="col-md-12 col-sm-3">
                    <figure class="item border-bottom mb-3">
                        <a :href="'../images'+rand.file" class="img-wrap"> <img :src="'../images'+rand.file" class="img-md"></a>
                        <figcaption class="info-wrap">
                            <a @click.prevent="Redirect(rand.ProductId)" href="" class="title">{{rand.GeneralName}}</a>
                            <div class="price-wrap mb-3">
                                <span class="price-new">${{rand.Price}}</span>
                            </div> <!-- price-wrap.// -->
                        </figcaption>
                    </figure> <!-- card-product // -->
                </div> <!-- col.// -->

<!--                <div class="col-md-12 col-sm-3">-->
<!--                    <figure class="item border-bottom mb-3">-->
<!--                        <a class="img-wrap"> <img src="../../../public/images/items/3.jpg" class="img-md"></a>-->
<!--                        <figcaption class="info-wrap">-->
<!--                            <a href="#" class="title">The name of product</a>-->
<!--                            <div class="price-wrap mb-3">-->
<!--                                <span class="price-new">$280</span>-->
<!--                            </div> &lt;!&ndash; price-wrap.// &ndash;&gt;-->
<!--                        </figcaption>-->
<!--                    </figure> &lt;!&ndash; card-product // &ndash;&gt;-->
<!--                </div> &lt;!&ndash; col.// &ndash;&gt;-->
<!--                -->
<!--                <div class="col-md-12 col-sm-3">-->
<!--                    <figure class="item border-bottom mb-3">-->
<!--                        <a href="#" class="img-wrap"> <img src="../../../public/images/items/4.jpg" class="img-md"></a>-->
<!--                        <figcaption class="info-wrap">-->
<!--                            <a href="#" class="title">The name of product</a>-->
<!--                            <div class="price-wrap mb-3">-->
<!--                                <span class="price-new">$280</span>-->
<!--                            </div> &lt;!&ndash; price-wrap.// &ndash;&gt;-->
<!--                        </figcaption>-->
<!--                    </figure> &lt;!&ndash; card-product // &ndash;&gt;-->
<!--                </div> &lt;!&ndash; col.// &ndash;&gt;-->

            </div> <!-- card-body.// -->
        </div> <!-- card.// -->
    </aside> <!-- col // -->
</template>

<script>
    export default {
        data(){
            return{
                rands:[]
            }
        },
        mounted() {
            //console.log('Component mounted.')
        },
        created() {
            this.Setup();
        },
        methods:{
            Setup(){
                axios.get('/random-products?lim=3')
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
