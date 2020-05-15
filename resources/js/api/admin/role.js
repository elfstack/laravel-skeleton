export default {
    index () {
        return window.axios.get('/roles')
    },

    create (role) {
        return window.axios.post('/roles', role)
    },

    show (id) {
        return window.axios.get('/roles/' + id)
    },

    update (role) {
        return window.axios.put('/roles/' + role.id, role)
    }

}
