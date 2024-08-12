import { createWebHistory, createRouter } from 'vue-router'

import Dashboard from './layouts/Dashboard.vue'
import RaceDetail from './components/RaceDetail.vue'
import DriverDetail from './components/DriverDetail.vue'

const routes = [
    { path: '/', component: Dashboard },
    { path: '/race/:id', component: RaceDetail },
    { path: '/driver/:id', component: DriverDetail },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router