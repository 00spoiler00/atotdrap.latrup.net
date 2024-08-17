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
    { path: '/race', component: Races, name: 'Races' },
    { path: '/race/:id', component: RaceDetail, name: 'Race' },
    { path: '/driver', component: Drivers, name: 'Drivers' },
    { path: '/driver/:id', component: DriverDetail, name: 'Driver' },
    { path: '/track/:id', component: TrackDetail, name: 'Track' },
    { path: '/track/:id/hotlaps', component: Hotlaps, name: 'Hotlaps' },
    { path: '/statistics', component: Statistics, name: 'Statistics' },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router