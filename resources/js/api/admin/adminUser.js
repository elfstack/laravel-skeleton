import index from '../listing'

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
    },
    index (paramBag) {
        return index(paramBag, '/admin/api/admin-users')
    },
    show (id) {
        return window.axios.get(this.apiPrefix + '/admin-users/' + id)
    },
    update (adminUser) {
        return window.axios.put(this.apiPrefix + '/admin-users/' + adminUser.id, adminUser)
    },
    create (adminUser) {
        return window.axios.post(this.apiPrefix + '/admin-users/', adminUser)
    }
}
