<template>
  <v-app class="main--bg">
    <vue-snotify />

    <app-navbar ref="navbar" />

    <mobile-container
      v-if="breakpoint.mdAndDown"
      :navbar-height="navbarHeight"
      :footer-height="footerHeight"
    />

    <desktop-container
      v-else
      :navbar-height="navbarHeight"
      :footer-height="footerHeight"
    />

    <app-footer ref="footer" />
  </v-app>
</template>

<script>
import AppNavbar from '../../../shared/components/AppNavbar';
import MobileContainer from './MobileContainer';
import DesktopContainer from './DesktopContainer';
import breakpoint from '../../../mixins/breakpoint';
import mainComponentHelper from '../../../mixins/mainComponentHelper';
import AppFooter from '../../../shared/components/AppFooter';

export default {
  name: 'AppLogin',
  components: {
    AppFooter, AppNavbar, MobileContainer, DesktopContainer,
  },
  mixins: [breakpoint, mainComponentHelper],
};
</script>

<style scoped lang="scss">
@import "assets/styles/colors";

.management--bg {
  background-color: rgba($primary, .2);
}
</style>
