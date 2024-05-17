<template>
  <v-app>
    <app-navbar ref="navbar" />

    <patient-dashboard-mobile-container
      v-if="breakpoint.mdAndDown"
      :footer-height="footerHeight"
      :navbar-height="navbarHeight"
    />

    <patient-dashboard-desktop-container
      v-else
      :footer-height="footerHeight"
      :navbar-height="navbarHeight"
    />

    <app-footer ref="footer" />
  </v-app>
</template>

<script>
import AppNavbar from '../../../../shared/components/AppNavbar';
import AppFooter from '../../../../shared/components/AppFooter';
import mainComponentHelper from '../../../../mixins/mainComponentHelper';
import PatientDashboardMobileContainer from './PatientDashboardMobileContainer';
import breakpoint from '../../../../mixins/breakpoint';
import PatientDashboardDesktopContainer from './PatientDashboardDesktopContainer';

export default {
  name: 'PatientDashboard',
  components: {
    PatientDashboardDesktopContainer,
    PatientDashboardMobileContainer,
    AppFooter,
    AppNavbar,
  },
  mixins: [breakpoint, mainComponentHelper],
};
</script>

<style scoped>

</style>
