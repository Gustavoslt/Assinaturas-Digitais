require('./bootstrap');
import vue from 'vue'
window.Vue = vue;

import App from './components/App.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import VueMask from 'v-mask'
import {routes} from './routes';
import swal from 'sweetalert2';
window.Swal = swal;

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(VueMask);
 
const router = new VueRouter({
    mode: 'history',
    routes: routes
});
 
const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});