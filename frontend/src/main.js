import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import VueSweetalert2 from 'vue-sweetalert2';
import './axios'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';
import '@/assets/styles/styles.css';

createApp(App)
    .use(router)
    .use(VueSweetalert2)
    .mount('#app');

document.title = 'XYZ Treinamentos';