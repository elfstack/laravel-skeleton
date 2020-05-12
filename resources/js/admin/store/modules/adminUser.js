import adminUser from '../../../api/admin/adminUser'
import router from '../../routes'

const state = () => ({
    id: '',
    name: '',
    email: ''
})

const getters = {
    adminUser (state) {
        return state
    }
}

const mutations = {
    setAdminUser (state, adminUser) {
        if (adminUser == null) {
            state.id = ''
            state.name = ''
            state.email = ''
        }
        state.id = adminUser.id
        state.name = adminUser.name
        state.email = adminUser.email
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
