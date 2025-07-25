import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from './router';
import app from './app.vue';

const vue = createApp(app);
const pinia = createPinia();

vue.use(router);
vue.use(pinia);

vue.mount("#app");