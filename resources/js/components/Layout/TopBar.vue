<template>

<v-system-bar app height="2" absolute>
    <v-progress-linear
            v-if="isLoading"
            color="accent"
            height="1"
            indeterminate />
    </v-system-bar>

    <v-app-bar app class="elevation-4">

        <!-- Add a standard history back vuetify button -->
        <v-btn icon @click="goBack" v-if="showBackButton">
        <v-icon>mdi-arrow-left</v-icon>
      </v-btn>
        
        <!-- This should stick to the left -->
        <v-toolbar-title>
            <div class="flex items-center justify-center">
                <a href="https://discord.gg/GFvYkjYbta">
                    <v-avatar size="36" my-1>
                        <v-img src="./images/icons/android-chrome-192x192.png" />
                    </v-avatar>
                </a>
                <span class="ml-4 font-bold hidden sm:block">PitSkill A Tot Drap</span>
            </div>
        </v-toolbar-title>

        <!-- This should be grouped with next section (v-btn and v-progress-circular) and everything be sticked to the right -->
        <!-- <v-img src="./images/pitskill.png" height="16" /> -->

        <!-- This should be sticked to the right and keep this vertical disposition as is -->
        <div class="flex flex-col items-end">
            <v-btn x-small icon class="mb-2" to="/changelog">
                <v-icon color="primary">mdi-file-document-outline</v-icon>
            </v-btn>
        </div>
    </v-app-bar>
</template>

<script setup>
import { onMounted, computed} from 'vue';

import { useLoaderStore } from '@/stores/loader';
const loaderStore = useLoaderStore();
const isLoading = computed(() => loaderStore.isLoading);


import { useRoute, useRouter } from 'vue-router';
const route = useRoute();
const router = useRouter();
const goBack = () => router.back()
const showBackButton = computed(() => route.path !== '/');

const checkFrontVersion = () => {
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
};

onMounted(() => checkFrontVersion());
</script>