<template>
  <v-container
    :style="{
      paddingTop: `${navbarHeight}px`,
      minHeight: `calc(100vh - ${footerHeight}px)`,
    }"
  >
    <app-background />

    <route-screen
      header="Czaty"
      text="Poniżej znajduje się lista dostępnych czatów z lekarzami, u których odbyto wizytę."
    />

    <patient-chat-list />
  </v-container>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import RouteScreen from '../../../../shared/components/RouteScreen';
import PatientChatList from './PatientChatList';

export default {
  name: 'PatientChatMobileContainer',
  components: { PatientChatList, AppBackground, RouteScreen },
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
