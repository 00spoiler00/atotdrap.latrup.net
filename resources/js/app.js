import { createApp } from 'vue'
import vuetify from "./vuetify";
import { createPinia } from 'pinia'
import router from "./router";
import dateTransformerPlugin from './plugins/dateTransformerPlugin';
import AppLayout from './layouts/App.vue'

createApp(app)
    .use(vuetify)
    .use(createPinia())
    .use(router)
    // .use(dateTransformerPlugin)
    .component('app', AppLayout)
    .mount("#app");

