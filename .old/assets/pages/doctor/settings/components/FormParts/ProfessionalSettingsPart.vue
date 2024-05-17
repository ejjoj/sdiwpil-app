<template>
  <v-card height="100%">
    <v-card-title>Ustawienia zawodowe</v-card-title>

    <v-card-text>
      <v-select
        v-model="settings.medicalSpecialty"
        :items="medicalSpecialtiesItems"
        label="Specjalizacja medyczna"
        :error-messages="getError($v.settings.medicalSpecialty)"
        @touch="$v.settings.medicalSpecialty.$touch()"
        @input="$v.settings.medicalSpecialty.$touch()"
      />

      <working-time-part
        ref="workingTime"
        @change="handleWorkingTimeChange"
      />
    </v-card-text>
  </v-card>
</template>

<script>
import { get } from 'lodash';
import { validationMixin } from 'vuelidate';
import { required } from 'vuelidate/lib/validators';
import vuelidateErrors from '../../../../../mixins/vuelidateErrors';
import WorkingTimePart from './WorkingTimePart';

export default {
  name: 'ProfessionalSettingsPart',
  components: { WorkingTimePart },
  mixins: [vuelidateErrors, validationMixin],
  data: () => ({
    settings: {
      medicalSpecialty: 0,
      workingTime: {},
    },
    medicalSpecialtiesItems: [],
  }),
  validations() {
    return {
      settings: {
        medicalSpecialty: { required },
      },
    };
  },
  watch: {
    settings: {
      deep: true,
      handler() {
        this.$emit('change', this.settings);
      },
    },
  },
  mounted() {
    this.settings.medicalSpecialty = get(window, 'state.medicalSpecialty', 0);
    this.medicalSpecialtiesItems = get(window, 'state.medicalSpecialties', []);
  },
  methods: {
    handleWorkingTimeChange(workingTime) {
      this.settings.workingTime = workingTime;
    },
  },
};
</script>

<style scoped>
</style>
