import { createApp } from 'vue'
import vuetify from "@/vuetify";
import { createPinia } from 'pinia'
import router from "@/router";
import dateTransformerPlugin from '@/plugins/dateTransformerPlugin';
import App from '@/components/Layout/App.vue'

createApp(app)
    .use(vuetify)
    .use(createPinia())
    .use(router)
    // .use(dateTransformerPlugin)
    .component('app', App)
    .mount("#app");

