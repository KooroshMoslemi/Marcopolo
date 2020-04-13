<template>
    <section class="section-request bg padding-y-sm">
        <div class="container">
            <header class="section-heading heading-line">
                <h4 class="title-section bg text-uppercase">Search Results</h4>
            </header>

            <div class="row-sm">

                <div v-for="result in results.data" :key="result.ProductId" class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <figure class="card card-product">
                        <div class="img-wrap"> <img :src="'../images'+result.file"></div>
                        <figcaption class="info-wrap">
                            <h6 class="title "><a href="" @click.prevent="Redirect(result.ProductId)">{{result.GeneralName}}</a></h6>
<!--                            <h6 class="title "><router-link :to="{ name: 'detail', params: { ProductId: result.ProductId }}">{{result.GeneralName}}</router-link></h6>-->

                            <div class="price-wrap">
                                <span class="price-new">${{result.Price}}</span>
                            </div> <!-- price-wrap.// -->

                        </figcaption>
                    </figure> <!-- card // -->
                </div> <!-- col // -->


            </div> <!-- row.// -->


            <pagination :data="results" @pagination-change-page="getResults"></pagination>

        </div><!-- container // -->
    </section>
</template>

<script>
    export default {
        data(){
            return{
                results:{},
            }
        },
        mounted() {
            //console.log('Component mounted.');
        },
        created() {
            this.getMainQueryResult();

            Fire.$on('FilterEvent' , (minPrice , maxPrice , omitedBrands)=>{
                this.Filter(minPrice,maxPrice , omitedBrands);
            });
        },
        methods:{
            getResults(page = 1) {
                axios.get(`/category-page-content-detail?page=${page}&q=${localStorage.query}`)
                    .then(response => {
                        this.results = response.data;
                    })
                    .catch((err)=>{
                        console.log(err);
                    });
            },
            getMainQueryResult(){
                console.log('method called');
                axios.get('/category-page-content-detail?q='+localStorage.query)
                    .then((data) =>{
                        this.results = data.data;
                    })
                    .catch((err)=>{
                        console.log(err);
                    });
            },
            Redirect(ProductId)
            {
                //router.push({ name: 'detail', params: { ProductId: ProductId }});
                //router.push({ name: 'detail', query: { pid: ProductId } });
                window.location.href  = 'http://marcopolo.test/detail/' + ProductId;
                //this.$router.push({ name: 'detail', query: { pid: ProductId } });
            },
            Filter(minPrice , maxPrice ,omitedBrands){
                //console.log('event fired = ' + minPrice + ' : ' + maxPrice);
                let query = localStorage.query;
                //axios.get(`/category-page-content-detail?q=${query}&minP=${minPrice}&maxP=${maxPrice}`)

                axios.get('/category-page-content-detail', {
                    params: {
                        omit: omitedBrands,
                        q:query,
                        minP:minPrice,
                        maxP:maxPrice
                    },
                    paramsSerializer: params => {
                        return qs.stringify(params)
                    }
                })
                    .then((data)=>{
                        this.results = data.data;
                    })
                    .catch((err)=>{
                        console.log(err);
                    })
            }
        }
    }
</script>
