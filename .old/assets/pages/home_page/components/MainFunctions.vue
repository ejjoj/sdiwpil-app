<template>
  <div>
    <functions-carousel
      v-if="breakpoint.mdAndDown"
      :functions="functions"
    />
    <functions-block
      v-else
      :functions="functions"
    />
  </div>
</template>

<script>
import breakpoint from '../../../mixins/breakpoint';

import FunctionsCarousel from './functions/FunctionsCarousel';
import FunctionsBlock from './functions/FunctionsBlock';

export default {
  name: 'MainFunctions',
  components: { FunctionsCarousel, FunctionsBlock },
  mixins: [breakpoint],
  computed: {
    functions() {
      return [
        {
          title: 'Konto pacjenta',
          description: 'Strefa przeznaczona stworzona z myślą o udogodnieniach dla każdego pacjenta.',
          image: '/images/functions/patient-account.png',
          url: this.$fosGenerate('front.patient.register'),
        },
        {
          title: 'Konto lekarza',
          description: 'Podsystem kompleksowo realizujący potrzeby lekarzy.',
          image: '/images/functions/doctor-account.png',
          url: this.$fosGenerate('front.doctor.register'),
        },
        {
          title: 'Konto recepcjonisty',
          description: 'Specjalnie wydelegowana strefa dla pracownika recepcji, by wspomagać mikro zarządzanie.',
          image: '/images/functions/receptionist-account.png',
          url: '',
        },
        {
          title: 'Konto administracji',
          description: 'Część systemu zbudowana z myślą o szerokim przedstawieniu statystyk i możliwości makro zarządzania.',
          image: '/images/functions/management-account.png',
          url: '',
        },
      ];
    },
  },
};
</script>

<style scoped>

</style>
