<template>
  <v-container
    :style="{
      paddingTop: `${navbarHeight}px`,
      minHeight: `calc(100vh - ${footerHeight}px)`,
    }"
  >
    <app-background />

    <route-screen
      header="Zaloguj się do systemu"
      text="Wypełnij poniższy formularz i wyślij go, by zalogować się do swojego konta"
    />

    <login-form />

    <register-interlinking />
  </v-container>
</template>

<script>
import AppBackground from '../../../shared/components/AppBackground';
import RouteScreen from '../../../shared/components/RouteScreen';
import LoginForm from './LoginForm';
import RegisterInterlinking from '../../../shared/components/RegisterInterlinking';

export default {
  name: 'MobileContainer',
  components: {
    RegisterInterlinking, AppBackground, RouteScreen, LoginForm,
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
  overflow-x: hidden;
}
</style>
