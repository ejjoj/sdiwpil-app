<template>
  <v-container
    :style="{
      paddingTop: `${navbarHeight}px`,
      minHeight: `calc(100vh - ${footerHeight}px)`,
    }"
  >
    <main-screen
      :is-mobile="true"
      class="home-page--main"
    />

    <v-row class="home-page--row">
      <v-col
        sm="6"
        class="pb-0"
      >
        <main-img />
      </v-col>

      <v-col
        cols="12"
        class="pt-0"
      >
        <main-functions />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import MainScreen from './MainScreen';
import MainImg from './MainImg';
import MainFunctions from './MainFunctions';

export default {
  name: 'MobileContainer',
  components: { MainScreen, MainImg, MainFunctions },
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
@import '../../../styles/breakpoints';

.home-page {
  &--main {
    margin-bottom: 32px;

    @media (min-width: $sm) {
      margin-bottom: 64px;
    }
  }

  &--row {
    justify-content: center;
  }
}
</style>
