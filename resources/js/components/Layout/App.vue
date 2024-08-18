<template>
    <v-app dark>

        <v-system-bar app height="2" absolute>

            <v-progress-linear v-if="isLoading" color="accent" height="3" indeterminate />
        </v-system-bar>

        <v-app-bar app prominent>

            <!-- Add a back button -->
            <!-- <v-btn v-if="showBackButton" icon @click="goBack">
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn> -->

            <v-app-bar-nav-icon variant="text" @click.stop="drawer = !drawer" />

            <!-- This should stick to the left -->
            <v-toolbar-title>
                <span class="ml-2">
                    A Tot Drap
                </span>
            </v-toolbar-title>

            <!-- This should be grouped with next section (v-btn and v-progress-circular) and everything be sticked to the right -->
            <!-- <v-img src="./images/pitskill.png" height="16" /> -->

            <v-spacer />

            <div class="mr-4">
                <a href="https://discord.gg/GFvYkjYbta">
                    <v-avatar size="36">
                        <v-img src="./images/icons/android-chrome-192x192.png" />
                    </v-avatar>
                </a>
            </div>

        </v-app-bar>

        <v-navigation-drawer :rail="$vuetify.display.mobile" temporary v-model="drawer">
            <v-list density="compact" nav>
                <v-list-item
                    v-for="route in routes"
                    :key="route.path"
                    :prepend-icon="route.icon"
                    :title="route.title"
                    :to="route.path" />
                <v-list-item @click="openChangelog" prepend-icon="mdi-file-document-outline" title="Changelog" />
            </v-list>
        </v-navigation-drawer>

        <div class="w-full xl:w-[90%] 2xl:w-[80%]  mx-auto">
            <div class="p-0 md:p-4 lg:p-6">
                <v-main>
                    <RouterView />
                </v-main>
            </div>
        </div>

    </v-app>
</template>

<script setup>

import { onMounted, computed, ref } from 'vue';

// Loader management
import { useLoaderStore } from '@/stores/loader';
const loaderStore = useLoaderStore();
const isLoading = computed(() => loaderStore.isLoading);

const drawer = ref(false);

// Route management
// import { useRoute, useRouter } from 'vue-router';
// const route = useRoute();
// const router = useRouter();
// const goBack = () => router.back()
// const showBackButton = computed(() => route.path !== '/');



const openChangelog = () => window.open('/changelog', '_blank');

const routes = [
    { title: 'Dashboard', path: '/', icon: 'mdi-view-dashboard' },
    { title: 'Curses', path: '/race', icon: 'mdi-flag-checkered' },
    { title: 'Pilots', path: '/driver', icon: 'mdi-account' },
    // { title: 'Statistics', path: '/statistics', icon: 'mdi-chart-bar' },
]

onMounted(() => {
    loaderStore.add();
    fetch('/api/frontVersion')
        .then((response) => response.json())
        .then((data) => {
            const specifiedVersion = '1.0.0';
            if (data.version > specifiedVersion) {
                window.location.reload();
                return;
            }
        })
        .catch((error) => console.error('Error fetching data:', error))
        .finally(() => loaderStore.remove());
});

</script>


<style lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Roboto:wght@300..700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap');

.v-application {
    font-family: "Roboto", sans-serif;
    font-weight: 400;
    font-style: normal;
}
</style>