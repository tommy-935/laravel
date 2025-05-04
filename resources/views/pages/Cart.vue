<script>
import Header from "../components/Header.vue";
import Cart from "../components/Cart.vue";
import Footer from "../components/Footer.vue";
import Loading from "../components/Loading.vue";


import {mapState, mapActions} from "vuex";
export default {

    setup(){

    },
    components: {
        Header,
        Cart,
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
    <Cart />
    <Footer />
    <Loading />
</template>
