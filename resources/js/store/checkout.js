import api from "../api";
import store from './store';


export default {
    state: {
        uaa: []
    },
    mutations: {
        checkoutCallback(state, res) {
            console.log(res);
            store.commit("setLoading", false);
            // go to personal page
            if (res.status == 200) {
                
            }
        },
        getCheckoutCallback(state, res) {
            console.log(res);
            store.commit("setLoading", false);
            // go to personal page
            if (res.status == 200) {
                
            }
        }
    },
    actions: {
        checkout({ commit }, params) {
            api.checkout(params).then(function (res) {
                commit("checkoutCallback", res);
            }).catch(error => {
                alert(error.message);
                store.commit("setLoading", false);
            });
        },
        getCheckout({ commit }, params) {
            api.getCheckout(params).then(function (res) {
                commit("getCheckoutCallback", res);
            }).catch(error => {
                alert(error.message);
                store.commit("setLoading", false);
            });
        },
    }
}