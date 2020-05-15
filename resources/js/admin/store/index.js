import Vue from 'vue'
import Vuex from 'vuex'
import adminUser from './modules/adminUser'
import config from "./modules/config"

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        adminUser,
        config
    }
})

export default store
