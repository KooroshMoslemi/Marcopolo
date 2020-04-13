<template>

    <div class="card">
        <!-- Modal -->
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <article class="card-body mx-auto" style="max-width: 400px;">
                            <h4 class="card-title mt-3 text-center">Create Account</h4>
                            <form @submit.prevent="createUser()">

                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    </div>
                                    <input v-model="form.name" name="name" class="form-control" placeholder="Full name" type="text"
                                           :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div> <!-- form-group// -->

                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                    </div>
                                    <input v-model="form.email" name="email" class="form-control" placeholder="Email address" type="email"
                                           :class="{ 'is-invalid': form.errors.has('email') }">
                                    <has-error :form="form" field="email"></has-error>
                                </div> <!-- form-group// -->

                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input v-model="form.password" name="password" class="form-control" placeholder="Password" type="password"
                                           :class="{ 'is-invalid': form.errors.has('password') }">
                                    <has-error :form="form" field="password"></has-error>
                                </div> <!-- form-group// -->

                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input v-model="form.password_confirmation" name="password_confirmation" class="form-control" placeholder="Password Confirmation" type="password"
                                           :class="{ 'is-invalid': form.errors.has('password_confirmation') }">
                                    <has-error :form="form" field="password_confirmation"></has-error>
                                </div> <!-- form-group// -->

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block"> Create Account  </button>
                                    <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal"> Close  </button>
                                </div> <!-- form-group// -->

                            </form>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
    export default {
        name: "RegisterComponent",
        data(){
            return{
                form: new Form({
                    id:'',
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                })
            }
        },
        methods:{
            createUser(){
                this.form.post('/cregister')
                    .then(()=>{
                        this.resetForm();
                        toast.fire({
                            type: 'success',
                            title: 'Your Account Created Successfully'
                        });
                    })
                    .catch(err=>{
                        console.log(err);
                    });
            },
            resetForm(){
                $('#exampleModalLong').modal('hide');
                this.form.reset();
                this.form.errors.clear("name");
                this.form.errors.clear("email");
                this.form.errors.clear("password");
                this.form.errors.clear("password_confirmation");
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            console.log('onCreate');
            Fire.$on('RegisterUserEvent',() => {
                console.log('Event Fired!!!!');
                $('#exampleModalLong').modal('show');
            });
        }
    }
</script>
