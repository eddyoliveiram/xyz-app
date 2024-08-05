import { createRouter, createWebHistory } from 'vue-router';
import FormLogin from '@/components/login/FormLogin.vue';
import HomePage from "@/components/gestor/HomePage.vue";

const routes = [
    {path: '/', component: FormLogin },
    {path: '/home', component: HomePage}
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
