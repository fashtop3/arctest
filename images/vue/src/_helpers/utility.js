export const o = (o, f, d = '') => o && o[f] ? o[f] : d;

export const normalizeData = (arr = [], key = 'id') => {
    return arr.reduce((obj, item) => {
        obj[item[key]] = item;
        return obj
    }, {})
};

export const formatter = new Intl.NumberFormat('en-US', {
    style: 'decimal',
    // currency: 'NGN',
    minimumFractionDigits: 2
});

export const checkNull = field => !!field ? field : '';
export const hasAttr = (obj, key) => !!obj && checkNull(obj[key]) ? obj[key] : '';

export const handleResponse = function (response) {
    return response.json()
        .catch(data => {
            if (!response.ok) {
                if (response.status === 401) {
                    // auto logout if 401 response returned from api
                    logout();
                    window.location.reload(true);
                }

                const error = (data && data.message) || response.statusText;
                return Promise.reject(error);
            }
        });
}


export const logout = function() {
    // remove user from local storage to log user out
    localStorage.removeItem('user');
}