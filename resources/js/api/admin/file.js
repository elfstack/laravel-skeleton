export default {
    getDiskUsage () {
        return window.axios.get('/file/disk-usage')
    },
    getCollections () {
        return window.axios.get('/file/collections')
    }
}
