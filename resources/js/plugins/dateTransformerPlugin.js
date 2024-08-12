import moment from 'moment';
moment.locale('ca');

export default {
    install(app) {
        app.config.globalProperties.$dateTransformer = {
            date: (timestamp) => moment(timestamp).format('LL'),
        };
    }
};