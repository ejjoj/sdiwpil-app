<template>
  <div>
    <v-app-bar
      fixed
      :color="color"
    >
      <v-app-bar-nav-icon
        v-if="breakpoint.mdAndDown"
        color="white"
        class="navbar-btn"
        @click="drawer = true"
      />

      <v-spacer v-if="breakpoint.mdAndDown" />

      <a
        style="text-decoration: none;"
        :href="$fosGenerate('front.home_page')"
      >
        <v-toolbar-title class="white--text">
          {{ title }}
        </v-toolbar-title>
      </a>

      <menu-items
        v-if="breakpoint.width > 1376"
        class="ml-4 menu-items"
      />

      <v-spacer />

      <v-btn
        v-if="breakpoint.mdAndUp && !isLoggedIn"
        :loading="isLogoutButtonLoading"
        :href="$fosGenerate('front.login')"
        color="success"
      >
        <v-icon class="mr-2">
          mdi-login
        </v-icon>
        Zaloguj się
      </v-btn>
      <v-btn
        v-if="breakpoint.mdAndUp && isLoggedIn"
        :href="$fosGenerate('front.logout')"
        :loading="isLogoutButtonLoading"
        color="accent"
      >
        <v-icon class="mr-2">
          mdi-logout
        </v-icon>
        Wyloguj się
      </v-btn>
    </v-app-bar>

    <v-navigation-drawer
      v-if="breakpoint.mdAndDown"
      v-model="drawer"
      fixed
      temporary
      height="100vh"
    >
      <mobile-nav-list :title="navTitle" />

      <template #append>
        <div
          class="pa-2"
        >
          <v-btn
            v-if="!isLoggedIn"
            :loading="isLogoutButtonLoading"
            :href="$fosGenerate('front.login')"
            block
            color="success"
          >
            <v-icon class="mr-2">
              mdi-login
            </v-icon>
            Zaloguj się
          </v-btn>
          <v-btn
            v-else
            block
            color="accent"
            :loading="isLogoutButtonLoading"
            :href="$fosGenerate('front.logout')"
          >
            <v-icon class="mr-2">
              mdi-logout
            </v-icon>
            Wyloguj się
          </v-btn>
        </div>
      </template>
    </v-navigation-drawer>
  </div>
</template>

<script>
import axios from 'axios';
import breakpoint from '../../mixins/breakpoint';

import MobileNavList from './MobileNavList';
import MenuItems from './MenuItems';

export default {
  name: 'AppNavbar',
  components: { MenuItems, MobileNavList },
  mixins: [breakpoint],
  props: {
    colorSchema: {
      type: String,
      default: 'patient',
      validator: (value) => ['patient', 'doctor', 'receptionist', 'management'].includes(value),
    },
  },
  data: () => ({
    drawer: false,
    navTitle: 'SDIWPIL',
    isLoggedIn: false,
    isLogoutButtonLoading: false,
  }),
  computed: {
    title() {
      return this.breakpoint.xsOnly && 'SDIWPIL' || 'System do internetowego wspomagania pacjenta i lekarza';
    },
    color() {
      switch (this.colorSchema) {
        case 'doctor':
          return 'secondary';
        case 'receptionist':
          return 'accent';
        case 'management':
          return 'success';
        default:
          return 'primary';
      }
    },
  },
  async mounted() {
    await this.setIsLoggedIn();
  },
  methods: {
    async setIsLoggedIn() {
      this.isLogoutButtonLoading = true;
      try {
        const { data } = await axios.post(this.$fosGenerate('front.vue.login_check'));
        this.isLoggedIn = data.isLoggedIn;
      } catch (e) {
        console.error(`Set is logged in action error: ${e}`);
      }
      this.isLogoutButtonLoading = false;
    },
  },
};
</script>

<style scoped lang="scss">
.navbar {
  &-btn {
    position: absolute;
  }
}

.menu-items {
  border-left: 1px solid #fff;
}
</style>
