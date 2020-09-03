// router.js
import Vue from 'vue';
import Router from 'vue-router';
import Home from './views/Home';
import Welcome from "./views/Welcome";

Vue.use(Router);

const guestCheck = (to, from, next) => {
    if (!localStorage.getItem("code-test-user-token")) {
        return next();
    } else {
        return next("/home");
    }
};
const authCheck = (to, from, next) => {
    if (localStorage.getItem("code-test-user-token")) {
        return next();
    } else {
        return next("/login");
    }
};

const routes = [
    {
        path: '/',
        name: 'Welcome',
        beforeEnter: guestCheck,
        component: Welcome
    },
    {
        path: '/register',
        name: 'register',
        beforeEnter: guestCheck,
        component: () => import('./views/auth/Register.vue')
    },
    {
        path: '/login',
        name: 'login',
        beforeEnter: guestCheck,
        component: () => import('./views/auth/Login.vue'),
    },

    {
        path: '/home',
        name: 'home',
        beforeEnter: authCheck,
        component: Home,
        children: [
            {
                path: '/home/categories',
                name: 'categories',
                component: () => import('./views/Categories.vue'),
            },
        ],
    }

];

const router = new Router({
    mode: 'history',
    routes: routes,
    linkActiveClass: 'active',
});

export default router;
