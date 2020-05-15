export default {

    index () {
        return window.axios.get('/permissions')
    },

    create (role) {
        return window.axios.post('/roles', role)
    },

    show (id) {
        return window.axios.get('/roles/' + id)
    },


}
