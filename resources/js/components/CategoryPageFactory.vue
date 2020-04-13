<template>
    <section class="section-content bg padding-y">
        <div class="container">

            <div class="row">
                <aside class="col-sm-3">
                    <category-search></category-search>
                </aside> <!-- col.// -->

                <main class="col-sm-9">
                    <category-content></category-content>
                </main> <!-- col.// -->

            </div>

            <random-slider></random-slider>

        </div> <!-- container .//  -->
    </section>
</template>

<script>

    import categoryContent from '../components/CategoryPageContent'
    import categorySearch from './CategoryPageSearchSidebar'
    import randomSlider from './RandomSlider'

    export default {
        components:{
            categoryContent,
            categorySearch,
            randomSlider
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
