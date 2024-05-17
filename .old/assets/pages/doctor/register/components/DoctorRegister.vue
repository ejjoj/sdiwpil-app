<template>
  <v-app class="register--bg">
    <vue-snotify />

    <app-navbar
      ref="navbar"
      color-schema="doctor"
    />

    <doctor-register-mobile-container
      v-if="breakpoint.mdAndDown"
      :navbar-height="navbarHeight"
      :footer-height="footerHeight"
    />

    <doctor-register-desktop-container
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
import DoctorRegisterMobileContainer from './DoctorRegisterMobileContainer';
import DoctorRegisterDesktopContainer from './DoctorRegisterDesktopContainer';
import breakpoint from '../../../../mixins/breakpoint';

export default {
  name: 'DoctorRegister',
  components: {
    AppNavbar,
    AppFooter,
    DoctorRegisterMobileContainer,
    DoctorRegisterDesktopContainer,
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
