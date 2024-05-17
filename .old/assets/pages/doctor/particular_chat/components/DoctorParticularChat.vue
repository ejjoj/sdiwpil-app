<template>
  <v-app class="chat--bg">
    <app-navbar
      ref="navbar"
      color-schema="doctor"
    />

    <vue-snotify />

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
  name: 'DoctorParticularChat',
  components: {
    AppFooter, AppNavbar, MobileContainer, DesktopContainer,
  },
  mixins: [breakpoint, mainComponentHelper],
};
</script>

<style scoped>

</style>
