// import vue from "vue";
import vuex from "vuex";
import user from "./user";
import product from "./product";
import category from "@/store/modules/category";
import cart from "./cart";
import checkout from "./checkout";

// vue.use(vuex);

export default new vuex.Store({
    modules: {
        user,
        category,
        product,
        cart,
        checkout
    },
    state:{
        loading: false
    },
    mutations: {
        setLoading(state, status) {
          state.loading = status;  
        },
    },
    getters: {
        loading: (state) => state.loading  
    }
});