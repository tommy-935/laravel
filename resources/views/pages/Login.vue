<script>
import Header from "../components/Header.vue";
import Login from "../components/Login.vue";
import Footer from "../components/Footer.vue";
import Loading from "../components/Loading.vue";


import {mapState, mapActions} from "vuex";
export default {

    setup(){

    },
    components: {
        Header,
        Login,
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
    <Login />
    <Footer />
    <Loading />
</template>
