import Vue from 'vue'

var state = {
    user: {},
    images: [],
    shop: {},
    token: '',
    shippingBars: [],
    traffic: 0,
    avg_timing: 0,
    custom_code: {},
    currencies: [],
    sessions: [],
    statistics: {
        total_clicks: 0,
        total_currencies_show: 0
    },
    clicks: []
}

var getters = {
    getToken: (state) => {
        return state.token;
    }

}

var mutations = {
    SET_USER(state, { user }) {
        state.user = user;
    },
    SET_IMAGES(state, { images }) {
        state.images = images;
    },
    SET_SHOP(state, { shop }) {
        state.shop = shop;
    },
    SET_TOKEN(state, { token }) {
        state.token = token;
    },
    SET_SHIPPING_BARS(state, { shippingBars }) {
        state.shippingBars = shippingBars;
    },
    SET_TRAFFIC(state, { traffic }) {
        state.traffic = traffic;
    },
    SET_AVG_TIMING(state, { avg_timing }) {
        state.avg_timing = avg_timing;
    },
    SET_CUSTOM_CODE(state, { custom_code }) {
        state.custom_code = custom_code
    },
    SET_CURRENCIES(state, { currencies }) {
        state.currencies = currencies
    },
    SET_SESSIONS(state, { sessions }) {
        state.sessions = sessions;
    },
    SET_STATISTICS(state, { statistics }) {
        state.statistics = statistics
    },
    SET_CLICKS(state, { clicks }) {
        state.clicks = clicks
    }
}

var actions = {

}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
