import { createWebHistory, createRouter } from 'vue-router'

import Dashboard from '@/components/Pages/Dashboard.vue'
import RaceDetail from '@/components/Pages/RaceDetail.vue'
import DriverDetail from '@/components/Pages/DriverDetail.vue'
import Races from '@/components/Pages/Races.vue'
import Drivers from '@/components/Pages/Drivers.vue'
import Statistics from '@/components/Pages/Statistics.vue'
import TrackDetail from '@/components/Pages/TrackDetail.vue'
import Hotlaps from '@/components/Pages/Hotlaps.vue'

const routes = [
    // { path: '/', component: Dashboard },
    { path: '/', redirect: '/race'},
    { path: '/race', component: Races },
    { path: '/race/:id', component: RaceDetail },
    { path: '/driver', component: Drivers },
    { path: '/driver/:id', component: DriverDetail },
    { path: '/track/:id', component: TrackDetail },
    { path: '/track/:id/hotlaps', component: Hotlaps },
    { path: '/statistics', component: Statistics },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router