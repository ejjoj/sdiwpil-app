import Vue from 'vue';
import Vuetify from 'vuetify';
import Snotify, { SnotifyPosition } from 'vue-snotify';
import vuetify from '../../../plugins/vuetify';
import '../../../plugins/router';
import store from '../../../store';

import DoctorParticularChat from './components/DoctorParticularChat';

Vue.use(Vuetify);
Vue.use(Snotify, {
  toast: {
    position: SnotifyPosition.rightTop,
  },
});

// eslint-disable-next-line no-new
new Vue({
  el: '#main',
  vuetify,
  store,
  render(h) {
    return h(DoctorParticularChat);
  },
});
