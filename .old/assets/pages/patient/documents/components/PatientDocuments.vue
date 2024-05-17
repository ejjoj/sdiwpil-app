<template>
  <v-app class="documents--bg">
    <app-navbar ref="navbar" />

    <mobile-container
      v-if="breakpoint.mdAndDown"
      :footer-height="footerHeight"
      :navbar-height="navbarHeight"
    />

    <desktop-container
      v-else
      :footer-height="footerHeight"
      :navbar-height="navbarHeight"
    />

    <app-footer ref="footer" />
  </v-app>
</template>

<script>
import AppNavbar from '../../../../shared/components/AppNavbar';
import MobileContainer from './MobileContainer';
import breakpoint from '../../../../mixins/breakpoint';
import mainComponentHelper from '../../../../mixins/mainComponentHelper';
import AppFooter from '../../../../shared/components/AppFooter';
import DesktopContainer from './DesktopContainer';

export default {
  name: 'PatientDocuments',
  components: {
    DesktopContainer, AppFooter, MobileContainer, AppNavbar,
  },
  mixins: [breakpoint, mainComponentHelper],
};
</script>

<style scoped lang="scss">
@import 'assets/styles/colors';

.documents--bg {
  background-color: rgba($primary, 0.2);
}
</style>
