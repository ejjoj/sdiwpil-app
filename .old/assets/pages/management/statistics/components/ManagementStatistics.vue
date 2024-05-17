<template>
  <v-app class="management--bg">
    <app-navbar
      ref="navbar"
      color-schema="management"
    />

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

    <app-footer
      ref="footer"
      color-schema="management"
    />
  </v-app>
</template>

<script>
import AppNavbar from '../../../../shared/components/AppNavbar';
import AppFooter from '../../../../shared/components/AppFooter';
import MobileContainer from './MobileContainer';
import DesktopContainer from './DesktopContainer';
import breakpoint from '../../../../mixins/breakpoint';
import mainComponentHelper from '../../../../mixins/mainComponentHelper';

export default {
  name: 'ManagementStatistics',
  components: {
    DesktopContainer, MobileContainer, AppFooter, AppNavbar,
  },
  mixins: [breakpoint, mainComponentHelper],
};
</script>

<style scoped lang="scss">
@import "assets/styles/colors";

.management--bg {
  background-color: rgba($success, .2);
}
</style>
