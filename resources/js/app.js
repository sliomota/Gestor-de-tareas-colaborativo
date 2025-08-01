import { createApp } from 'vue';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import router from './router';
import app from './app.vue';

const vue = createApp(app);
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

vue.use(router);
vue.use(pinia);

vue.mount("#app");