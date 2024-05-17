<template>
  <v-app>
    <app-navbar
      ref="navbar"
      color-schema="receptionist"
    />

    <receptionist-dashboard-mobile-container
      v-if="breakpoint.mdAndDown"
      :navbar-height="navbarHeight"
      :footer-height="footerHeight"
    />

    <receptionist-dashboard-desktop-container
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
import ReceptionistDashboardMobileContainer from './ReceptionistDashboardMobileContainer';
import breakpoint from '../../../../mixins/breakpoint';
import mainComponentHelper from '../../../../mixins/mainComponentHelper';
import ReceptionistDashboardDesktopContainer from './ReceptionistDashboardDesktopContainer';

export default {
  name: 'ReceptionistDashboard',
  components: {
    ReceptionistDashboardDesktopContainer, ReceptionistDashboardMobileContainer, AppFooter, AppNavbar,
  },
  mixins: [breakpoint, mainComponentHelper],
};
</script>

<style scoped>

</style>
