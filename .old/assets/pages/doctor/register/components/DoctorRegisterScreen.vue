<template>
  <v-row
    row
    justify-md="center"
  >
    <v-col md="4">
      <h1 class="text-h4 register-white mb-2">
        Stwórz konto lekarza
      </h1>

      <p class="register-white">
        Wypełnij poniższy formularz i skorzystaj z możliwości jakie oferuje system SDIWPIL.
      </p>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'DoctorRegisterScreen',
};
</script>

<style scoped lang="scss">
.register {
  &-white {
    color: #fff;
  }
}
</style>
