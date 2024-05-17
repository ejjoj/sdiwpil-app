<template>
  <v-app class="chat--bg">
    <app-navbar ref="navbar" />

    <vue-snotify />

    <patient-chat-mobile-container
      v-if="breakpoint.mdAndDown"
      :navbar-height="navbarHeight"
      :footer-height="footerHeight"
    />

    <patient-chat-desktop-container
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
import PatientChatMobileContainer from './PatientChatMobileContainer';
import PatientChatDesktopContainer from './PatientChatDesktopContainer';
import breakpoint from '../../../../mixins/breakpoint';
import mainComponentHelper from '../../../../mixins/mainComponentHelper';

export default {
  name: 'PatientChat',
  components: {
    AppFooter, AppNavbar, PatientChatMobileContainer, PatientChatDesktopContainer,
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
