<template>

    <div class="container">

        <br>

        <div class="row" v-if="$gate.isAdminORDeveloper()" >
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Products Table</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>General Name</th>
                                <th>Model Name</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Brandd</th>
                                <th>Modify</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="product in products.data" :key="product.id">
                                <td>{{product.ProductId}}</td>
                                <td>{{product.GeneralName}}</td>
                                <td>{{product.ModelName}}</td>
                                <td>{{product.Price}}</td>
                                <td>{{product.CategoryName}}</td>
                                <td>{{product.BrandName}}</td>
                                <td>
                                    <a href="#" @click="editProduct(product.ProductId)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteProduct(product.ProductId)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="products" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>

    </div>

</template>

<script>
    export default {
        data(){
            return{
                products:{},
            }
        },
        mounted() {
            //console.log('Example Component mounted.')
        },
        created(){
            this.getProducts();
        },
        methods:{
            baseUrl(){
                return 'http://marcopolo.test/';
            },
            deleteProduct(id){
                axios.delete(this.baseUrl()+'/product/'+id)
                    .then((res) => {
                        if(res.data === 1){
                            toast.fire({
                                type: 'success',
                                title: 'Product deleted successfully'
                            });
                        }
                    });
            },
            editProduct(id)
            {
                this.$router.push({name: 'peditproduct', params: { ProductId: id}});
            },
            getResults(page = 1)
            {
                axios.get(this.baseUrl()+'/product?page=' + page)
                    .then(response => {
                        this.products = response.data;
                    });
            },
            getProducts(){
                axios.get(this.baseUrl()+'/product')
                    .then(response => {
                        this.products = response.data;
                    });
            }
        }
    }
</script>
