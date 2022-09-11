import moment from 'moment-timezone';

export default {
    methods: {
        formatDatetime(date) {
            return moment(date).format("YYYY-MM-DD HH:mm");
        }
    },
};
