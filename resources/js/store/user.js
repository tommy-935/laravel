import api from "../api";
import { inject } from "vue";
import store from './store';
import SecureStorage from '_@/js/utils/secureStorage';
import { goToAdmin, goToLogin } from "../lib/common";


export default {
    state: {
        uaa: []
    },
    mutations: {
        setMyStatus(state, b) {
            state.uaa = b;
        },
        registerCallback(state, res) {
            console.log(res);
            store.commit("setLoading", false);
        },
        loginCallback(state, res) {
            console.log(res);
            store.commit("setLoading", false);
            // go to personal page
            if (res.status == 200) {
                const storage = new SecureStorage('app', 'custom-secret-key')
                storage.set('token', res.data.token, 3600 * 24 * 3);
                goToAdmin();
            }
        },
        logoutCallback(state, res) {
            store.commit("setLoading", false);
            // go to personal page
            if (res.status == 200) {
                const storage = new SecureStorage('app', 'custom-secret-key')
                storage.remove('token');
                goToLogin();
            }
        }
    },
    actions: {
        getIndex({ commit }) {
            api.getIndex().then(function (res) {
                commit("setMyStatus", res);
            });
        },
        register({ commit }, params) {
            // const store = inject('store');
            api.register(params).then(function (res) {
                commit("registerCallback", res);
            }).catch(error => {
                alert(error.message);
                store.commit("setLoading", false);
            });

        },
        login({ commit }, params) {
            api.login(params).then(function (res) {
                commit("loginCallback", res);
            }).catch(error => {
                alert(error.message);
                store.commit("setLoading", false);
            });
        },
        logout({ commit }) {
            api.logout().then(function (res) {
                commit("logoutCallback", res);
            });
        },
    }
}