<template>
    <v-app dark>

        <TopBar />

        <v-navigation-drawer expand-on-hover permanent rail>
            <v-list density="compact" nav>
                <v-list-item 
                    v-for="route in routes" 
                    :key="route.path" 
                    :prepend-icon="route.icon" 
                    :title="route.title" 
                    :to="route.path" 
                />
            </v-list>
        </v-navigation-drawer>

        <v-main>
            <RouterView />
        </v-main>

    </v-app>
</template>

<script setup>
import TopBar from '@/components/Layout/TopBar.vue';

const routes = [
    // { title: 'Dashboard', path: '/', icon: 'mdi-view-dashboard' },
    { title: 'Curses', path: '/race', icon: 'mdi-flag-checkered' },
    { title: 'Pilots', path: '/driver', icon: 'mdi-account' },
    // { title: 'Statistics', path: '/statistics', icon: 'mdi-chart-bar' },
]

</script>
