import { get } from 'lodash';

const chatRouteScreenHeaderMixin = {
  data: () => ({
    routeScreenHeader: 'Czat',
  }),
  mounted() {
    this.setRouteScreenHeader();
  },
  methods: {
    setRouteScreenHeader() {
      this.routeScreenHeader = get(window, 'state.routeScreenHeader', this.routeScreenHeader);
    },
  },
};

export default chatRouteScreenHeaderMixin;
