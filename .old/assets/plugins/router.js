import Vue from 'vue';
import _ from 'lodash';
import Routing
  from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.js';

const routes = require('../../public/js/fos_js_routes.json');

Routing.setRoutingData(routes);

const RoutingPlugin = {
  // eslint-disable-next-line no-shadow
  install(Vue) {
    // eslint-disable-next-line no-param-reassign,function-paren-newline
    Vue.prototype.$fosGenerate = (
      // eslint-disable-next-line camelcase
      name, opt_params, absolute) => {
      let result = '#';
      try {
        result = Routing.generate(name, opt_params, absolute);
        result = `/${_.trimStart(result, '/')}`;
      } catch (e) {
        console.warn(e);
      }

      return result;
    };
    // eslint-disable-next-line func-names,no-param-reassign
    Vue.prototype.$fosGetRoutes = () => Routing.getRoutes();
  },
};
Vue.use(RoutingPlugin);
