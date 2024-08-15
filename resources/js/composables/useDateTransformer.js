import { computed } from 'vue';
import moment from 'moment-timezone'

export function useDateTransformer(timestamp, locale = 'ca', timezone = 'UTC') {

    timestamp = timestamp * 1000;

    moment.locale(locale);

    return {
        date: computed(() => moment.utc(timestamp).tz(timezone)),  // Treat as UTC and then convert to local timezone
        readableDate: computed(() => moment.utc(timestamp).tz(timezone).format('LL')),
        readableHour: computed(() => moment.utc(timestamp).tz(timezone).format('LLL')),
        isoString: computed(() => moment.utc(timestamp).toISOString()),
    };
}
