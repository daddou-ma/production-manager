
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
import { progressbar } from 'vue-strap'
import { datepicker } from 'vue-strap'

import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

Vue.use(VeeValidate)
Vue.use(VueRouter)

Vue.http.options.root = 'http://gestion-pro.herokuapp.com/'

/*var bus = new Vue();

global.bus = bus;
*/
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
const ProductForm = require('./components/Product/ProductForm.vue');
const ProductMaterial = require('./components/Product/ProductMaterial.vue');

const Material = require('./components/Material/Material.vue');
const MaterialForm = require('./components/Material/MaterialForm.vue');

const Fabrication = require('./components/Fabrication/Fabrication.vue');
const FabricationForm = require('./components/Fabrication/FabricationForm.vue');
const FabricationPrint = require('./components/Fabrication/FabricationPrint.vue');

const Command = require('./components/Command/Command.vue');
const CommandForm = require('./components/Command/CommandForm.vue');
const CommandMaterial = require('./components/Command/CommandMaterial.vue');
const CommandPrint = require('./components/Command/CommandPrint.vue');

const Delivery = require('./components/Delivery/Delivery.vue');
const DeliveryForm = require('./components/Delivery/DeliveryForm.vue');
const DeliveryProduct = require('./components/Delivery/DeliveryProduct.vue');
const DeliveryPrint = require('./components/Delivery/DeliveryPrint.vue');

const Message =  require('./components/Message.vue');

Vue.component('modal', modal);
Vue.component('alert', alert);
Vue.component('progressbar', progressbar);
Vue.component('datepicker', datepicker);

Vue.component('pulse-loader', PulseLoader);

Vue.component('example', Exemple);

Vue.component('client', Client);
Vue.component('client-form', ClientForm);

Vue.component('provider', Provider);
Vue.component('provider-form', ProviderForm);

Vue.component('product', Product);
Vue.component('product-form', ProductForm);
Vue.component('product-material', ProductMaterial);

Vue.component('material', Material);
Vue.component('material-form', MaterialForm);

Vue.component('fabrication', Fabrication);
Vue.component('fabrication-form', FabricationForm);
Vue.component('fabrication-print', FabricationPrint);

Vue.component('command', Command);
Vue.component('command-form', CommandForm);
Vue.component('command-material', CommandMaterial);
Vue.component('command-print', CommandPrint);

Vue.component('delivery', Delivery);
Vue.component('delivery-form', DeliveryForm);
Vue.component('delivery-product', DeliveryProduct);
Vue.component('delivery-print', DeliveryPrint);

Vue.component('message', Message);


const routes = [
  	{ path: '/', component: Client },
  	{ path: '/clients', component: Client },
  	{ path: '/providers', component: Provider },
  	{ path: '/products', component: Product },
  	{ path: '/materials', component: Material },
  	{ path: '/fabrications', component: Fabrication },
  	{ path: '/commands', component: Command },
  	{ path: '/deliveries', component: Delivery }
]

const router = new VueRouter({
  	routes // short for routes: routes
})

const app = new Vue({
    router,
}).$mount('#app');
