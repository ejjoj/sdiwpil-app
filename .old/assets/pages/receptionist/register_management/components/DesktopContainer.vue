<template>
  <div>
    <v-container fluid>
      <app-background color-schema="receptionist" />

      <v-container
        :style="{
          paddingTop: `${navbarHeight}px`,
          minHeight: `calc(100vh - ${footerHeight}px)`,
        }"
      >
        <route-screen
          header="Zarządzanie rejestracją użytkowników"
          text="Na poniższej liście znajdują się oczekujące prośby akceptacji o rejestrację. Zweryfikuj dane i zaakceptuj lub odrzuć dane podanie."
        />

        <register-list />
      </v-container>
    </v-container>
  </div>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import RouteScreen from '../../../../shared/components/RouteScreen';
import RegisterList from './RegisterList';

export default {
  name: 'DesktopContainer',
  components: { AppBackground, RouteScreen, RegisterList },
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

</style>
