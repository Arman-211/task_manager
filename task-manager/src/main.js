import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'; // Import Bootstrap JavaScript
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import "@/assets/main.css";

createApp(App).use(store).use(router).mount('#app')
