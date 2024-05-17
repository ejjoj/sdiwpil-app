<template>
  <v-container
    :style="{
      paddingTop: `${navbarHeight}px`,
      minHeight: `calc(100vh - ${footerHeight}px)`,
    }"
  >
    <app-background color-schema="doctor" />

    <route-screen
      :header="routeScreenHeader"
      text="Poprzez poniższe okienko czatu możesz wysyłać wiadomości w czasie rzeczywistym do pacjenta."
    />

    <chat-box />
  </v-container>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import RouteScreen from '../../../../shared/components/RouteScreen';
import chatRouteScreenHeaderMixin from '../../../../shared/mixins/chatRouteScreenHeaderMixin';
import ChatBox from '../../../../shared/components/Chat/ChatBox';

export default {
  name: 'MobileContainer',
  components: { ChatBox, RouteScreen, AppBackground },
  mixins: [chatRouteScreenHeaderMixin],
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
