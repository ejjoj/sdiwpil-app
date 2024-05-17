<template>
  <v-app class="receptionist--bg">
    <app-navbar
      ref="navbar"
      color-schema="receptionist"
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
      color-schema="receptionist"
    />
  </v-app>
</template>

<script>
import AppNavbar from '../../../../shared/components/AppNavbar';
import AppFooter from '../../../../shared/components/AppFooter';
import breakpoint from '../../../../mixins/breakpoint';
import mainComponentHelper from '../../../../mixins/mainComponentHelper';
import MobileContainer from './MobileContainer';
import DesktopContainer from './DesktopContainer';

export default {
  name: 'ReceptionistRegisterManagement',
  components: {
    DesktopContainer, MobileContainer, AppFooter, AppNavbar,
  },
  mixins: [breakpoint, mainComponentHelper],
};
</script>

<style scoped lang="scss">
@import "assets/styles/colors";

.receptionist--bg {
  background-color: rgba($accent, .2);
}
</style>
