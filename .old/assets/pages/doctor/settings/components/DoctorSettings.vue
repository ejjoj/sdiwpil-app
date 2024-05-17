<template>
  <v-app>
    <app-navbar
      ref="navbar"
      color-schema="doctor"
    />

    <vue-snotify />

    <doctor-settings-mobile-container
      v-if="breakpoint.mdAndDown"
      :navbar-height="navbarHeight"
      :footer-height="footerHeight"
    />

    <doctor-settings-desktop-container
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
import breakpoint from '../../../../mixins/breakpoint';
import mainComponentHelper from '../../../../mixins/mainComponentHelper';
import DoctorSettingsMobileContainer from './DoctorSettingsMobileContainer';
import DoctorSettingsDesktopContainer from './DoctorSettingsDesktopContainer';

export default {
  name: 'DoctorDocuments',
  components: {
    DoctorSettingsDesktopContainer, DoctorSettingsMobileContainer, AppNavbar, AppFooter,
  },
  mixins: [breakpoint, mainComponentHelper],
};
</script>

<style scoped>

</style>
