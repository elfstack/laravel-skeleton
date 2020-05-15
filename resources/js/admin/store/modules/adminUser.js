import adminUser from '../../../api/admin/adminUser'
import router from '../../routes'

const state = () => ({
    id: '',
    name: '',
    email: '',
    roles: []
})

const getters = {
    adminUser (state) {
        return state
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
        if (adminUser == null) {
            state.id = ''
            state.name = ''
            state.email = ''
            state.roles = []
        }
        state.id = adminUser.id
        state.name = adminUser.name
        state.email = adminUser.email
        state.roles = adminUser.roles
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
        adminUser.getCurrent().then(({data}) => {
            commit('setAdminUser', data.admin_user)
        })
    },
    logout ({ commit }) {
        return adminUser.logout().then(({data}) => {
            router.push('/login');
            commit('setAdminUser', null)
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
