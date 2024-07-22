import { createStore } from "vuex";
import * as module from "./modules";

const store = createStore({
    state: {
        csrf: document.querySelector('meta[name="csrf-token"]').content
    },
    // same as computed properties from state
    getters: {
        csrf(state) {
            return state.csrf;
        },
    },

    // for sync actions
    mutations: {},

    // for async actions
    actions: {},

    modules: {
        homePageCounts: module.homePageCounts,
        settings: module.settings,
        authUser: module.authUser,
        card: module.card,
        user: module.cache,
        notification: module.cache,
        banner: module.cache,
        service: module.cache,
        account: module.cache,
        bank: module.cache,
        kyc: module.cache,
        bankaccounttype: module.cache,
        bankservicetype: module.cache,
        bimaaccount: module.cache,
        bima: module.cache,
        bimaaccounttype: module.cache,
        loan: module.cache,
        bankloantype: module.cache,
        servicerequest: module.cache,
        serviceprovider: module.cache,
    },
});

export default store;
