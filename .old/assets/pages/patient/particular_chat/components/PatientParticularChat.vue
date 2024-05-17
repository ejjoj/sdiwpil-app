<template>
  <v-app class="chat--bg">
    <app-navbar ref="navbar" />

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

    <app-footer ref="footer" />
  </v-app>
</template>

<script>
import AppNavbar from '../../../../shared/components/AppNavbar';
import AppFooter from '../../../../shared/components/AppFooter';
import breakpoint from '../../../../mixins/breakpoint';
import mainComponentHelper from '../../../../mixins/mainComponentHelper';
import MobileContainer from './MobileContainer';
import DesktopContainer from './DesktopContainer';

export default {
  name: 'PatientParticularChat',
  components: {
    DesktopContainer, MobileContainer, AppNavbar, AppFooter,
  },
  mixins: [breakpoint, mainComponentHelper],
};
</script>

<style scoped lang="scss">
@import 'assets/styles/colors';

.chat {
  &--bg {
    background-color: rgba($primary, 0.2);
  }
}
</style>
