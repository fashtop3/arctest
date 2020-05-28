import {serviceService} from '../_services';

const state = {
    all: {}
};

const actions = {
    getAll({commit}) {
        commit('getAllServices');

        serviceService.getAll()
            .then(
                ({data}) => commit('getAllSuccess', data),
                error => commit('getAllFailure', error)
            );
    },
};

const mutations = {
    getAllServices(state) {
        state.all = {loading: true};
    },
    getAllSuccess(state, services) {
        state.all = {items: services};
    },
    getAllFailure(state, error) {
        state.all = {error};
    },
};

export const services = {
    namespaced: true,
    state,
    actions,
    mutations
};
