<template>
    <div class="container">
        <categories></categories>
        <Products title="New" otherTitle="New Products" description="We have lots of new products in our shop. Don't forget to explore them!!"></Products>
        <emailSubscribe></emailSubscribe>
        <Products title="OFF" otherTitle="The cheaper, The Better!!" description="We have tried our best to provide products with the most reasonable price in the market!!"></Products>
    </div>
</template>

<script>
    import categories from '../components/WelcomeCategories'
    import Products from './WelcomeProducts'
    import emailSubscribe from '../components/WelcomeEmailSubscribe'

    export default {
        components: {
            categories,
            Products,
            emailSubscribe
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
