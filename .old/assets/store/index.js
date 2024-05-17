import Vue from 'vue';
import Vuex from 'vuex';
import { set, merge } from 'lodash';
import modules from './modules';

Vue.use(Vuex);

const getters = {};
const mutations = {};
const actions = {};
const state = {};
const plugins = [];

// eslint-disable-next-line no-shadow
const updateStore = (store) => {
  // eslint-disable-next-line no-underscore-dangle
  store._withCommit(() => {
    // eslint-disable-next-line no-underscore-dangle
    set(store._vm._data, '$$state', merge(store._vm._data.$$state, window.state || {}));
  });
};

const store = new Vuex.Store({
  strict: process.env.NODE_ENV !== 'production',
  state,
  actions,
  mutations,
  getters,
  modules,
  plugins,
});

updateStore(store);

export default store;
