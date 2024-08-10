import { createApp } from 'vue'
import AppLayout from './layouts/App.vue'
import vuetify from "./vuetify";

createApp(app)
    .use(vuetify)
    .component('app', AppLayout)
    .mount("#app");

