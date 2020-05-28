import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

function setToken() {
    const token = localStorage.getItem('token')
    if (token) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    }
}

function removeToken() {
    localStorage.removeItem('token');
    delete axios.defaults.headers.common['Authorization'];
}

const api = {
    login: function(data) {
        return axios.post('/api/login', data);
    },
    register: function (data) {
        return axios.post('/api/register', data);
    },
    logout: function() {
        setToken();
        return axios.post('/api/logout')
            .then(resp => {
                removeToken();
                return resp;
            })
            .catch(err => {
                removeToken();
            });
    },
    currentRate: function() {
        setToken();
        return axios.get('/api/rates/current')
            .catch(err => {
                removeToken();
            });
    },
    ratesHistory: function(data) {
        return axios.post('/api/rates/history', data)
            .catch(err => {
                removeToken();
            });
    }
};

export default api;
