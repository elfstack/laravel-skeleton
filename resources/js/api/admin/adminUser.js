export default {
    apiPrefix: '/admin/api',

    login (credential) {
        return window.axios.post(this.apiPrefix + '/login', credential)
    },
    logout () {
        return window.axios.get(this.apiPrefix + '/logout')
    },
    getCurrent () {
        return window.axios.get(this.apiPrefix + '/admin-users/current')
    }
}
