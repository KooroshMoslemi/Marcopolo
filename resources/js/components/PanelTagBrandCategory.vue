<template>

    <div class="container">

        <br>

        <div class="row">

        <div class="col-md-4">

            <div class="card card-outline card-primary">

                <div class="card-header">

                    <h3 class="card-title">Tag</h3>

                    <div class="card-tools">
                        <button @click="toggle1=!toggle1" class="btn" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            <i v-if="toggle1===false" class="fas fa-plus"></i>
                            <i v-if="toggle1===true" class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="collapse" id="collapseExample">
                    <div class=" card-body">
                        <form action="#" method="post">
                            <div class="input-group">
                                <input id="tag_input" type="text" name="message" placeholder="Tag" class="form-control">
                                <span class="input-group-append">
                      <button @click.prevent="add('add_tag','tag_input')" type="submit" class="btn btn-primary">Add</button>
                    </span>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
            <!-- /.card -->

        </div>


            <div class="col-md-4">
                <div class="card card-outline card-primary">

                    <div class="card-header">

                        <h3 class="card-title">Brand</h3>

                        <div class="card-tools">
                            <button @click="toggle2=!toggle2" class="btn" type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">
                                <i v-if="toggle2===false" class="fas fa-plus"></i>
                                <i v-if="toggle2===true" class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="collapse" id="collapseExample2">
                        <div class=" card-body">
                            <form action="#" method="post">
                                <div class="input-group">
                                    <input id="brand_input" type="text" name="message" placeholder="Brand" class="form-control">
                                    <span class="input-group-append">
                      <button @click.prevent="add('add_brand','brand_input')" type="submit" class="btn btn-primary">Add</button>
                    </span>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
                <!-- /.card -->
            </div>



            <div class="col-md-4">
                <div class="card card-outline card-primary">

                    <div class="card-header">

                        <h3 class="card-title">Category</h3>

                        <div class="card-tools">
                            <button @click="toggle3=!toggle3" class="btn" type="button" data-toggle="collapse" data-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample3">
                                <i v-if="toggle3===false" class="fas fa-plus"></i>
                                <i v-if="toggle3===true" class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="collapse" id="collapseExample3">
                        <div class=" card-body">
                            <form action="#" method="post">
                                <div class="input-group">
                                    <input id="category_input" type="text" name="message" placeholder="Category" class="form-control">
                                    <span class="input-group-append">
                      <button @click.prevent="add('add_category','category_input')" type="submit" class="btn btn-primary">Add</button>
                    </span>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
                <!-- /.card -->
            </div>

        </div>


        <div class="row">


            <div class="col-md-4">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Tag</th>
                                <th style="width: 40px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="tag in tags" :key="tag.id">
                                <td>{{tag.id}}.</td>
                                <td>{{tag.name}}</td>
                                <td><a @click.prevent="createModal('tag',tag.name,tag.id)" href="#"><i class="fas fa-edit p-0"></i></a>
                                /
                                    <a @click.prevent="del('tag',tag.id)" href="#" ><i class="fas fa-trash red"></i></a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>


            <div class="col-md-4">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Brand</th>
                                <th style="width: 40px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="brand in brands" :key="brand.id">
                                <td>{{brand.id}}.</td>
                                <td>{{brand.name}}</td>
                                <td><a @click.prevent="createModal('brand',brand.name,brand.id)" href="#" ><i class="fas fa-edit"></i></a>
                                /
                                    <a @click.prevent="del('brand',brand.id)" href="#" ><i class="fas fa-trash red"></i></a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>



            <div class="col-md-4">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Category</th>
                                <th style="width: 40px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="category in categories" :key="category.id">
                                <td>{{category.id}}.</td>
                                <td>{{category.name}}</td>
                                <td><a @click.prevent="createModal('category',category.name,category.id)" href="#" ><i class="fas fa-edit"></i></a>
                                /
                                    <a @click.prevent="del('category',category.id)" href="#" ><i class="fas fa-trash red"></i></a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>



        </div>


        <!-- Modal -->
        <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editmodalLabel">Edit {{edit_type | upText}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">

                            <div class="form-group">
                                <input v-model="edit_name" type="text" name="name" placeholder="Name"
                                       class="form-control">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button  type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button @click.prevent="edit" type="button" class="btn btn-success">Edit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>


    </div>

</template>

<script>
    export default {
        data(){
            return{
                toggle1:false,
                toggle2:false,
                toggle3:false,
                tags:{},
                brands:{},
                categories:{},

                edit_type:'',
                edit_name:'',
                edit_id:''
            }
        },
        mounted() {
            //console.log('Example Component mounted.')
        },
        created(){
            this.Setup();
        },
        methods:{
            baseUrl(){
                return 'http://marcopolo.test/';
            },
            Setup(){
                axios.get(this.baseUrl()+'api/control_detail')
                    .then((res) => {
                        this.tags = res.data[0];
                        this.brands = res.data[1];
                        this.categories = res.data[2];
                    })
                    .catch((err) =>{
                        console.log(err);
                    });
            },
            add(action , inp_id){
                let name = $('#'+inp_id).val();

                if(name !== '') {

                    axios.post('/api/' + action, {name: name})
                        .then(() => {
                            $('#'+inp_id).val('');
                            this.Setup();
                        })
                        .catch(err => {
                            console.log(err);
                        });
                }
                else{
                    toast.fire({
                        type: 'warning',
                        title: 'Please fill the box first'
                    });
                }
            },
            del(mode , id)
            {
                axios.get('/api/is_used', {
                    params: {
                        mode: mode,
                        id:id,
                    }
                })
                    .then((res) => {

                        if(res.data === 1)
                        {
                            toast.fire({
                                type: 'warning',
                                title: 'Cannot delete because it is in use'
                            });
                        }
                        else{
                            axios.post('/api/del_with_mode', {mode: mode , id:id})
                                .then(() => {
                                    this.Setup();
                                    toast.fire({
                                        type: 'success',
                                        title: 'Done!'
                                    });
                                })
                                .catch(() => {
                                    toast.fire({
                                        type: 'warning',
                                        title: 'Opps,operation failed!!'
                                    });
                                });
                        }


                    })
                    .catch(() => {
                        toast.fire({
                            type: 'warning',
                            title: 'Opps,operation failed!!'
                        });
                    });

            },
            createModal(type, name , id){

                this.edit_type = type;
                this.edit_name = name;
                this.edit_id = id;

                $('#editmodal').modal('show');
            },
            edit(){
                axios.post('/api/edit_with_mode', {mode: this.edit_type,name: this.edit_name , id:this.edit_id})
                    .then(() => {
                        $('#editmodal').modal('hide');
                        this.Setup();
                        toast.fire({
                            type: 'success',
                            title: 'Done!'
                        });
                    })
                    .catch(() => {
                        toast.fire({
                            type: 'warning',
                            title: 'Opps,operation failed!!'
                        });
                    });
            }
        }
    }
</script>
