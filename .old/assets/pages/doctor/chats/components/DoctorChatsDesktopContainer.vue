<template>
  <div>
    <v-container fluid>
      <app-background color-schema="doctor" />
    </v-container>

    <v-container
      :style="{
        paddingTop: `${navbarHeight}px`,
        minHeight: `calc(100vh - ${footerHeight}px)`,
      }"
    >
      <route-screen
        header="Czaty"
        text="Poniżej znajduje się lista dostępnych czatów z pacjentami, zapisanymi do Ciebie na wizytę."
      />

      <doctor-chats-list />
    </v-container>
  </div>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import RouteScreen from '../../../../shared/components/RouteScreen';
import DoctorChatsList from './DoctorChatsList';

export default {
  name: 'DoctorChatsDesktopContainer',
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

<style scoped lang="scss">
::v-deep {
  .background {
    z-index: 0;
  }
}

.container {
  position: relative;
}
</style>
