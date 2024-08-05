import { createRouter, createWebHistory } from 'vue-router';
import FormLogin from '@/components/login/FormLogin.vue';
import HomePage from "@/components/gestor/HomePage.vue";
import TrainingManager from "@/components/gestor/TrainingManager.vue";
import SubordinateManager from "@/components/gestor/SubordinateManager.vue";

const routes = [
    { path: '/', component: FormLogin },
    { path: '/home', component: HomePage, meta: { requiresAuth: true } },
    { path: '/trainings', component: TrainingManager, meta: { requiresAuth: true } },
    { path: '/subordinates', component: SubordinateManager, meta: { requiresAuth: true } }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = !!localStorage.getItem('token');
    if (to.meta.requiresAuth && !isAuthenticated) {
        next('/');
    } else {
        next();
    }
});

export default router;
