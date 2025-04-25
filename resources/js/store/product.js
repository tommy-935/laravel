import api from "../api";
import store from './store';


export default {
    state: {
        productList: [],
        product: {},
    },
    mutations: {
        productsCallback(state, res) {
            console.log(res);
            store.commit("setLoading", false);
            // go to personal page
            if (res.status == 200) {
                state.productList = res.data.data.data;
            }
        },
        productCallback(state, res) {
            console.log(res);
            store.commit("setLoading", false);
            // go to personal page
            if (res.status == 200) {
                state.product = res.data.data;
            }
        }
    },
    actions: {
        getProducts({ commit }, params) {
            api.getProducts(params).then(function (res) {
                commit("productsCallback", res);
            }).catch(error => {
                alert(error.message);
                store.commit("setLoading", false);
            });
        },
        getProduct({ commit }, params) {
            api.getProduct(params).then(function (res) {
                commit("productCallback", res);
            }).catch(error => {
                alert(error.message);
                store.commit("setLoading", false);
                // 404
                if (error.response.status == 404) {
                    location.href = "/404";
                }
                // 500
                if (error.response.status == 500) {
                    store.commit("setError", "Server error");
                }
            });
        }
    }
}