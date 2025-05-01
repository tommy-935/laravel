<script>
import Header from "../components/Header.vue";
import Banner from "../components/Banner.vue";
import Footer from "../components/Footer.vue";

import {mapState, mapActions} from "vuex";
export default {

    setup(){

    },
    components: {
        Header,
        Banner,
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
<template >
    <Header />
    <Banner />
    <Footer />
</template>
