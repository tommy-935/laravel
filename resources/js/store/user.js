import api from "../api";
import { inject } from "vue";
import store from './store';
import SecureStorage from '_@/js/utils/secureStorage';
import { goToAdmin, goToLogin, goToResetPassword } from "../lib/common";


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
            if (res.status == 201) {
                alert("Registration successful.");
                goToLogin();
            }
        },
        loginCallback(state, res) {
            console.log(res);
            store.commit("setLoading", false);
            // go to personal page
            if (res.status == 200) {
                const storage = new SecureStorage('app', 'custom-secret-key')
                storage.set('token', res.data.token, 3600 * 24 * 3);
                storage.set('name', res.data.user.name, 3600 * 24 * 3);
                goToAdmin();
            }
        },
        forgotPasswordCallback(state, res) {
            console.log(res);
            store.commit("setLoading", false);
            // go to personal page
            if (res.status == 200) {
                alert("We have sent you an email with a link to reset your password. Please check your inbox.");
            }
        },
        resetPasswordCallback(state, res) {
            console.log(res);
            store.commit("setLoading", false);
            // go to personal page
            if (res.status == 200) {
                alert("Your password has been reset successfully. Please login with your new password.");
                goToLogin();
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
        forgotPassword({ commit }, params) {
            api.forgotPassword(params).then(function (res) {
                commit("forgotPasswordCallback", res);
            }).catch(error => {
                alert(error.message);
                store.commit("setLoading", false);
            });
        },
        resetPassword({ commit }, params) {
            api.resetPassword(params).then(function (res) {
                commit("resetPasswordCallback", res);
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