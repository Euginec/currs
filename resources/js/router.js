import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store';

import Login from './views/Login.vue';
import Main from './views/Main.vue';
import Register from './views/Register.vue';
import Rates from './views/Rates.vue';

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'main',
        component: Main
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        beforeEnter: (to, from, next) => {
            if (store.getters.isLoggedIn) {
                next('/');
            } else {
                next();
            }
        },
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        beforeEnter: (to, from, next) => {
            if (store.getters.isLoggedIn) {
                next('/');
            } else {
                next();
            }
        },

    },
    {
        path: '/logout',
        name: 'logout',
        beforeEnter: (to, from, next) => {
            store.dispatch('logout')
                .then(resp => {
                    next('/login');
                })
                .catch(err => {
                    console.log(err);
                });
        },
    },
    {
        path: '/rates',
        name: 'rates',
        component: Rates,
        meta: {
            requiresAuth: true
        }
    }
];

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
});

router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.isLoggedIn) {
            next();
            return;
        }
        next('/login');
    } else {
        next();
    }
});
export default router;
