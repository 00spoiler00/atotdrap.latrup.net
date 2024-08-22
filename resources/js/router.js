import { createWebHistory, createRouter } from 'vue-router'

import Dashboard from '@/components/Pages/Dashboard.vue'
import Race from '@/components/Pages/Race.vue'
import Driver from '@/components/Pages/Driver.vue'
import RaceList from '@/components/Pages/RaceList.vue'
import DriverList from '@/components/Pages/DriverList.vue'
import Statistics from '@/components/Pages/Statistics.vue'
import Track from '@/components/Pages/Track.vue'
import HotlapList from '@/components/Pages/HotlapList.vue'

const routes = [
    { path: '/', component: Dashboard },
    { path: '/race', component: RaceList, name: 'RaceList' },
    { path: '/race/:id', component: Race, name: 'Race' },
    { path: '/driver', component: DriverList, name: 'DriverList' },
    { path: '/driver/:id', component: Driver, name: 'Driver' },
    { path: '/track/:id', component: Track, name: 'Track' },
    { path: '/track/:id/hotlaps', component: HotlapList, name: 'TrackHotlaps' },
    { path: '/hotlap', component: HotlapList, name: 'HotlapList' },
    { path: '/statistics', component: Statistics, name: 'Statistics' },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router