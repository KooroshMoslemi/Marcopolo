<template>
    <div class="container">
    <br>
        <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" @vdropzone-complete="Setup"></vue-dropzone>

        <br>

    <h1>Uploaded:</h1>
        <div class="row">
            <gallery :images="images.data"></gallery>

            <div
                    class="image"
                    v-for="image in images.data"
                    :key="image.id"
                    @click="index = image.id"
                    :style="{ backgroundImage: 'url(../images' + image.file + ')'}">
                <a @click.prevent="checkMedia(image.id)" class="float-right mr-1 mt-1"><i class="fas fa-trash red"></i></a>
            </div>

        </div>

        <pagination class="float-right" :data="images" @pagination-change-page="getResults"></pagination>

    </div>

</template>

<script>
    import VueGallery from 'vue-gallery';
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    export default {
        data: function () {
            return {
                images: {},
                index: null,
                dropzoneOptions: {
                    url: 'http://marcopolo.test/api/media',
                    thumbnailWidth: 150,
                    maxFilesize: 0.5,
                }
            };
        },
        mounted() {
            //console.log('Example Component mounted.')
        },
        created(){
            this.Setup();
        },
        components: {
            'gallery': VueGallery,
            vueDropzone: vue2Dropzone,
        },
        methods:{
            checkMedia(id){
                axios.post('/api/check_media_for_del', {id: id})
                    .then((res) => {
                      if(res.data === 1)
                      {
                          toast.fire({
                              type: 'warning',
                              title: 'Cannot delete because it is in use'
                          });
                      }
                      else{
                          axios.delete('/api/media/'+id)
                              .then(() => {
                                    this.Setup();
                                  toast.fire({
                                      type: 'success',
                                      title: 'Done!'
                                  });
                              })
                              .catch(()=>{
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
            delMedia(id)
            {
               console.log(id);
            },
            baseUrl(){
                return 'http://marcopolo.test/';
            },
            getResults(page = 1) {
                axios.get(this.baseUrl()+'api/media?page=' + page)
                    .then(response => {
                        this.images = response.data;
                    });
            },
            Setup(){
                axios.get(this.baseUrl()+'api/media')
                    .then(response => {
                        this.images = response.data;
                    });
            }
        }
    }
</script>


<style scoped>
    .image {
        float: left;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        border: 1px solid #ebebeb;
        margin: 5px;
        height: 150px;
        width: 150px;
    }
</style>