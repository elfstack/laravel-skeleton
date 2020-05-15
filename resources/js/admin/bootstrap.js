import router from './routes'
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

const axios = require('axios');

window.axios = axios.create({
    baseURL: '/admin/api',
    withCredentials: true,
    headers: {
        common: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    }
})

