<template>
  <v-row>
    <v-col>
      <strong>Poniedziałek:</strong>
      <v-text-field
        v-model="workingTime.monday.start"
        v-mask="'##:##'"
        label="Czas rozpoczęcia pracy"
      />
      <v-text-field
        v-model="workingTime.monday.end"
        v-mask="'##:##'"
        label="Czas zakończenia pracy"
      />
    </v-col>
    <v-col>
      <strong>Wtorek:</strong>
      <v-text-field
        v-model="workingTime.tuesday.start"
        v-mask="'##:##'"
        label="Czas rozpoczęcia pracy"
      />
      <v-text-field
        v-model="workingTime.tuesday.end"
        v-mask="'##:##'"
        label="Czas zakończenia pracy"
      />
    </v-col>
    <v-col>
      <strong>Środa:</strong>
      <v-text-field
        v-model="workingTime.wednesday.start"
        v-mask="'##:##'"
        label="Czas rozpoczęcia pracy"
      />
      <v-text-field
        v-model="workingTime.wednesday.end"
        v-mask="'##:##'"
        label="Czas zakończenia pracy"
      />
    </v-col>
    <v-col>
      <strong>Czwartek:</strong>
      <v-text-field
        v-model="workingTime.thursday.start"
        v-mask="'##:##'"
        label="Czas rozpoczęcia pracy"
      />
      <v-text-field
        v-model="workingTime.thursday.end"
        v-mask="'##:##'"
        label="Czas zakończenia pracy"
      />
    </v-col>
    <v-col>
      <strong>Piątek:</strong>
      <v-text-field
        v-model="workingTime.friday.start"
        v-mask="'##:##'"
        label="Czas rozpoczęcia pracy"
      />
      <v-text-field
        v-model="workingTime.friday.end"
        v-mask="'##:##'"
        label="Czas zakończenia pracy"
      />
    </v-col>
    <v-col>
      <strong>Urlop:</strong>
      <v-text-field
        v-model="workingTime.vacation.start"
        v-mask="'##:##'"
        label="Czas rozpoczęcia urlopu"
      />
      <v-text-field
        v-model="workingTime.vacation.end"
        v-mask="'##:##'"
        label="Czas zakończenia urlopu"
      />
    </v-col>
  </v-row>
</template>

<script>
import { get } from 'lodash';
import { validationMixin } from 'vuelidate';
import vuelidateErrors from '../../../../../mixins/vuelidateErrors';
import WorkingTimeModel from '../../models/WorkingTimeModel';

export default {
  name: 'WorkingTimePart',
  mixins: [validationMixin, vuelidateErrors],
  data: () => ({
    workingTime: {
      monday: {
        start: '',
        end: '',
      },
      tuesday: {
        start: '',
        end: '',
      },
      wednesday: {
        start: '',
        end: '',
      },
      thursday: {
        start: '',
        end: '',
      },
      friday: {
        start: '',
        end: '',
      },
      vacation: {
        start: '',
        end: '',
      },
    },
  }),
  watch: {
    workingTime: {
      deep: true,
      handler(newValue) {
        this.$emit('change', newValue);
      },
    },
  },
  mounted() {
    this.setWorkingTime();
  },
  methods: {
    setWorkingTime() {
      const stateWorkingTime = get(window, 'state.workingTime');
      this.workingTime = stateWorkingTime || new WorkingTimeModel();
    },
  },
};
</script>

<style scoped>

</style>
