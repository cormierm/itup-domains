require('./bootstrap');
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('home', require('./components/Home.vue').default);

Vue.use(Vuetify)

const app = new Vue({
    vuetify: new Vuetify({}),
    el: '#app',
});
