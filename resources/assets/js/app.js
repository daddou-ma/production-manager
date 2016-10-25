
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import VueRouter from 'vue-router'

Vue.use(VueRouter)

var bus = new Vue();

global.bus = bus;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */


const Exemple = require('./components/Example.vue');
const Client = require('./components/Client/Client.vue');
const Provider = require('./components/Provider/Provider.vue');
const Product = require('./components/Product/Product.vue');
const Material = require('./components/Material/Material.vue');

const Message =  require('./components/Message.vue');

Vue.component('example', Exemple);
Vue.component('client', Client);
Vue.component('provider', Provider);
Vue.component('product', Product);
Vue.component('material', Material);

Vue.component('message', Message);


const routes = [
  	{ path: '/clients', component: Client },
  	{ path: '/providers', component: Provider },
  	{ path: '/products', component: Product },
  	{ path: '/materials', component: Material }
]

const router = new VueRouter({
  	routes // short for routes: routes
})

const app = new Vue({
    router
}).$mount('#app');
