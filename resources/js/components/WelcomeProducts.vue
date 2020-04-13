<template>
    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content padding-y-sm bg">
        <div class="container">

            <header class="section-heading heading-line">
                <h4 class="title-section bg">{{title}}</h4>
            </header>

            <div class="card">
                <div class="row no-gutters">
                    <div class="col-md-3">

                        <article href="#" class="card-banner h-100 bg2">
                            <div class="card-body zoom-wrap">
                                <h5 class="title">{{otherTitle}}</h5>
                                <p>{{description}}</p>
                                <a href="#" class="btn btn-warning">Explore</a>
                                <img src="../../../public/images/items/item-sm.png" height="200" class="img-bg zoom-in">
                            </div>
                        </article>

                    </div> <!-- col.// -->
                    <div class="col-md-9">
                        <ul class="row no-gutters border-cols">
                            <li v-for="item in items2" :key="item.id" class="col-6 col-md-3">
                                <a :href="'/detail/' + item.id" class="itembox">
                                    <div class="card-body">
                                        <p class="word-limit">{{item.general_name }} </p>
                                        <img class="img-sm" :src="'./images/'+item.file">
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <ul class="row no-gutters border-cols">
                            <li v-for="item in items1" :key="item.id" class="col-6 col-md-3">
                                <a :href="'/detail/' + item.id" class="itembox">
                                    <div class="card-body">
                                        <p class="word-limit">{{item.general_name }} </p>
                                        <img class="img-sm" :src="'./images/'+item.file">
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div> <!-- col.// -->
                </div> <!-- row.// -->

            </div> <!-- card.// -->

        </div> <!-- container .//  -->
    </section>
    <!-- ========================= SECTION CONTENT END// ========================= -->
</template>

<script>
    export default {
        data(){
           return{
               items1:{},
               items2:{}
           }
        },
        methods:{
            getNewProducts(){

                if(this.title === "New")
                {
                    console.log("first time in NEW");
                    axios.get('/new')
                        .then(data=>{
                            this.items1 = data.data.slice(0,4);
                            this.items2 = data.data.slice(4,8);
                        })
                        .catch(err=>{
                            console.log(err);
                        });
                }
                else if(this.title === "OFF")
                {
                    console.log("second time in OFF");
                    axios.get('/off')
                        .then(data=>{
                            this.items1 = data.data.slice(0,4);
                            this.items2 = data.data.slice(4,8);
                        })
                        .catch(err=>{
                            console.log(err);
                        });
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            this.getNewProducts();
        },
        props: ['title','otherTitle','description']
    }
</script>
