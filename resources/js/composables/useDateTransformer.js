import { computed } from 'vue';
import moment from 'moment-timezone'

export function useDateTransformer(datetime, locale = 'ca') {

    console.log(datetime)
    const m = moment(datetime);
    moment.locale(locale);

    return {
        date: computed({
            get: () => m.format('DD/MM/YYYY'),
            set: (value) => m = moment(value).format('u')
        }),
        time: computed({
            get: () => m.format('HH:mm'),
            set: (value) => m = moment(value).format('u')
        }),
        timeFromNow: computed({
            get:() => m.format('DD/MM HH:mm') + ' (' + m.fromNow() + ')',
            set: (value) => m = moment(value).format('u')
        }),
        fromNow: computed({
            get:() => m.fromNow(),
            set: (value) => m = moment(value).format('u')
        }),
        hDate: computed({
            get:() => m.format('LL'),
            set: (value) => m = moment(value).format('u')
        }),
        hTime: computed({
            get:() => m.format('LLL'),
            set: (value) => m = moment(value).format('u')
        }),
        isoString: computed({
            get:() => m.toISOString(),
            set: (value) => m = moment(value).format('u')
        }),
    };
}
