<template>
    <div>
        <div
            v-if="license === 'Provisional'"
            class="h-8 w-28 font-bold rounded-xl border-2 bg-red-800 border-yellow-400 text-center py-1">
            Provisional
        </div>
        <div
            v-else-if="license === 'Bronze'"
            class="h-8 w-28 font-bold rounded-xl border-2 bg-red-800 border-red-800 text-center py-1">
            Bronze
        </div>
        <div
            v-else-if="license === 'Silver'"
            class="h-8 w-28 font-bold rounded-xl border-2 border-gray-400 bg-gray-400 text-center py-1 text-black">
            Silver
        </div>
        <div
            v-else-if="license === 'Platinum'"
            class="h-8 w-28 font-bold rounded-xl border-2 border-white bg-white text-center py-1 text-black">
            Platinum
        </div>
        <div
            v-else-if="license === 'Elite'"
            class="h-8 w-28 font-bold rounded-xl border-2 border-yellow-400 text-center py-1 text-yellow-400">
            Elite
        </div>
        <div
            v-else
            class="h-8 w-28 font-bold rounded-xl border-2 border-yellow-400 text-center py-1 text-yellow-400">
            ????
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

// Add a prop for the driver
const props = defineProps(['pitskill', 'pitrep']);

const license = computed(() => {
    const pitrep = props.pitrep;
    const pitskill = props.pitskill;

    if (pitrep >= 20 && pitskill >= 3500) return 'Elite';
    if (pitrep >= 15 && pitskill >= 2750) return 'Platinum';
    if (pitrep >= 10 && pitskill >= 1900) return 'Silver';
    return pitrep > 5 ? 'Bronze' : 'Provisional';
});

</script>