<template>
    <div :class="licenseClass">
        {{ licenseString }}
    </div>
</template>

<script setup>
import { computed } from 'vue';


import { useDisplay } from 'vuetify'
const display = useDisplay()

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

const licenseString = computed(() => display.name.value === 'xs' ? license.value[0] : license.value);

// create a computed property for the classes based on the license
const licenseClass = computed(() => {
    const licenseColors = {
        Provisional: 'bg-red-800 border-red-800',
        Bronze: 'bg-red-800 border-red-800',
        Silver: 'border-gray-400 bg-gray-400 text-black',
        Platinum: 'border-white bg-white text-black',
        Elite: 'bg-yellow-400 border-yellow-400',
    };

    // If the breakpoint is mobile, return w-10, otherwise return w-24
    const baseClasses = display.name.value === 'xs' ? 'w-10' : 'w-24';

    return `h-8 font-bold rounded-xl border-1 pt-[6px] text-center ${baseClasses} ${licenseColors[license.value]}`
});


</script>