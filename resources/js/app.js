require('./bootstrap');
import '@fortawesome/fontawesome-free/css/all.css'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

window.Vue = require('vue');

Vue.component('home', require('./components/Home.vue').default);
Vue.component('edit', require('./components/Edit.vue').default);

Vue.use(Vuetify)

const app = new Vue({
    vuetify: new Vuetify({
        icons: {
            iconfont: 'fa',
        },
    }),
    el: '#app',
});
