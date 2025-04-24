<script>
import Header from "../components/Header.vue";
import Success from "../components/Success.vue";
import Footer from "../components/Footer.vue";

import {mapState, mapActions} from "vuex";
export default {

    setup(){

    },
    components: {
        Header,
        Success,
        Footer
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
    <Success />
    <Footer />
</template>
