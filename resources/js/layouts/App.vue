<template>
    <v-app dark>
        <v-main>

            <TopBar />

            <v-tabs
                v-model="tab"
                align-tabs="center">
                <v-tab>
                    <v-icon class="mr-2">mdi-file-document</v-icon>
                    <span class="d-none d-sm-inline">Registres</span>
                </v-tab>
                <v-tab>
                    <v-icon class="mr-2">mdi-trophy</v-icon>
                    <span class="d-none d-sm-inline">Tops</span>
                </v-tab>
                <v-tab>
                    <v-icon class="mr-2">mdi-chart-bar</v-icon>
                    <span class="d-none d-sm-inline">Ranking</span>
                </v-tab>
                <v-tab>
                    <v-icon class="mr-2">mdi-speedometer</v-icon>
                    <span class="d-none d-sm-inline">HotLaps</span>
                </v-tab>
            </v-tabs>

            <v-tabs-window v-model="tab">
                <v-tabs-window-item>
                    <Registrations />
                </v-tabs-window-item>

                <v-tabs-window-item>
                    <Movements />
                </v-tabs-window-item>

                <v-tabs-window-item>
                    <Drivers />
                </v-tabs-window-item>

                <v-tabs-window-item>
                    <Hotlaps />
                </v-tabs-window-item>

            </v-tabs-window>

            <!-- Reusable dialogs -->
            <v-dialog v-model="isDialogOpen" max-width="800">
                <v-card v-if="dialogData">
                    <v-card-title>
                        {{ dialogMode }}
                        <v-spacer></v-spacer>
                        <v-btn icon @click="isDialogOpen = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-card-title>


                    <v-card-text class="overflow-y-auto" style="max-height: 80dvh;">

                        <div class="markdown-content" v-if="['ChangeLog'].includes(dialogMode)" v-html="dialogData"></div>

                        <v-img v-if="['Circuit Image'].includes(dialogMode)" :src="'https://cdn.pitskill.io/public/TrackPhoto-' + dialogData"></v-img>

                        <v-template v-if="['Emissions'].includes(dialogMode)">
                            <div class="font-bold" v-html="dialogData"></div>
                        </v-template>

                        <v-template v-if="['Server'].includes(dialogMode)">
                            <div class="font-bold">Detalls del servidor</div>
                            <div>{{ dialogData }}</div>
                        </v-template>

                        <v-template v-if="['PitSkill', 'PitRep'].includes(dialogMode)">
                            <v-sparkline auto-draw smooth :value="dialogData" :color="dialogMode == 'PitSkill' ? 'primary' : 'secondary'" :height="300" :width="400" stroke-linecap="round" />
                        </v-template>
                    </v-card-text>

                </v-card>
            </v-dialog>

        </v-main>
    </v-app>
</template>

<script>
import TopBar from '../components/TopBar.vue';
import Registrations from '../components/Registrations.vue';
import Drivers from '../components/Drivers.vue';
import Movements from '../components/Movements.vue';
import Hotlaps from '../components/Hotlaps.vue';

export default {
    name: 'App',
    components: {
        TopBar,
        Registrations,
        Drivers,
        Movements,
        Hotlaps
    },
    data: () => ({
        tab: null,

        dialogData: null,
        dialogMode: null,
        isDialogOpen: false,
    }),

    methods: {

        openDialog(mode, data) {
            this.dialogData = data
            this.dialogMode = mode
            this.isDialogOpen = true
        },

    },

}
</script>