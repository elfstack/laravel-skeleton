import Vue from 'vue'
import Vuex from 'vuex'
import adminUser from './modules/adminUser'

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        adminUser
    }
})

export default store
