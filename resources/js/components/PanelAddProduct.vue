<template>

    <div class="container">
        <br>
        <form @submit.prevent="createProduct">

                <div class="form-group">
                    <input v-model="form.general_name" type="text" name="general_name" placeholder="General Name"
                           class="form-control" :class="{ 'is-invalid': form.errors.has('general_name') }">
                    <has-error :form="form" field="general_name"></has-error>
                </div>

                <div class="form-group">
                    <input v-model="form.model_name" type="text" name="model_name"
                           placeholder="Model Name"
                           class="form-control" :class="{ 'is-invalid': form.errors.has('model_name') }">
                    <has-error :form="form" field="model_name"></has-error>
                </div>

                <div class="form-group">
                    <input v-model="form.price" type="text" name="price"
                           placeholder="Price($USD)"
                           class="form-control" :class="{ 'is-invalid': form.errors.has('price') }">
                    <has-error :form="form" field="price"></has-error>
                </div>

                <div class="form-group">
                    <textarea v-model="form.description" name="description"
                           placeholder="Short Description"
                           class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                    <has-error :form="form" field="description"></has-error>
                </div>

                <div class="form-group">
                    <textarea id="textarea_overview" v-model="form.overview" name="overview"
                              placeholder="Overview"
                              class="form-control tiny" :class="{ 'is-invalid': form.errors.has('overview') }"></textarea>
                    <has-error :form="form" field="overview"></has-error>
                </div>

                <div class="form-group">
                    <select name="type" v-model="form.category_id"  class="form-control" :class="{ 'is-invalid': form.errors.has('category_id') }">
                        <option value="">Select Product Category</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                    </select>
                    <has-error :form="form" field="category_id"></has-error>
                </div>


                <div class="form-group">
                    <select name="type" v-model="form.brand_id"  class="form-control" :class="{ 'is-invalid': form.errors.has('brand_id') }">
                        <option value="">Select Product Brand</option>
                        <option v-for="brand in brands" :key="brand.id" :value="brand.id">{{brand.name}}</option>
                    </select>
                    <has-error :form="form" field="brand_id"></has-error>
                </div>


                <div class="row">
                    <div class="col-12">
                        <br>
                        <h6>Product Tags List:</h6>
                        <ul class="list-group">
                            <li id="no_tag_item" class="list-group-item">No tags yet...</li>
                            <li class="list-group-item" v-for="tag in form.selected_tags" :key="tag.id">{{tag.name}} <a @click.prevent="removeTag(tag.id)" class="float-right"><li class="fas fa-trash red"></li></a> </li>
                        </ul>
                        <div class="input-group mt-2">
                            <select id="tag_selector" name="type"   class="form-control">
                                <option value="">Select Tag</option>
                                <option v-for="tag in tags" :key="tag.id" :value="tag.id">{{tag.name}}</option>
                            </select>
                            <span class="input-group-append">
                            <button @click.prevent="addTag" type="button" class="btn btn-primary">Add Tag</button>
                            </span>
                        </div>
                            <br>
                    </div>
                </div>

            <br>

            <div class="row justify-content-center">
                <h6>Product Cover Image:</h6>
            <vue-select-image :h="'100'" :w="'100'"  :dataImages="dataImages"
                              @onselectimage="onSelectImage">
            </vue-select-image>
            <pagination :data="paginateimages" @pagination-change-page="getResults"></pagination>
            </div>

            <br>
            <br>


            <div class="row justify-content-center">
                <h6>Product Image Gallery:</h6>
                <vue-select-image :h="'100'" :w="'100'"  :dataImages="dataImages2"
                                  :is-multiple="true"
                                  @onselectmultipleimage="onSelectMultipleImage">
                </vue-select-image>
                <pagination :data="paginateimages2" @pagination-change-page="getResults2"></pagination>
            </div>



                <button type="submit" class="btn btn-success">Add Product</button>

        </form>

        <br>
    </div>

</template>

<script>
    import VueSelectImage from 'vue-select-image'
    Vue.use(VueSelectImage);

    // add stylesheet
    require('vue-select-image/dist/vue-select-image.css');

    export default {
        data(){
            return{
                form: new Form({
                    id:'',
                    general_name: '',
                    model_name: '',
                    price: '',
                    description: '',
                    overview:'',
                    category_id:'',
                    brand_id:'',
                    selectedCoverImage:{},
                    selectedGalleryImage:{},
                    selected_tags:[],
                }),
                dataImages:[],
                dataImages2:[],
                paginateimages:{},
                paginateimages2:{},
                tags:{},
                brands:{},
                categories:{},

            }
        },
        components: { VueSelectImage },
        mounted() {
           // console.log('Example Component mounted.')
        },
        created(){
            this.Setup();
        },
        methods:{
            onSelectImage(image){
                this.form.selectedCoverImage = image;
            },
            onSelectMultipleImage(images){
                this.form.selectedGalleryImage = images;
            },
            baseUrl(){
                return 'http://marcopolo.test/';
            },
            getResults(page = 1) {
                this.dataImages = [];
                axios.get(this.baseUrl()+'api/media?page=' + page)
                    .then((response) => {
                        this.paginateimages = response.data;
                        response.data.data.forEach((image)=>{
                            let obj = {id:'' , src:''};
                            obj.id = image.id;
                            obj.src = this.baseUrl()+'images'+image.file;
                            this.dataImages.push(obj);
                        });
                    });
            },
            getResults2(page = 1) {
                this.dataImages2 = [];
                axios.get(this.baseUrl()+'api/media?page=' + page)
                    .then((response) => {
                        this.paginateimages2 = response.data;
                        response.data.data.forEach((image)=>{
                            let obj = {id:'' , src:''};
                            obj.id = image.id;
                            obj.src = this.baseUrl()+'images'+image.file;
                            this.dataImages2.push(obj);
                        });
                    });
            },
            Setup(){
                axios.get(this.baseUrl()+'api/media')
                    .then((response) => {
                        this.paginateimages = response.data;
                        this.paginateimages2 = response.data;
                        response.data.data.forEach((image)=>{
                            let obj = {id:'' , src:''};
                            obj.id = image.id;
                            obj.src = this.baseUrl()+'images'+image.file;
                            this.dataImages.push(obj);
                            this.dataImages2.push(obj);
                        });
                    });


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
            addTag(){
                let tagName = $('#tag_selector').find(":selected").text();
                let tagValue = $('#tag_selector').find(":selected").val();
                //console.log(tagName + ' : ' + tagValue);
                if(!this.TagAlreadySelected(tagValue) && tagValue !== '') {
                    $('#no_tag_item').addClass('d-none');
                    this.form.selected_tags.push({id: tagValue, name: tagName});
                }
            },
            removeTag(tagId){
                let index = 0;
                let removeAt = -1;
                this.form.selected_tags.forEach((tag)=>{
                    if(tag.id === tagId) {
                       removeAt = index;
                    }
                    index++;
                });

                 this.form.selected_tags.splice(removeAt, 1);

                if(Object.keys(this.form.selected_tags).length === 0){
                    $('#no_tag_item').removeClass('d-none');
                }
            },
            TagAlreadySelected(tagId){
                let res =  false;
                this.form.selected_tags.forEach((tag)=>{
                    if(tag.id === tagId) {res = true;}
                });
                return res;
            },
            editProduct(){

               this.form.overview =  tinymce.activeEditor.getContent();

                   this.form.post(this.baseUrl()+'product')
                       .then((res)=>{

                           if(res.data === 1) {
                               tinymce.activeEditor.setContent('');

                               toast.fire({
                                   type: 'success',
                                   title: 'Product created successfully'
                               });

                               this.form.reset();
                               this.form.errors.clear("general_name");
                               this.form.errors.clear("model_name");
                               this.form.errors.clear("price");
                               this.form.errors.clear("description");
                               this.form.errors.clear("overview");
                               this.form.errors.clear("category_id");
                               this.form.errors.clear("brand_id");
                           }
                           else{
                               toast.fire({
                                   type: 'warning',
                                   title: 'Operation failed'
                               });
                           }
                       })
                       .catch(() => {
                           toast.fire({
                               type: 'warning',
                               title: 'Operation failed'
                           });
                       });

            }
        }
    }
</script>
