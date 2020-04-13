<template>
   <div class="container">
      <br>
      <div class="row" v-if="$gate.isAdminORDeveloper()" >
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  <h3 class="card-title">Users Table</h3>

                  <div class="card-tools">
                     <button @click="createModal" class="btn btn-success">
                        Add New <i class="fas fa-user-plus fa-fw"></i></button>
                  </div>
               </div>
               <!-- /.card-header -->
               <div class="card-body table-responsive p-0">
                  <table class="table table-hover">
                     <thead>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Registeration Date</th>
                        <th>Modify</th>
                     </tr>
                     </thead>
                     <tbody>
                     <tr v-for="user in users.data" :key="user.id">
                        <td>{{user.id}}</td>
                        <td>{{user.name}}</td>
                        <td>{{user.email}}</td>
                        <td>{{user.type | upText}}</td>
                        <td>{{user.created_at | myDate}}</td>
                        <td>
                           <a href="#" @click="editModal(user)">
                              <i class="fa fa-edit blue"></i>
                           </a>
                           /
                           <a href="#" @click="deleteUser(user.id)">
                              <i class="fa fa-trash red"></i>
                           </a>
                        </td>
                     </tr>
                     </tbody>
                  </table>
               </div>
               <!-- /.card-body -->
               <div class="card-footer">
                  <pagination :data="users" @pagination-change-page="getResults"></pagination>
               </div>
            </div>
            <!-- /.card -->
         </div>
      </div>


      <div class="row mt-5" v-if="!$gate.isAdminORDeveloper()">
         <not-found></not-found>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 v-show="!editmode" class="modal-title" id="addNewLabel">Add New</h5>
                  <h5 v-show="editmode" class="modal-title" id="editLabel">Edit User</h5>
                  <button v-on:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <form @submit.prevent="editmode ? updateUser(): createUser()">
                  <div class="modal-body">

                     <div class="form-group">
                        <input v-model="form.name" type="text" name="name" placeholder="Name"
                               class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                     </div>

                     <div class="form-group">
                        <input v-model="form.email" type="email" name="email"
                               placeholder="Email Address"
                               class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>
                     </div>

<!--                     <div class="form-group">-->
<!--                        <textarea v-model="form.bio" name="bio" id="bio"-->
<!--                                  placeholder="Short bio for user (Optional)"-->
<!--                                  class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>-->
<!--                        <has-error :form="form" field="bio"></has-error>-->
<!--                     </div>-->

                     <div class="form-group">
                        <select name="type" v-model="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                           <option value="">Select User Role</option>
                           <option v-for="role in roles" :key="role.id" :value="role.id">{{role.name}}</option>
<!--                           <option value="user">Standard User</option>-->
<!--                           <option value="author">Author</option>-->
                        </select>
                        <has-error :form="form" field="type"></has-error>
                     </div>

                     <div class="form-group">
                        <input v-model="form.password" type="password" name="password" id="password"
                               class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
                     </div>


                  </div>
                  <div class="modal-footer">
                     <button v-on:click="resetForm" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                     <button v-show="editmode" type="submit" class="btn btn-success">Edit User</button>
                     <button v-show="!editmode" type="submit" class="btn btn-primary">Create User</button>
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
            editmode:false,
            users:{},
            roles:{},
            form: new Form({
               id:'',
               name: '',
               email: '',
               password: '',
               type: '',
            })
         }
      },
      methods:{
         baseUrl(){
           return 'http://marcopolo.test/';
         },
         getResults(page = 1) {
            axios.get(this.baseUrl()+'api/user?page=' + page)
                    .then(response => {
                       this.users = response.data;
                    });
         },
         createModal(){
            this.editmode = false;
            this.resetForm();
            $('#addNew').modal('show');
         },
         editModal(user){
            this.editmode = true;
            this.resetForm();
            this.form.fill(user);
            console.log('********');
            console.log(user.type);
            console.log(this.GetRoleId(user.type));
            this.form.type = this.GetRoleId(user.type);
            $('#addNew').modal('show');
         },
         updateUser(){
            //this.$Progress.start();
            this.form.put(this.baseUrl()+'api/user/'+this.form.id)
                    .then(()=>{
                       $('#addNew').modal('hide');
                       toast.fire({
                          type: 'success',
                          title: 'User updated successfully'
                       });
                       //this.$Progress.finish();
                       Fire.$emit('Reload');
                    })
                    .catch(()=>{
                       //this.$Progress.fail();
                    });
         },
         loadUsers(){
            //if(this.$gate.isAdmin()) {
            //console.log("loadUsers "+this.$gate.isAdminORAuthor().toString());
            if(this.$gate.isAdminORDeveloper()) {
               axios.get(this.baseUrl()+'api/user').then(res =>
                       this.users = res.data
               )
            }
         },
         loadRoles(){
            axios.get(this.baseUrl()+'api/roles')
                    .then(response => {
                       this.roles = response.data;
                    });
         },
         GetRoleId(roleName){
            let Id = 0;
            this.roles.forEach((role)=>{
               //console.log(role.name + ' : ' + roleName + ' : ' + role.id);
               if(role.name.toString() === roleName.toString())
               {
                 Id =  role.id
               }
            });
            return Id;
         },
         createUser(){
            //this.$Progress.start();
            this.form.post(this.baseUrl()+'api/user')
                    .then(()=>{
                       Fire.$emit('Reload');

                       $('#addNew').modal('hide');

                       toast.fire({
                          type: 'success',
                          title: 'User created successfully'
                       });

                       //this.$Progress.finish();
                       this.resetForm();
                    })
                    .catch(err => {
                       console.log(err);
                      // this.$Progress.finish();
                    });
         },
         deleteUser(id){
            swal.fire({
               title: 'Are you sure?',
               text: "You won't be able to revert this!",
               type: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
               if(result.value) {
                  //Send request to the server

                  axios.get(this.baseUrl()+'api/deactivate/'+id)
                          .then(() => {
                             swal.fire(
                                     'Deleted!',
                                     'Your file has been deleted.',
                                     'success'
                             );
                             Fire.$emit('Reload');
                          })
                          .catch(() =>{
                             swal.fire('Failed!', 'There was something wrong', 'warning');
                          });
               }

            });
         },
         resetForm(){
            // this.form.name= '';
            // this.form.email= '';
            // this.form.password='';
            // this.form.type= '';
            // this.form.bio= '';
            // this.form.photo= '';
            this.form.reset();

            this.form.errors.clear("name");
            this.form.errors.clear("email");
            this.form.errors.clear("password");
            this.form.errors.clear("type");
            // this.form.errors.clear("bio");
            // this.form.errors.clear("photo");

         }
      },
      created() {
         Fire.$on('searching',() => {
            //this.$Progress.start();
            let query = this.$parent.search;
            axios.get(this.baseUrl()+'api/findUser?q='+query)
                    .then((data) =>{
                       this.users = data.data;
                       //this.$Progress.finish();
                    })
                    .catch(()=>{
                      // this.$Progress.fail();
                    });
         });
         this.loadUsers();
         //setInterval(() =>this.loadUsers(),3000);
         Fire.$on('Reload',() => {
            this.loadUsers();
         });
         this.loadRoles();
      }
   }
</script>
