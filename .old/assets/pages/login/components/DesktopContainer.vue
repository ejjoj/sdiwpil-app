<template>
  <div>
    <v-container fluid>
      <app-background />
    </v-container>

    <v-container
      :style="{
        paddingTop: `${navbarHeight}px`,
        minHeight: `calc(100vh - ${footerHeight}px)`,
      }"
    >
      <route-screen
        class="mb-4"
        header="Zaloguj się do systemu"
        text="Wypełnij poniższy formularz i wyślij go, by zalogować się do swojego konta"
      />

      <login-form />

      <register-interlinking />
    </v-container>
  </div>
</template>

<script>
import AppBackground from '../../../shared/components/AppBackground';
import RouteScreen from '../../../shared/components/RouteScreen';
import LoginForm from './LoginForm';
import RegisterInterlinking from '../../../shared/components/RegisterInterlinking';

export default {
  name: 'DesktopContainer',
  components: {
    RegisterInterlinking, LoginForm, RouteScreen, AppBackground,
  },
  props: {
    navbarHeight: {
      type: Number,
      required: true,
    },
    footerHeight: {
      type: Number,
      required: true,
    },
  },
};
</script>

<style scoped>
.container {
  position: relative;
  z-index: 2;
}
</style>
