import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router';
import Login from "../../modules/Login/Login.vue";
import Register from "../../modules/Register/Register.vue"; // Importa a página de registro
import Home from "../../modules/Home/Home.vue";

const routes: RouteRecordRaw[] = [
    {
        path: '/',
        component: Login,
    },
    {
        path: '/register', // Adiciona a rota para a página de registro
        component: Register,
    },
    {
        path: '/home',
        component: Home,
        meta: { requiresAuth: true },
    },
];

export const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = !!localStorage.getItem('authToken');

    if (to.meta.requiresAuth && !isAuthenticated) {
        next('/'); // Redireciona para o login se o usuário não estiver autenticado
    } else {
        next();
    }
});
