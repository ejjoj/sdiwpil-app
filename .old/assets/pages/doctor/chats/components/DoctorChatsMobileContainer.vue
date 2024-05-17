<template>
  <v-container
    :style="{
      paddingTop: `${navbarHeight}px`,
      minHeight: `calc(100vh - ${footerHeight}px)`,
    }"
  >
    <app-background color-schema="doctor" />

    <route-screen
      header="Czaty"
      text="Poniżej znajduje się lista dostępnych czatów z pacjentami, zapisanymi do Ciebie na wizytę."
    />

    <doctor-chats-list />
  </v-container>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import RouteScreen from '../../../../shared/components/RouteScreen';
import DoctorChatsList from './DoctorChatsList';

export default {
  name: 'DoctorChatsMobileContainer',
  components: { DoctorChatsList, RouteScreen, AppBackground },
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
