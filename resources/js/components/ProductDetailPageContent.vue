<template>


<div class="container">
    <main class="card">
        <div class="row no-gutters">
            <aside class="col-sm-6 border-right">
                <article class="gallery-wrap">
                    <div v-if="Object.keys(media).length > 0" class="img-big-wrap">
                        <div> <a :href="'../images'+media[0].file" data-fancybox=""><img :src="'../images'+media[0].file"></a></div>
                    </div> <!-- slider-product.// -->
                    <div v-if="Object.keys(media).length > 0" class="img-small-wrap">
                        <div v-for="photo in media" :key="photo.id" class="item-gallery"><a :href="'../images'+photo.file" data-fancybox=""> <img :src="'../images'+photo.file"></a></div>
                    </div> <!-- slider-nav.// -->
                </article> <!-- gallery-wrap .end// -->
            </aside>
            <aside class="col-sm-6">
                <article class="card-body">
                    <!-- short-info-wrap -->
                    <h3 class="title mb-3">{{details.GeneralName}}</h3>

                    <div class="mb-3">
                        <var class="price h3 text-warning">
                            <span class="currency">US $</span><span class="num">{{details.Price}}</span>
                        </var>
                    </div> <!-- price-detail-wrap .// -->
                    <dl>
                        <dt>Description</dt>
                        <dd><p>{{details.Description}} </p></dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-3">Brand:</dt>
                        <dd class="col-sm-9">{{details.BrandName}}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-3">Category:</dt>
                        <dd class="col-sm-9">{{details.CategoryName}}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-sm-3">Model:</dt>
                        <dd class="col-sm-9">{{details.ModelName}}</dd>
                    </dl>
                    <div class="rating-wrap">

                        <ul class="rating-stars">
                            <li style="width:80%" class="stars-active">
                                <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </li>
                            <li>
                                <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </li>
                        </ul>
                        <div  class="label-rating">132 reviews</div>
                        <div class="label-rating">154 orders </div>
                    </div> <!-- rating-wrap.// -->
                    <hr>
                    <div class="row">
                        <div class="col-sm-5">
                            <dl class="dlist-inline">
                                <dt>Quantity: </dt>
                                <dd>
                                    <select v-model="quantity" class="form-control form-control-sm" style="width:70px;">
                                        <option> 1 </option>
                                        <option> 2 </option>
                                        <option> 3 </option>
                                    </select>
                                </dd>
                            </dl>  <!-- item-property .// -->
                        </div> <!-- col.// -->
                    </div> <!-- row.// -->
                    <hr>
                    <a href="#" v-on:click="AddToBasket()" class="btn  btn-warning">  Add To My Basket </a>
                    <!-- short-info-wrap .// -->
                </article> <!-- card-body.// -->
            </aside> <!-- col.// -->
        </div> <!-- row.// -->
    </main> <!-- card.// -->




    <!-- PRODUCT DETAIL -->
    <article class="card mt-3">
        <div class="card-body">
            <h4>Detail overview</h4>
            <div v-html="details.Overview"></div>
        </div> <!-- card-body.// -->
    </article> <!-- card.// -->

    <!-- PRODUCT DETAIL .// -->
</div>
    

</template>

<script>
    export default {
        data(){
            return{
                details:{},
                media:{},
                reviews:'',
                quantity:''
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
          AddToBasket(){
              if(this.quantity !== "")
              {
                  Fire.$emit('BasketEvent',this.details.id,this.quantity);
              }
              else{
                  toast.fire({
                      type: 'warning',
                      title: 'Please specify quantity first'
                  });
              }

          }
        },
        created(){
            axios.get('/product_detail_media/'+this.pid)
                .then(data=>{
                    this.media = data.data;
                })
                .catch(err=>{
                    console.log(err);
                });


            axios.get('/product_detail/'+this.pid)
                .then(data=>{
                   // console.log(data.data);
                    this.details = data.data[0];
                })
                .catch(err=>{
                    console.log(err);
                });
        },
        props: ['pid']
    }
</script>
