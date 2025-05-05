<script>
import Header from "../components/Header.vue";
import ForgotPassword from "../components/ForgotPassword.vue";
import Footer from "../components/Footer.vue";
import Loading from "../components/Loading.vue";


import {mapState, mapActions} from "vuex";
export default {

    setup(){

    },
    components: {
        Header,
        ForgotPassword,
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
    <ForgotPassword />
    <Footer />
    <Loading />
</template>
