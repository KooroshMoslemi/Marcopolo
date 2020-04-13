<template>
    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content bg padding-y border-top">
        <div class="container">

            <div class="row">
                <main class="col-sm-9">

                    <div class="card">
                        <table class="table table-hover shopping-cart-wrap">
                            <thead class="text-muted">
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col" width="120">Quantity</th>
                                <th scope="col" width="120">Price</th>
                                <th scope="col" class="text-right" width="200">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="detail in details" :key="detail.id">
                                <td>
                                    <figure class="media">
                                        <div class="img-wrap"><img :src="'../images'+detail.file" class="img-thumbnail img-sm"></div>
                                        <figcaption class="media-body">
                                            <h6 class="title text-truncate">{{detail.GeneralName}} </h6>
                                            <dl class="dlist-inline small">
                                                <dt>Model: </dt>
                                                <dd>{{detail.ModelName}}</dd>
                                            </dl>
                                            <dl class="dlist-inline small">
                                                <dt>Brand: </dt>
                                                <dd>{{detail.BrandName}}</dd>
                                            </dl>
                                        </figcaption>
                                    </figure>
                                </td>
                                <td>
                                    <select @change="FixQuantity($event,detail.id)" v-model="detail.Quantity" class="form-control">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="price-wrap">
                                        <var class="price">USD {{Math.round(detail.Price * detail.Quantity * 100) /100}}</var>
                                        <small class="text-muted">(USD {{detail.Price}} each)</small>
                                    </div> <!-- price-wrap .// -->
                                </td>
                                <td class="text-right">
                                    <button :id="'Remove'+detail.id" type="button" v-on:click="RemoveItem(detail.id)" class="btn btn-danger"> × Remove</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div> <!-- card.// -->

                </main> <!-- col.// -->
                <aside class="col-sm-3">
                    <!-- TODO: show message to user here... -->
                    <dl class="dlist-align">
                        <dt>Total price: </dt>
                        <dd class="text-right">USD {{Math.round(totalPrice*100)/100}}</dd>
                    </dl>
                    <dl class="dlist-align">
                        <dt>Discount:</dt>
                        <dd class="text-right">USD 0</dd>
                    </dl>
                    <dl class="dlist-align h4">
                        <dt>Total:</dt>
                        <dd class="text-right"><strong>USD {{Math.round(totalPrice*100)/100}}</strong></dd>
                    </dl>
                    <hr>

                    <div class="radio d-inline">
                        <label><input v-model="option" type="radio" name="optradio" checked :value="'visa'"><img src="../../../public/images/icons/pay-visa.png"></label>
                    </div>
                    <div class="radio d-inline ml-4">
                        <label><input v-model="option" type="radio" name="optradio" :value="'master'"><img src="../../../public/images/icons/pay-mastercard.png"></label>
                    </div>
                    <br>


                    <button @click="Pay" type="button" class="btn btn-warning btn-lg btn-block">Buy</button>


                </aside> <!-- col.// -->
            </div>

        </div> <!-- container .//  -->
    </section>
    <!-- ========================= SECTION CONTENT END// ========================= -->
</template>

<script>
    export default {
        data(){
            return{
                orders:[],
                details:[],
                totalPrice:0,
                discount:0,
                option:'visa'
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            if(localStorage.orders){
            this.orders = JSON.parse(localStorage.orders);


            this.orders.forEach((order)=> {
                axios.get('/product_detail_with_main_photo/'+order.Id)
                    .then(data=>{
                        data.data[0].Quantity = order.Quantity;
                        this.details.push(data.data[0]);
                        this.totalPrice += Math.round((data.data[0].Price * data.data[0].Quantity) * 100) / 100;
                    })
                    .catch(err=>{
                        console.log(err);
                    });
            });
            }

        },
        methods:{
            RemoveItem(id) {
                let index = 0;
                let removeAt = 0;
                this.details.forEach((detail)=> {
                    if(detail.id === id)
                    {
                        removeAt = index;
                        this.totalPrice -= Math.round((detail.Price * detail.Quantity)*100)/100;
                    }
                    index++;

                });
                this.details.splice(removeAt,1);

                index = 0;
                removeAt = 0;
                this.orders.forEach((order)=> {
                    if(order.Id === id)
                    {
                        removeAt = index;
                    }
                    index++;
                });
                this.orders.splice(removeAt,1);
                app.orders = this.orders;
                localStorage.orders = JSON.stringify(this.orders);
                app.basketCount = app.basketCount - 1;
                localStorage.basketCount = app.basketCount;

            },
            FixQuantity(event,id) {
                let newQuantity = event.target.value;
                let index = 0;
                this.orders.forEach((order)=> {
                    if(order.Id === id)
                    {
                        this.orders[index].Quantity = newQuantity;
                        app.orders = this.orders;
                        localStorage.orders = JSON.stringify(this.orders);
                    }
                    index++;
                });


                index = 0;
                this.totalPrice = 0;
                this.details.forEach((detail)=> {
                    if(detail.id === id)
                    {
                        this.details[index].Quantity = newQuantity;
                        this.totalPrice += Math.round((detail.Price * newQuantity)*100)/100;
                    }
                    else{
                        this.totalPrice += Math.round((detail.Price * detail.Quantity)*100)/100;
                    }
                    index++;
                });


            },
            Pay(){
                let request = {};
                request.totalPrice = this.totalPrice;
                request.option = this.option;
                request.orders = this.orders;
                axios.post('/pay', request)
                    .then(response => {
                        if(response.data === 'fail')
                        {
                            swal.fire(
                                'Opps!',
                                'Please login to your account first',
                                'warning'
                            );
                        }
                        else {
                            let paymentId = response.data;
                            this.ResetBasket();
                            swal.fire(
                                'Congrats!',
                                'Your payment was stored with id of ' + paymentId,
                                'success'
                            );
                        }
                })
                    .catch(err =>{
                        console.log(err);
                        swal.fire(
                            'Opps!',
                            'Something went wrong during storing your payment',
                            'warning'
                        );
                    });
            },
            ResetBasket()
            {
                this.totalPrice = 0;
                this.orders = [];
                this.details = [];
                app.orders = [];
                app.basketCount = 0;
                localStorage.basketCount = 0;
                localStorage.orders = JSON.stringify(app.orders);
            }
        }
    }
</script>
