import { createApp } from 'vue'
import App from './App.vue'
import store from './store';
import router from './router';
import VueObserveVisibility from 'vue3-observe-visibility'

createApp(App)
    .use(store)
    .use(router)
    .use(VueObserveVisibility)
    .mount('#app')

