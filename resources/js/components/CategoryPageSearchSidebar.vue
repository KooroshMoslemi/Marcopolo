<template>
    <div class="container">
        <div class="card card-filter">
            <article class="card-group-item">
                <header class="card-header">
                    <a class="" aria-expanded="true" href="#" data-toggle="collapse" data-target="#collapse22">
                        <i class="icon-action fa fa-chevron-down"></i>
                        <h6 class="title">By Category</h6>
                    </a>
                </header>
                <div style="" class="filter-content collapse show" id="collapse22">
                    <div class="card-body">
                        <form class="pb-3">
                            <div class="input-group">
                                <input id="secondary_query_box" class="form-control" placeholder="Search" type="text">
                                <div class="input-group-append">
                                    <button @click.prevent="PreRedirect" class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>

                        <ul class="list-unstyled list-lg">
                            <li v-for="category in categories" :key="category.CategoryId"><a @click.prevent="Redirect(category.CategoryName)" href="">{{category.CategoryName}} <span class="float-right badge badge-light round">{{category.countCategory}}</span> </a></li>
<!--                            <li><a href="#">Dapibus ac facilisis  <span class="float-right badge badge-light round">3</span>  </a></li>-->
<!--                            <li><a href="#">Morbi leo risus <span class="float-right badge badge-light round">32</span>  </a></li>-->
<!--                            <li><a href="#">Another item <span class="float-right badge badge-light round">12</span>  </a></li>-->
                        </ul>
                    </div> <!-- card-body.// -->
                </div> <!-- collapse .// -->
            </article> <!-- card-group-item.// -->

            <article class="card-group-item">
                <header class="card-header">
                    <a href="#" data-toggle="collapse" data-target="#collapse33">
                        <i class="icon-action fa fa-chevron-down"></i>
                        <h6 class="title">By Price  </h6>
                    </a>
                </header>
                <div class="filter-content collapse show" id="collapse33">
                    <div class="card-body">
                        <input type="text" class="js-range-slider" name="my_range" value="" />
                        <br/>
                        <button @click="applyPriceFilter()" class="btn btn-block btn-outline-primary">Apply</button>
                    </div> <!-- card-body.// -->
                </div> <!-- collapse .// -->
            </article> <!-- card-group-item.// -->



            <article class="card-group-item">
                <header class="card-header">
                    <a href="#" data-toggle="collapse" data-target="#collapse44">
                        <i class="icon-action fa fa-chevron-down"></i>
                        <h6 class="title">By Brand </h6>
                    </a>
                </header>
                <div class="filter-content collapse show" id="collapse44">
                    <div class="card-body">
                        <form>

                            <label v-for="brand in brands" :key="brand.BrandId" class="form-check">
                                <input :id="'checkbox'+brand.BrandId" @change="applyBrandFilter(brand.BrandId)" class="form-check-input" value="" type="checkbox" checked>
                                <span class="form-check-label">
<!--				  	<span class="float-right badge badge-light round">{{brand.countBrand}}</span>-->
				    {{brand.BrandName}}
				                </span>
                            </label>  <!-- form-check.// -->
                        </form>
                    </div> <!-- card-body.// -->
                </div> <!-- collapse .// -->
            </article> <!-- card-group-item.// -->
        </div> <!-- card.// -->
    </div>
</template>

<script>


    export default {
        data(){
            return{
                brands:[],
                categories:[],
                maxPrice:0,
                minPrice:0,
                omitedBrands:[]
            }
        },
        mounted() {
            //console.log('Component mounted.')
        },
        created() {
            this.Setup();
        },
        methods:{
            Setup() {
                axios.get('/category-page-search-sidebar-detail?q=' + localStorage.query)
                    .then((data) => {
                        this.categories = data.data[0];
                        this.brands = data.data[1];
                        this.maxPrice = data.data[2][0]['max(Price)'];
                        this.minPrice = data.data[3][0]['min(Price)'];

                        $(".js-range-slider").ionRangeSlider({
                            type: "double",
                            min: this.minPrice,
                            max: this.maxPrice,
                            from: this.minPrice,
                            to: this.maxPrice,
                            grid: true
                        });
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            },
            applyPriceFilter(){
                let my_range = $(".js-range-slider").data("ionRangeSlider");
                let minPrice = my_range.result.from;
                let maxPrice = my_range.result.to;
                this.minPrice = minPrice;
                this.maxPrice = maxPrice;

                Fire.$emit('FilterEvent',minPrice , maxPrice , this.omitedBrands);


                this.UpdateSideBar();

            },
            applyBrandFilter(BrandId){
                if(!$('#checkbox'+BrandId).is(":checked"))
                {
                    this.omitedBrands.push(BrandId);
                }
                else{
                    var index = this.omitedBrands.indexOf(BrandId);
                    if (index > -1) {
                        this.omitedBrands.splice(index, 1);
                    }
                }

                Fire.$emit('FilterEvent',this.minPrice , this.maxPrice , this.omitedBrands);

                this.UpdateSideBar();
            },
            UpdateSideBar(){
                axios.get('/category-page-search-sidebar-detail', {
                    params: {
                        omit: this.omitedBrands,
                        q:localStorage.query,
                        minP:this.minPrice,
                        maxP:this.maxPrice
                    },
                    paramsSerializer: params => {
                        return qs.stringify(params)
                    }
                })
                    .then((data) => {
                        this.categories = data.data[0];
                        this.brands = data.data[1];
                        this.maxPrice = data.data[2][0]['max(Price)'];
                        this.minPrice = data.data[3][0]['min(Price)'];

                        $(".js-range-slider").ionRangeSlider({
                            type: "double",
                            min: this.minPrice,
                            max: this.maxPrice,
                            from: this.minPrice,
                            to: this.maxPrice,
                            grid: true
                        });
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            },
            Redirect(query){
                app.SearchProduct(query);
                window.location.href = 'http://marcopolo.test/category/';
            },
            PreRedirect()
            {
                let query = $('#secondary_query_box').val();

                if(query !== '') {
                    this.Redirect(query);
                }
                else{
                    toast.fire({
                        type: 'warning',
                        title: 'Please fill the search box first'
                    });
                }
            }

        }
    }
</script>
