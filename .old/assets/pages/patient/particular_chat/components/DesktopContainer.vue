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
        :header="routeScreenHeader"
        text="Poprzez poniższe okienko czatu możesz wysłać wiadomości w czasie rzeczywistym do swojego lekarza."
      />

      <v-row>
        <v-col cols="4">
          <chat-box />
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import RouteScreen from '../../../../shared/components/RouteScreen';
import chatRouteScreenHeaderMixin from '../../../../shared/mixins/chatRouteScreenHeaderMixin';
import ChatBox from '../../../../shared/components/Chat/ChatBox';

export default {
  name: 'DesktopContainer',
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
