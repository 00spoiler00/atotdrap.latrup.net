import { createApp } from 'vue'
import { createPinia } from 'pinia'
import AppLayout from './layouts/App.vue'
import vuetify from "./vuetify";

const pinia = createPinia()


createApp(app)
    .use(vuetify)
    .use(pinia)
    .component('app', AppLayout)
    .mount("#app");

