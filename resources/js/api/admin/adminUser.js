import index from '../listing'

export default {
    login (credential) {
        return window.axios.post('/login', credential)
    },
    logout () {
        return window.axios.get('/logout')
    },
    getCurrent () {
        return window.axios.get('/admin-users/current')
    },
    updateCurrent (adminUser) {
        return window.axios.put('/admin-users/current', adminUser)
    },
    index (paramBag) {
        return index(paramBag, '/admin-users')
    },
    show (id) {
        return window.axios.get('/admin-users/' + id)
    },
    update (adminUser) {
        return window.axios.put('/admin-users/' + adminUser.id, adminUser)
    },
    create (adminUser) {
        return window.axios.post('/admin/api/admin-users/', adminUser)
    }
}
