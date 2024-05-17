<template>
  <div>
    <app-background v-if="isMobile" />
    <v-row
      row
      :class="[!isMobile && 'justify-center']"
    >
      <v-col md="4">
        <h1 class="text-h3 main-white mb-2">
          Witaj
        </h1>

        <p class="main-white mb-0">
          Przed tobą system wspomagający pacjenta i lekarza. Aplikacja ta została stworzona z myślą o darmowym
          rozwiązaniu usprawniającym rejestrację wizyt, korzystanie z dokumentacji pacjenta i szeregu innych funkcji.
        </p>
      </v-col>

      <v-col
        v-if="!isMobile"
        cols="auto"
      >
        <main-img
          height="200px"
          :is-oval="true"
        />
      </v-col>

      <v-col
        cols="12"
        md="auto"
        class="main-btn--col"
      >
        <v-btn
          class="main-btn"
          color="accent"
          :href="$fosGenerate('front.patient.register')"
        >
          Zacznij korzystać z systemu
        </v-btn>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import AppBackground from '../../../shared/components/AppBackground';
import MainImg from './MainImg';

export default {
  name: 'MainScreen',
  components: { AppBackground, MainImg },
  props: {
    isMobile: {
      type: Boolean,
      required: true,
    },
  },
};
</script>

<style scoped lang="scss">
@import '../../../styles/breakpoints';

.main {
  &-white {
    color: #fff;
  }

  &-btn {
    overflow-wrap: anywhere;

    &--col {
      @media (min-width: $md) {
        display: flex;
        justify-content: center;
        align-items: center;
      }
    }
  }
}
</style>
