<template>
  <div>
    <v-container fluid>
      <app-background />
    </v-container>

    <v-container
      class="main-container"
      :style="{
        paddingTop: `${navbarHeight}px`,
        minHeight: `calc(100vh - ${footerHeight}px)`,
      }"
    >
      <route-screen
        header="Dokumenty"
        text="Poniżej znajduje się lista wygenerowanych dokumentów, przypisanych do twojego konta."
      />

      <documents-list />
    </v-container>
  </div>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import RouteScreen from '../../../../shared/components/RouteScreen';
import DocumentsList from './DocumentsList';

export default {
  name: 'DesktopContainer',
  components: { DocumentsList, AppBackground, RouteScreen },
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

.main-container {
  position: relative;
}
</style>
