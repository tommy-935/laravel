<script>
import Header from "../components/Header.vue";
import Footer from "../components/Footer.vue";
import Aboutus from "../components/Aboutus.vue"

import {mapState, mapActions} from "vuex";
export default {

    setup(){

    },
    components: {
        Header,
        Footer,
        Aboutus
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
    <Aboutus />
    <Footer />
</template>
