import axios from "axios";
import { getToken } from '_@/js/lib/common';
import ForgotPassword from "../views/components/ForgotPassword.vue";

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found!');
}

export default {
    getIndex: function(params){
        return axios.post("/visits");
    },
    register: function(params){
        return axios.post("/api/register", params);
    },
    login: function(params){
        return axios.post("/api/login", params);
    },
    admin_login: function(params){
        return axios.post("/api/login", params);
    },
    forgotPassword: function(params){
        return axios.post("/api/forgot-password", params);
    },
    resetPassword: function(params){
        return axios.post("/api/reset-password", params);
    },
    logout: function(params){
        return axios.post("/api/logout", params, {
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${getToken()}`
        }});
    },
    getProducts: function(params){
        if(typeof params.slug !== 'undefined'){ 
            return axios.get("/api/categories/"+params.slug);
        }
        return axios.get("/api/categories");
    },
    getProduct: function(params){
        if(typeof params.handle !== 'undefined'){ 
            return axios.get("/api/products/"+params.handle);
        }
        return axios.get("/api/products");
    },
    addToCart: function(params){
        return axios.post("/cart/add", params, {
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${getToken()}`
        }});
    },
    removeCartItem: function(params){
        return axios.post("/cart/remove", params, {
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${getToken()}`
        }});
    },
    updateCartItem: function(params){
        return axios.post("/cart/update", params, {
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${getToken()}`
        }});
    },
    getCart: function(params){
        return axios.post("/cart", params);
    },
    checkout: function(params){
        return axios.post("/checkout/process", params);
    },
    getCheckout: function(params){
        return axios.post("/checkout/success", params);
    },
}