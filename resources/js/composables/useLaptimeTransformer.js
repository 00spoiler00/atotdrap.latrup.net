import { computed } from 'vue';

export function useLaptimeTransformer(ms) {

    const ms2human = (ms) => {
        const minutes = Math.floor(ms / 60000);
        const seconds = ((ms % 60000) / 1000).toFixed(3);
        return `${minutes}:${seconds.padStart(6, '0')}`;
    };

    return {
        ms2human: computed(() => ms2human(ms)),
    };
}
