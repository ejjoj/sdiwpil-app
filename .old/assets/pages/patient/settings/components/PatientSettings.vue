<template>
  <v-app>
    <app-navbar ref="navbar" />

    <vue-snotify />

    <patient-settings-mobile-container
      v-if="breakpoint.mdAndDown"
      :navbar-height="navbarHeight"
      :footer-height="footerHeight"
    />

    <patient-settings-desktop-container
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
import PatientSettingsMobileContainer from './PatientSettingsMobileContainer';
import PatientSettingsDesktopContainer from './PatientSettingsDesktopContainer';

export default {
  name: 'PatientSettings',
  components: {
    PatientSettingsDesktopContainer, PatientSettingsMobileContainer, AppFooter, AppNavbar,
  },
  mixins: [breakpoint, mainComponentHelper],
};
</script>

<style scoped>

</style>
