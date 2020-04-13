<template>
    <!-- ========================= SECTION SUBSCRIBE ========================= -->
    <section class="section-subscribe bg padding-y-sm">
        <div class="container">
            <figure class="mt-3 banner p-3 bg-secondary">
                <p class="pb-2 text-center white">Delivering the latest product trends and industry news straight to your inbox</p>

                <div class="row justify-content-md-center">
                    <div class="col-lg-4 col-sm-6">
                        <form class="row-sm form-noborder">
                            <div class="col-8">
                                <input class="form-control" placeholder="Your Email" type="email">
                            </div> <!-- col.// -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-block btn-warning"> <i class="fa fa-envelope"></i> Subscribe </button>
                            </div> <!-- col.// -->
                        </form>
                        <small class="form-text text-white-50">We’ll never share your email address with a third-party. </small>
                    </div> <!-- col-md-6.// -->
                </div>
            </figure>
        </div>
    </section>
    <!-- ========================= SECTION SUBSCRIBE END.//========================= -->

</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
