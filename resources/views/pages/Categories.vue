<script>
import Header from "../components/Header.vue";
import Categories from "../components/Categories.vue";
import Footer from "../components/Footer.vue";

import {mapState, mapActions} from "vuex";
import { useRoute } from "vue-router";
export default {

    setup(){
        const route = useRoute();
        const { params } = route;
        return {
            params
        };
    },
    components: {
        Header,
        Categories,
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
    <Categories :slug="params.slug" />
    <Footer />
</template>
