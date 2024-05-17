<template>
  <v-form>
    <v-select
      v-model="search.medicalSpecialty"
      :items="medicalSpecialtiesItems"
      label="Wybierz specjalizację"
      clearable
    />
    <v-select
      v-model="search.city"
      :items="cities"
      label="Wybierz miasto"
      clearable
    />
    <v-text-field
      v-model="search.lastName"
      label="Wpisz nazwisko"
      clearable
    />
  </v-form>
</template>

<script>
import { get } from 'lodash';
import AppointmentSearchModel from '../models/AppointmentSearchModel';

export default {
  name: 'PatientAppointmentForm',
  data: () => ({
    medicalSpecialtiesItems: [],
    cities: ['Kraków', 'Warszawa', 'Poznań', 'Wrocław', 'Katowice', 'Gdańsk', 'Rzeszów'],
    search: new AppointmentSearchModel(),
  }),
  watch: {
    search: {
      deep: true,
      handler() {
        this.$emit('change', this.search);
      },
    },
  },
  mounted() {
    this.medicalSpecialtiesItems = get(window, 'state.medical_specialties', []);
  },
};
</script>

<style scoped>

</style>
