<template>
  <v-app class="register--bg">
    <vue-snotify />

    <app-navbar ref="navbar" />

    <patient-register-mobile-container
      v-if="breakpoint.mdAndDown"
      :navbar-height="navbarHeight"
      :footer-height="footerHeight"
    />

    <patient-register-desktop-container
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
import mainComponentHelper from '../../../../mixins/mainComponentHelper';
import PatientRegisterMobileContainer from './PatientRegisterMobileContainer';
import PatientRegisterDesktopContainer from './PatientRegisterDesktopContainer';
import breakpoint from '../../../../mixins/breakpoint';

export default {
  name: 'PatientRegister',
  components: {
    AppNavbar,
    AppFooter,
    PatientRegisterMobileContainer,
    PatientRegisterDesktopContainer,
  },
  mixins: [breakpoint, mainComponentHelper],
};
</script>

<style scoped lang="scss">
@import 'assets/styles/colors';

.container {
  position: relative;
  z-index: 2;
  overflow-x: hidden;
}

.register {
  &--bg {
    background-color: rgba($primary, 0.2);
  }
}
</style>
