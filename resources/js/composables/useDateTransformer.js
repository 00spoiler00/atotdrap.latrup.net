import { computed } from 'vue';
import moment from 'moment';


export function useDateTransformer(timestamp, locale = 'ca') {

    moment.locale(locale);

    return {
        date: computed(() => moment(timestamp)),
        readableDate: computed(() => moment(timestamp).format('LL')),
        readableHour: computed(() => moment(timestamp).format('LLL')),
        isoString: computed(() => moment(timestamp).toISOString()),
    };
}
