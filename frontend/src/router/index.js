import { createRouter, createWebHistory } from 'vue-router';
import FormLogin from '@/components/pages/login/LoginIndex.vue';
import AdminDashboardPage from "@/components/pages/admin/dashboard/AdminDashboardIndex.vue";
import TrainingManager from "@/components/pages/admin/trainings/TrainingIndex.vue";
import SubordinateManager from "@/components/pages/admin/subordinate/SubordinateIndex.vue";
import Records from "@/components/pages/subordinate/records/RecordsIndex.vue";
import HomeIndex from "@/components/pages/subordinate/home/HomeIndex.vue";

const adminRoutes = [
    { path: 'dashboard', component: AdminDashboardPage, meta: { requiresAuth: true, requiresAdmin: true } },
    { path: 'trainings', component: TrainingManager, meta: { requiresAuth: true, requiresAdmin: true } },
    { path: 'subordinates', component: SubordinateManager, meta: { requiresAuth: true, requiresAdmin: true } }
];

const subordinateRoutes = [
    { path: 'home', component: HomeIndex, meta: { requiresAuth: true, requiresSubordinate: true } },
    { path: 'records', component: Records, meta: { requiresAuth: true, requiresSubordinate: true } }
];

const routes = [
    { path: '/', component: FormLogin },
    ...adminRoutes.map(route => ({ ...route, path: `/admin/${route.path}` })),
    ...subordinateRoutes.map(route => ({ ...route, path: `/subordinate/${route.path}` }))
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = !!localStorage.getItem('token');
    const isAdmin = localStorage.getItem('is_admin') === '1';

    if (to.meta.requiresAuth && !isAuthenticated) {
        next('/');
    } else if (to.meta.requiresAdmin && !isAdmin) {
        next('/');
    } else if (to.meta.requiresSubordinate && isAdmin) {
        next('/');
    } else {
        next();
    }
});

export default router;
