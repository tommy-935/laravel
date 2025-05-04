import api from "../api";
import store from './store';
import { goToCart } from "../lib/common";


export default {
    state: {
        cart: []
    },
    mutations: {
        addToCartCallback(state, res) {
            console.log(res);
            store.commit("setLoading", false);
            if (res.status == 200) {
                goToCart();
            }
        },
        removeCallback(state, res) {
            console.log(res);
            store.commit("setLoading", false);
            if (res.status == 200) {
                if(! res.data.success){
                    alert(res.data.message);
                    return
                }
                goToCart();
            }
        },
        updateCallback(state, res) {
            console.log(res);
            store.commit("setLoading", false);
            if (res.status == 200) {
                if(! res.data.success){
                    alert(res.data.message);
                    return
                }
                goToCart();
            }
        },
        getCallback(state, res) {
            store.commit("setLoading", false);
            // go to personal page
            if (res.status == 200) {
                state.cart = res.data.data;

            }
        }
    },
    actions: {
        addToCart({ commit }, params) {
            api.addToCart(params).then(function (res) {
                commit("addToCartCallback", res);
            }).catch(error => {
                alert(error.message);
                store.commit("setLoading", false);
            });
        },
        remove({ commit }, params) {
            api.removeCartItem(params).then(function (res) {
                commit("removeCallback", res);
            }).catch(error => {
                alert(error.message);
                store.commit("setLoading", false);
            });
        },
        update({ commit }, params) {
            api.updateCartItem(params).then(function (res) {
                commit("updateCallback", res);
            }).catch(error => {
                alert(error.message);
                store.commit("setLoading", false);
            });
        },
        getCart({ commit }, params) {
            api.getCart(params).then(function (res) {
                commit("getCallback", res);
            }).catch(error => {
                alert(error.message);
                store.commit("setLoading", false);
            });
        },
    }
}