import config from 'config';
import {authHeader} from '../_helpers';
import {handleResponse} from '../_helpers/utility';

export const serviceService = {
    getAll
};

/**
 * Get service endpoint
 * @returns {Promise<Response>}
 */
function getAll() {
    const requestOptions = {
        method: 'GET',
        headers: authHeader()
    };

    return fetch(`${config.apiUrl}/services`, requestOptions).then(handleResponse);
}