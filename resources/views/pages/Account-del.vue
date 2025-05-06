<script>
import Header from "../components/Header.vue";
import Account from "../components/Account.vue";
import Footer from "../components/Footer.vue";

import {mapState, mapActions} from "vuex";
export default {

    setup(){

    },
    components: {
        Header,
        Account,
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
    <Account />
    <Footer />
</template>
