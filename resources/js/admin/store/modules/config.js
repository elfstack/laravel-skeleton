import config from "../../../api/admin/config";

const state = () => ({
    permissions: {}
})

const getters = {
    permissions (state) {
        return state.permissions;
    }
}

const mutations = {
    setConfig( state , payload) {
        state.permissions = payload.permissions
    }
}

const actions = {
    getConfig({ commit }) {
        config.show().then(({data}) => {
            commit('setConfig', data)
        })
    },
    checkConfig({ commit }) {
        // TODO: check config for frontend
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
