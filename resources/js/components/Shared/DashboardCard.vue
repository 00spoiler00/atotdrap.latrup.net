<template>
    <v-card flat :subtitle="props.data.title">
        <v-list>
            <v-list-item rounded="shaped" v-for="i in props.data.data" :key="i.id" :to="{ name: props.data.targetModel, params: { id: i.id } }">
                <template v-slot:prepend>
                    <v-avatar>
                        <v-img :src="i.avatar" />
                    </v-avatar>
                </template>
                <v-list-item-title v-text="i.title" />
                <v-list-item-subtitle v-if="i.subtitle" v-text="i.subtitle" />
                <template v-slot:append>
                    <v-chip :color="i.value.color" size="small" v-text="i.value.text" />
                </template>
            </v-list-item>
        </v-list>
    </v-card>
</template>

<script setup>

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
});

</script>