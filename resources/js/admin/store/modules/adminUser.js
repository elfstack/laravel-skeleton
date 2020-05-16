import adminUser from '../../../api/admin/adminUser'
import router from '../../routes'

const state = () => ({
    id: '',
    name: '',
    email: '',
    roles: [],
    loaded: false
})

const getters = {
    adminUser (state) {
        return state
    },
    loaded (state) {
        return state.loaded
    },
    can: (state, getters, rootState, rootGetters) => (permission) => {
        // setting up first
        const roles = rootGetters['config/permissions'][permission]
        if (!roles) {
            return false
        }
        const myRoles = state.roles

        let tmp = roles.concat(myRoles)

        return new Set(tmp).size < tmp.length
    }
}

const mutations = {
    setAdminUser (state, adminUser) {
        if (adminUser === null) {
            state.id = ''
            state.name = ''
            state.email = ''
            state.roles = []
        } else {
            state.id = adminUser.id
            state.name = adminUser.name
            state.email = adminUser.email
            state.roles = adminUser.roles
        }
    },
    setLoaded (state, loaded) {
        state.loaded = loaded
    }
}

const actions = {
    login ({ commit, state, dispatch }, credential) {
        return adminUser.login(credential).then(({data}) => {
            dispatch('getAdminUser')
            router.push('/')
        })
    },
    getAdminUser({ commit }) {
        return adminUser.getCurrent().then(({data}) => {
            commit('setAdminUser', data.admin_user)
            commit('setLoaded', true)
        })
    },
    logout ({ commit }) {
        return adminUser.logout().then(({data}) => {
            router.push('/login');
            commit('setAdminUser', null)
            commit('setLoaded', false)
        })
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
