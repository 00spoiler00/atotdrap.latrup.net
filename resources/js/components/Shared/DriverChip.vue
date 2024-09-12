<template>
    <v-chip link pill :to="{ name: 'Driver', params: { id: props.id } }" v-bind="$attrs" :variant="props.variant">
        <v-avatar start>
            <v-img :src="avatar" />
        </v-avatar>
        {{ name }}
    </v-chip>
</template>

<script setup>

const props = defineProps({
    id: { type: Number, required: true },
    name: { type: String, required: true },
    avatar: { type: String, required: true },
    variant: {
        type: String,
        default: 'text',
        validator: (value) => ['flat' , 'text' , 'elevated' , 'tonal' , 'outlined' , 'plain'].includes(value)
    }

})

</script>