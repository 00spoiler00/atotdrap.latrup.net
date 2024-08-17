<template>
    <v-card v-if="dashboard">

        <v-toolbar height="48">
            <v-toolbar-title text="Pitskill IO" />
        </v-toolbar>

        <v-card>

            <v-row class="ma-2">
                <v-col cols="12" md="4">
                    <DashboardCard :data="dashboard.pitskill.races" />
                </v-col>
                <v-col cols="12" md="4">
                    <DashboardCard :data="dashboard.pitskill.pitskill.ranking" />
                </v-col>

                <v-col cols="12" md="4">
                    <DashboardCard :data="dashboard.pitskill.pitrep.ranking" />
                </v-col>
            </v-row>

            <v-toolbar height="24">
                <v-toolbar-title text="Setmanals" />
            </v-toolbar>

            <v-row class="ma-2">

                <v-col cols="12" md="4">

                    <DashboardCard :data="dashboard.pitskill.hotlaps" />

                    <!-- <v-card flat subtitle="Hotlaps">
                        <v-list>
                            <v-list-item rounded="shaped" v-for="i in 3" :key="i" :to="{ name: 'Driver', params: { id: i } }">
                                <template v-slot:prepend>
                                    <v-avatar>
                                        <v-img src="./images/icons/android-chrome-192x192.png" />
                                    </v-avatar>
                                </template>
                                <v-list-item-title>J.Joan</v-list-item-title>
                                <v-list-item-subtitle>Mercedes Benz</v-list-item-subtitle>
                                <template v-slot:append>
                                    <v-chip size="small">1.54.23</v-chip>
                                </template>
                            </v-list-item>
                        </v-list>
                    </v-card> -->
                </v-col>

                <v-col cols="12" md="4">
                    <v-card flat subtitle="SkillEarners">
                        <v-list>
                            <v-list-item rounded="shaped" v-for="i in 3" :key="i" :to="{ name: 'Driver', params: { id: i } }">
                                <template v-slot:prepend>
                                    <v-avatar>
                                        <v-img src="./images/icons/android-chrome-192x192.png" />
                                    </v-avatar>
                                </template>
                                <v-list-item-title>TODO</v-list-item-title>
                                <template v-slot:append>
                                    <v-chip size="small" color="success">345</v-chip>
                                </template>
                            </v-list-item>
                        </v-list>
                    </v-card>
                </v-col>

                <v-col cols="12" md="4">
                    <v-card flat subtitle="RepEarners">
                        <v-list>
                            <v-list-item rounded="shaped" v-for="i in 3" :key="i" :to="{ name: 'Driver', params: { id: i } }">
                                <template v-slot:prepend>
                                    <v-avatar>
                                        <v-img src="./images/icons/android-chrome-192x192.png" />
                                    </v-avatar>
                                </template>
                                <v-list-item-title>TODO</v-list-item-title>
                                <template v-slot:append>
                                    <v-chip size="small" color="success">345</v-chip>
                                </template>
                            </v-list-item>
                        </v-list>
                    </v-card>
                </v-col>

            </v-row>

        </v-card>

        <v-toolbar height="48">
            <v-toolbar-title text="Low Fuel Motorsport" />
        </v-toolbar>

        <v-card>
            <v-row>
                <v-col cols="12" sm="6">
                    <v-card flat subtitle="PitSkill ranking">
                        <v-list>
                            <v-list-item rounded="shaped" v-for="i in 3" :key="i">
                                <v-list-item-title>TODO</v-list-item-title>
                                <v-list-item-subtitle>2234</v-list-item-subtitle>
                            </v-list-item>
                        </v-list>
                    </v-card>
                </v-col>

                <v-col cols="12" sm="6">
                    <v-card flat subtitle="PitRep ranking">
                        <v-list>
                            <v-list-item rounded="shaped" v-for="i in 3" :key="i">
                                <v-list-item-title>TODO</v-list-item-title>
                                <v-list-item-subtitle>2345</v-list-item-subtitle>
                            </v-list-item>
                        </v-list>
                    </v-card>
                </v-col>

            </v-row>
        </v-card>


    </v-card>

</template>

<script setup>

import { ref, onMounted } from 'vue';
import DashboardCard from '../Shared/DashboardCard.vue';

const dashboard = ref(false);

onMounted(() => {
    fetch('/api/dashboard')
        .then(response => response.json())
        .then(data => dashboard.value = data);
})

</script>