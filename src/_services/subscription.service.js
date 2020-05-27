import config from 'config';
import {authHeader} from '../_helpers';
import {handleResponse} from '../_helpers/utility';

export const subscriptionService = {
    subscribe,
    subscriptions,
    validateSub,
};


function subscribe(service_id) {
    const requestOptions = {
        method: 'POST',
        headers: {'Content-Type': 'application/json', ...authHeader()},
        body: JSON.stringify({"service_id": service_id})
    };
    return fetch(`${config.apiUrl}/subscriptions`, requestOptions).then(handleResponse);
}

function validateSub({trxref, service_id}) {
    const requestOptions = {
        method: 'POST',
        headers: {'Content-Type': 'application/json', ...authHeader()},
        body: JSON.stringify({"trxref": trxref, "service_id": service_id})
    };
    return fetch(`${config.apiUrl}/subscriptions/callback`, requestOptions).then(handleResponse);
}

function subscriptions() {
    const requestOptions = {
        method: 'GET',
        headers: authHeader()
    };

    return fetch(`${config.apiUrl}/subscriptions`, requestOptions).then(handleResponse);
}
