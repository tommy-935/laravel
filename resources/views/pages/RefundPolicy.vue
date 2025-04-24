<script>
import Header from "../components/Header.vue";
import Footer from "../components/Footer.vue";
import RefundPolicy from "../components/RefundPolicy.vue"

import {mapState, mapActions} from "vuex";
export default {

    setup(){

    },
    components: {
        Header,
        Footer,
        RefundPolicy
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
    <RefundPolicy />
    <Footer />
</template>
