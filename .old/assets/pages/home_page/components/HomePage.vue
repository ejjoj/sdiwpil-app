<template>
  <v-app class="home-page--bg">
    <app-navbar ref="navbar" />

    <vue-snotify />

    <mobile-container
      v-if="breakpoint.mdAndDown"
      :navbar-height="navbarHeight"
      :footer-height="footerHeight"
    />

    <main-container
      v-else
      :navbar-height="navbarHeight"
      :footer-height="footerHeight"
    />

    <app-footer ref="footer" />
  </v-app>
</template>

<script>
import { mapState } from 'vuex';
import AppNavbar from '../../../shared/components/AppNavbar';
import AppFooter from '../../../shared/components/AppFooter';
import MobileContainer from './MobileContainer';
import MainContainer from './MainContainer';
import breakpoint from '../../../mixins/breakpoint';
import mainComponentHelper from '../../../mixins/mainComponentHelper';
import { HOME_PAGE } from '../../../store/module-namespaces';
import { ERRORS } from '../../../store/module-state-properties';

export default {
  name: 'HomePage',
  components: {
    AppNavbar, AppFooter, MobileContainer, MainContainer,
  },
  mixins: [breakpoint, mainComponentHelper],
  computed: {
    ...mapState(HOME_PAGE, {
      errors: ERRORS,
    }),
  },
  mounted() {
    this.handleAccessDeniedErrors();
  },
  methods: {
    handleAccessDeniedErrors() {
      this.errors.forEach((error) => this.$snotify.error(error.message));
    },
  },
};
</script>

<style scoped lang="scss">
@import '../../../styles/colors';

.container {
  position: relative;
  z-index: 2;
  overflow-x: hidden;
}

.home-page {
  &--bg {
    background-color: rgba($primary, 0.2);
  }
}
</style>
