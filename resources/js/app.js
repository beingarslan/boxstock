import.meta.glob([
  '../images/**',
]);

import { createApp } from 'vue';
import Antd from 'ant-design-vue';
import 'ant-design-vue/dist/antd.css';
import 'vuetify/styles';
import wysiwyg from "vue-wysiwyg";
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import App from './App.vue';
import router from "./router";
import store from './store';

import axios from 'axios'
axios.defaults.baseURL = '/api/';

const token = localStorage.getItem('token');

if(token) {
    axios.defaults.headers.common['Authorization'] = token;
}

const vuetify = createVuetify({
    components,
    directives,
})

const app = createApp(App);
app.use(Antd);
app.use(store);
app.use(router);
app.use(wysiwyg, {});
app.use(vuetify);
app.mount('#app');
