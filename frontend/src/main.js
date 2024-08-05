import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import './axios'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';
import '@/assets/styles/styles.css';

createApp(App)
    .use(router)
    .mount('#app');

document.title = 'XYZ Treinamentos';