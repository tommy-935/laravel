<script>
import Header from "../components/Header.vue";
import Profile from "../components/Profile.vue";
import Footer from "../components/Footer.vue";

import {mapState, mapActions} from "vuex";
export default {

    setup(){

    },
    components: {
        Header,
        Profile,
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
    <Profile />
    <Footer />
</template>
