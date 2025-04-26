import axios from "axios";
import { getToken } from '_@/js/lib/common';

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