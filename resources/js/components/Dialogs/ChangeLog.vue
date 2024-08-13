<template>

    <v-dialog max-width="800" activator="parent">

        <template v-slot:default="{ isActive }">

            <v-card>

                <v-card-title>
                    Canvis de l'aplicació
                </v-card-title>

                <v-card-text class="overflow-y-auto" style="max-height: 80dvh;">
                    <div class="markdown-content" v-html="changelog"></div>
                </v-card-text>

                <template v-slot:actions>
                    <v-btn
                        class="ml-auto"
                        text="Close"
                        @click="isActive.value = false" />
                </template>

            </v-card>
        </template>
    </v-dialog>

</template>

<script>
import { marked } from 'marked'
export default {

    name: 'ChangeLogDialog',

    data: () => ({
        changelog: '',
    }),

    mounted() {
        fetch('./CHANGELOG.md')
            .then(response => response.text())
            .then(data => this.changelog = marked.parse(data))
            .catch(error => console.error('Error fetching data:', error))
    },

}
</script>