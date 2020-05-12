export default {
    apiPrefix: '/admin/api',

    index () {
        return window.axios.get(this.apiPrefix + '/permissions')
    },

    create (role) {
        return window.axios.post(this.apiPrefix + '/roles', role)
    },

    show (id) {
        return window.axios.get(this.apiPrefix + '/roles/' + id)
    }

}
