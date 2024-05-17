<template>
  <v-app class="chat--bg">
    <app-navbar
      ref="navbar"
      color-schema="doctor"
    />

    <vue-snotify />

    <doctor-chats-mobile-container
      v-if="breakpoint.mdAndDown"
      :navbar-height="navbarHeight"
      :footer-height="footerHeight"
    />

    <doctor-chats-desktop-container
      v-else
      :navbar-height="navbarHeight"
      :footer-height="footerHeight"
    />

    <app-footer
      ref="footer"
    />
  </v-app>
</template>

<script>
import AppNavbar from '../../../../shared/components/AppNavbar';
import AppFooter from '../../../../shared/components/AppFooter';
import DoctorChatsMobileContainer from './DoctorChatsMobileContainer';
import DoctorChatsDesktopContainer from './DoctorChatsDesktopContainer';
import breakpoint from '../../../../mixins/breakpoint';
import mainComponentHelper from '../../../../mixins/mainComponentHelper';

export default {
  name: 'DoctorDocuments',
  components: {
    DoctorChatsDesktopContainer, DoctorChatsMobileContainer, AppNavbar, AppFooter,
  },
  mixins: [breakpoint, mainComponentHelper],
};
</script>

<style scoped lang="scss">
@import 'assets/styles/colors';

.chat {
  &--bg {
    background-color: rgba($secondary, 0.2);
  }
}
</style>
