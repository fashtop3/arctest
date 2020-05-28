import {subscriptionService} from '../_services';
import {normalizeData} from "../_helpers/utility";

const state = {
    all: {},
    validate: {},
    sub: {}
};

const actions = {
    /**
     * fetch service subscription list
     * @param commit
     */
    getAllSub({commit}) {
        commit('getAllSub');

        subscriptionService.subscriptions()
            .then(
                (data) => commit('getAllSubSuccess', data),
                error => commit('getAllSubFailure', error)
            );
    },

    /**
     * Subscription validation endpoint
     * @param commit
     * @param subdata
     * @returns {Promise<unknown>}
     */
    validateSub({commit}, subdata) {
        commit('validate');

        return subscriptionService.validateSub(subdata)
            .then(
                ({data}) => commit('validateSubSuccess', data),
                error => commit('validateSubFailure', error)
            );
    },

    /**
     * Subscribe to a service
     * @param commit
     * @param service_id
     */
    subscribe({commit}, service_id) {
        commit('subscribe');

        subscriptionService.subscribe(service_id)
            .then(
                ({data}) => {
                    // commit('subSuccess', data)
                    //redirect user to complete transaction
                    window.location.href = data.authorization_url;
                },
                error => commit('subFailure', error)
            );
    },
};

const mutations = {
    getAllSub(state) {
        state.all = {loading: true};
    },
    getAllSubSuccess(state, subs) {
        // console.log(normalizeData(subs))
        state.all = normalizeData(subs);
    },
    getAllSubFailure(state, error) {
        state.all = {error};
    },
    validate(state, data) {
        state.validate = {loading: true}
    },
    validateSubSuccess(state, data) {
        state.validate = {data: data}
    },
    validateSubFailure(state, error) {
        state.validate = {error}
    },
    subscribe(state) {
        state.sub = {loading: true}
    },
    subSuccess(state, data) {
        state.sub = {data}
    },
    subFailure(state, err) {
        state.validate = {error: true, err}
    }
};

export const subscription = {
    namespaced: true,
    state,
    actions,
    mutations
};
