<template>
    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content bg padding-y-sm">
        <div class="container">

            <div class="row">
                <div class="col-xl-10 col-md-9 col-sm-12">
                    <detail :pid=ProductId></detail>
                </div> <!-- col // -->


                <sidebar></sidebar>
            </div> <!-- row.// -->
        </div><!-- container // -->
    </section>
    <!-- ========================= SECTION CONTENT .END// ========================= -->
</template>

<script>

    import sidebar from '../components/Sidebar'
    import detail from '../components/ProductDetailPageContent'

    export default {
        data(){
            return{
                ProductId:'',
            }
        },
        components:{
            sidebar,
            detail
        },
        mounted() {
            console.log('Component mounted.');
        },
        created() {
            this.ProductId = this.pid;
            // if(this.pid !== undefined ) {
            //     this.ProductId = this.pid;
            // }
            // else{
            //     this.ProductId = this.$route.params['ProductId'];
            //
            //     $('#page-content-container').addClass('d-none');
            //     $('#router-view-container').removeClass('d-none');
            //     $(window).on('popstate', function() {
            //         $('#page-content-container').removeClass('d-none');
            //         $('#router-view-container').addClass('d-none');
            //     });
            // }
        },
        props: ['pid']
    }
</script>
