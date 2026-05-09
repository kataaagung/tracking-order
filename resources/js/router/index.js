import { createRouter, createWebHistory } from 'vue-router'

import LoginPage from '../pages/LoginPage.vue'
import OrdersPage from '../pages/OrdersPage.vue'
import TrackingPage from '../pages/TrackingPage.vue'

const routes = [
    {
        path: '/',
        name: 'login',
        component: LoginPage,
    },
    {
        path: '/orders',
        name: 'orders',
        component: OrdersPage,
    },
    {
        path: '/tracking/:id',
        name: 'tracking',
        component: TrackingPage,
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router