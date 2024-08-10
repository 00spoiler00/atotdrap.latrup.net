<template>

    <v-app-bar app class="elevation-4">

        <!-- This should stick to the left -->
        <v-toolbar-title>
            <div class="flex items-center justify-center">
                <a href="https://discord.gg/GFvYkjYbta">
                    <v-avatar size="36" my-1>
                        <v-img src='./images/icons/android-chrome-192x192.png' />
                    </v-avatar>
                </a>
                <span class="ml-4 font-bold hidden sm:block">
                    PitSkill A Tot Drap
                </span>
            </div>
        </v-toolbar-title>

        <v-spacer></v-spacer>


        <!-- This should be in the center -->
        <small>Actualitzat: {{ timeUntil(lastUpdate) }}</small>

        <v-spacer></v-spacer>


        <!-- This should be grouped with next section (v-btn and v-progress-circular) and everything be sticked to the right -->

        <div class="mr-4 hidden sm:block">
            <a href="https://www.pitskill.io">
                <v-img src='./images/pitskill.png' style="height: 16px" />
            </a>
        </div>

        <!-- This should be sticked to the right and keep this vertical disposition as is -->
        <div class="flex flex-col items-end">
            <v-btn x-small icon @click="showChangeLog()" class="mb-2">
                <v-icon color="primary">mdi-file-document-outline</v-icon>
            </v-btn>

            <v-progress-circular
                :rotate="-90"
                :size="12"
                :width="6"
                :value="countdownValue"
                color="primary"
                class="mr-1">
            </v-progress-circular>
        </div>

    </v-app-bar>
</template>

<script>
import moment from 'moment'
export default {

    name: 'App',

    data: () => ({
        progress: 100,
        interval: null,
        countdownValue: 100,
        countdownTime: 10,
        lastUpdate: 0,
    }),

    created() {
        this.startCountdown()
    },

    methods: {

        fetchData() {

            fetch('/data.json')
                .then(response => response.json())
                .then(data => {

                    const specifiedVersion = 2
                    if (data.version > specifiedVersion) {
                        window.location.reload()
                        return
                    }
                    this.lastUpdate = data.lastUpdate
                })
                .catch(error => console.error('Error fetching data:', error))

        },

        startCountdown() {
            setInterval(() => {
                if (this.countdownTime > 0) {
                    this.countdownTime--
                    this.countdownValue = (this.countdownTime / 10) * 100
                } else {
                    this.countdownTime = 10
                    this.fetchData()
                }
            }, 1000)
        },

        timeUntil(dateString) {
            return moment(dateString, "DD/MM/YY HH:mm").fromNow()
        },

        showChangeLog() {
            fetch('./README.md')
                .then(response => response.text())
                .then(data => this.openDialog('ChangeLog', marked.parse(data)))
                .catch(error => console.error('Error fetching data:', error))
        },

    },

    beforeDestroy() {
        clearInterval(this.interval)
    },

}
</script>