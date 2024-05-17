<template>
  <v-app class="dashboard--bg">
    <app-navbar
      ref="navbar"
      color-schema="doctor"
    />

    <doctor-dashboard-mobile-container
      v-if="breakpoint.mdAndDown"
      :navbar-height="navbarHeight"
      :footer-height="footerHeight"
    />

    <doctor-dashboard-desktop-container
      v-else
      :navbar-height="navbarHeight"
      :footer-height="footerHeight"
    />

    <app-footer ref="footer" />
  </v-app>
</template>

<script>
import AppNavbar from '../../../../shared/components/AppNavbar';
import AppFooter from '../../../../shared/components/AppFooter';
import DoctorDashboardMobileContainer from './DoctorDashboardMobileContainer';
import breakpoint from '../../../../mixins/breakpoint';
import mainComponentHelper from '../../../../mixins/mainComponentHelper';
import DoctorDashboardDesktopContainer from './DoctorDashboardDesktopContainer';

export default {
  name: 'DoctorDashboard',
  components: {
    DoctorDashboardDesktopContainer, DoctorDashboardMobileContainer, AppFooter, AppNavbar,
  },
  mixins: [breakpoint, mainComponentHelper],
};
</script>

<style scoped>

</style>
