import Vue from 'vue'
import Vuex from 'vuex'
import anti from "./modules/anti"

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        anti
    }
})
