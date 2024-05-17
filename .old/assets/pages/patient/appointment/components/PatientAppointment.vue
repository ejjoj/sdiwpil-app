<template>
  <v-app class="appointment--bg">
    <app-navbar ref="navbar" />

    <vue-snotify />

    <patient-appointment-mobile-container
      v-if="breakpoint.mdAndDown"
      :footer-height="footerHeight"
      :navbar-height="navbarHeight"
    />

    <patient-appointment-desktop-container
      v-else
      :footer-height="footerHeight"
      :navbar-height="navbarHeight"
    />

    <app-footer ref="footer" />
  </v-app>
</template>

<script>
import mainComponentHelper from '../../../../mixins/mainComponentHelper';
import breakpoint from '../../../../mixins/breakpoint';
import PatientAppointmentMobileContainer from './PatientAppointmentMobileContainer';
import PatientAppointmentDesktopContainer from './PatientAppointmentDesktopContainer';
import AppNavbar from '../../../../shared/components/AppNavbar';
import AppFooter from '../../../../shared/components/AppFooter';

export default {
  name: 'PatientAppointment',
  components: {
    PatientAppointmentDesktopContainer, PatientAppointmentMobileContainer, AppNavbar, AppFooter,
  },
  mixins: [breakpoint, mainComponentHelper],
};
</script>

<style scoped lang="scss">
@import "assets/styles/colors";

.appointment--bg {
  background-color: rgba($primary, 0.2);
}
</style>
