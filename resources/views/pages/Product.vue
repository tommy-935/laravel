<script>
import Header from "../components/Header.vue";
import Product from "../components/Product.vue";
import Footer from "../components/Footer.vue";
import Loading from "../components/Loading.vue";

import {mapState, mapActions} from "vuex";
export default {

    setup(){

    },
    components: {
        Header,
        Product,
        Footer,
        Loading
    },
    created(){
        this.getIndex();
    },
    methods: {
        ...mapActions([
            "getIndex"
        ])
    }
}

</script>
<template>
    <Header />
    <Product />
    <Footer />
    <Loading />
</template>
