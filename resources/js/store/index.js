import Vue from 'vue';
import Vuex from 'vuex';
import api from '../api';

Vue.use(Vuex);
Vue.use(require('vue-moment'));

export default new Vuex.Store({
    state: {
        token: localStorage.getItem('token') || '',
        rates: {
            current: {},
            history: [],
            period: {
                start: Vue.moment().format('YYYY-MM-DD'),
                end: Vue.moment().format('YYYY-MM-DD')
            }
        }
    },
    mutations: {
        set_period_start(state, value) {
            state.rates.period.start = value;
        },
        set_period_end(state, value) {
            state.rates.period.end = value;
        },
        auth_success(state, token) {
            state.token = token;
        },
        auth_error(state) {
            state.token = '';
        },
        logout(state) {
            state.token = '';
        },
        save_current_rate(state, data) {
            state.rates.current = data;
        },
        save_history_rates(state, data) {
            state.rates.history = data;
        },
        clear_history_rates(state) {
            state.rates.history = [];
        }
    },
    actions: {
        login({commit}, user){
            return new Promise((resolve, reject) => {
                api.login(user)
                    .then(resp => {
                        console.log(resp);
                        const token = resp.data.access_token;
                        localStorage.setItem('token', token);
                        commit('auth_success', token);
                        resolve(resp);
                    })
                    .catch(err => {
                        localStorage.removeItem('token');
                        commit('auth_error');
                        reject(err);
                    });
                });
        },
        register({commit}, user){
            return new Promise((resolve, reject) => {
                api.register(user)
                    .then(resp => {
                        const token = resp.data.access_token;
                        const user = resp.data.user;
                        localStorage.setItem('token', token);
                        commit('auth_success', token, user);
                        resolve(resp)
                    })
                    .catch(err => {
                        localStorage.removeItem('token');
                        commit('auth_error');
                        reject(err);
                    });
                });
        },
        logout({commit}){
            api.logout()
                .then(resp => {
                    commit('logout');
                    return resp;
                })
                .catch(err => {
                    console.log(err);
                    return err;
                });
        },

        getCurrentRate({commit}) {
            api.currentRate()
                .then(resp => {
                    commit('save_current_rate', resp.data);
                })
                .catch(err => {
                    console.log(err);

                });
        },

        getHistory({commit, getters}) {
            api.ratesHistory({
                start: getters.getPeriodStart,
                end: getters.getPeriodEnd
            })
                .then(resp => {
                    commit('save_history_rates', resp.data.rates);
                })
                .catch(err => {
                    console.log(err);

                });
        },

    },
    getters : {
        isLoggedIn: state => !!state.token,
        currentRates: state => state.rates.current,
        historyRates: state => state.rates.history,
        getPeriodStart: state => state.rates.period.start,
        getPeriodEnd: state => state.rates.period.end,
    }
})
