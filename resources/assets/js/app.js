
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import VueRouter from 'vue-router'
import VeeValidate from 'vee-validate'


import { modal } from 'vue-strap'
import { alert } from 'vue-strap'
import { tabset } from 'vue-strap'
import { tab } from 'vue-strap'
import { tabGroup } from 'vue-strap'


import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

Vue.use(VeeValidate);
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
const ClientForm = require('./components/Client/ClientForm.vue');

const Provider = require('./components/Provider/Provider.vue');
const ProviderForm = require('./components/Provider/ProviderForm.vue');

const Product = require('./components/Product/Product.vue');
const Material = require('./components/Material/Material.vue');

const Message =  require('./components/Message.vue');

Vue.component('modal', modal);
Vue.component('alert', alert);
Vue.component('tabs', tabset);
Vue.component('tab-group', tabGroup);
Vue.component('tab', tab);

Vue.component('pulse-loader', PulseLoader);

Vue.component('example', Exemple);

Vue.component('client', Client);
Vue.component('client-form', ClientForm);

Vue.component('provider', Provider);
Vue.component('provider-form', ProviderForm);

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
    router,
}).$mount('#app');
