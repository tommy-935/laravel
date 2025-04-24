import './bootstrap';
import { createApp } from 'vue';

import App from "../views/pages/App.vue";
import AdminApp from "../views/backend/components/layout/MainLayout.vue";
import store from "./store/store";
import WebRoute from "../route/route";
import AdminRoute from '../views/backend/route/index.js'
import { createPinia } from 'pinia';

// vue 2
/*
var app = new Vue({
    el: "#app",
    template: "<div>Vue Test</div>"
});
*/

// vue 3
/*
var app = Vue.createApp({
    data(){
        return {
            message: "Vue"
        }
    }
}).mount("#app");
*/
function getAppComponent() {
    return window.location.pathname.includes('/admin') ? AdminApp : App
}

function getAppRoute() {
    return window.location.pathname.includes('/admin') ? AdminRoute : WebRoute
}

const app = createApp(getAppComponent());
app.use(store);
app.use(createPinia());
app.use(getAppRoute());
app.mount("#app");