<script>
import Header from "../components/Header.vue";
import Footer from "../components/Footer.vue";
import PrivacyPolicy from "../components/PrivacyPolicy.vue"

import {mapState, mapActions} from "vuex";
export default {

    setup(){

    },
    components: {
        Header,
        Footer,
        PrivacyPolicy
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
    <PrivacyPolicy />
    <Footer />
</template>
