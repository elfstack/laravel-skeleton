export default {
    show () {
        // TODO: consider changing to websocket later
        return window.axios.get('/config')
    }
}
