<template>
  <v-card>
    <v-card-title>Wypełnij formularz kreacji dokumentu</v-card-title>

    <v-card-text>
      <v-select
        v-model="value.type"
        :items="types"
        :disabled="loading"
        label="Wybierz typ dokumentu"
        :error-messages="getError($v.value.type)"
        @touch="$v.value.type.$touch()"
        @input="$v.value.type.$touch()"
      />

      <v-select
        v-model="value.patient"
        :items="patients"
        :disabled="loading"
        label="Wybierz pacjenta"
        :error-messages="getError($v.value.patient)"
        @touch="$v.value.patient.$touch()"
        @input="$v.value.patient.$touch()"
      />

      <v-text-field
        v-if="isPrescription"
        v-model="value.medicamentName"
        :disabled="loading"
        label="Wpisz nazwę leku"
        :error-messages="getError($v.value.medicamentName)"
        @touch="$v.value.medicamentName.$touch()"
        @input="$v.value.medicamentName.$touch()"
      />

      <v-text-field
        v-if="isPrescription"
        v-model="value.medicamentDescription"
        :disabled="loading"
        label="Wpisz opis leku"
        :error-messages="getError($v.value.medicamentDescription)"
        @touch="$v.value.medicamentDescription.$touch()"
        @input="$v.value.medicamentDescription.$touch()"
      />

      <v-text-field
        v-if="isPrescription"
        v-model="value.medicamentUsageDescription"
        :disabled="loading"
        label="Wpisz opis użycia leku"
        :error-messages="getError($v.value.medicamentUsageDescription)"
        @touch="$v.value.medicamentUsageDescription.$touch()"
        @input="$v.value.medicamentUsageDescription.$touch()"
      />

      <v-text-field
        v-if="isPrescription"
        v-model="value.medicamentRemission"
        :disabled="loading"
        label="Wpisz stopień odpłatności (w procentach) przepisanego leku"
        :error-messages="getError($v.value.medicamentRemission)"
        @touch="$v.value.medicamentRemission.$touch()"
        @input="$v.value.medicamentRemission.$touch()"
      />
    </v-card-text>

    <v-card-actions>
      <v-btn
        block
        color="success"
        :disabled="loading"
        @click.prevent="createDocument"
      >
        Stwórz dokument
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import axios from 'axios';
import { assignIn, get } from 'lodash';
import { validationMixin } from 'vuelidate';
import { maxLength, required } from 'vuelidate/lib/validators';
import vuelidateErrors from '../../../../../mixins/vuelidateErrors';
import NewDocumentModel from '../../models/NewDocumentModel';

export default {
  name: 'NewDocumentForm',
  mixins: [validationMixin, vuelidateErrors],
  props: {
    options: {
      type: Object,
      required: true,
    },
  },
  data: () => ({
    value: new NewDocumentModel(),
    loading: false,
  }),
  validations() {
    let result = {
      type: { required },
      patient: { required },
    };

    if (this.isPrescription) {
      result = assignIn(result, {
        medicamentName: { required },
        medicamentDescription: { required },
        medicamentUsageDescription: { required },
        medicamentRemission: { required, maxLength: maxLength(4) },
      });
    }

    return { value: result };
  },
  computed: {
    types() {
      return get(window, 'state.documentTypes', []);
    },
    patients() {
      return get(window, 'state.patients', []);
    },
    isPrescription() {
      return this.value.type === 'prescription';
    },
  },
  methods: {
    getDoctorFromState() {
      return get(window, 'state.doctor', 0);
    },
    async sendCreateDocumentRequest() {
      this.loading = true;
      try {
        this.value.doctor = this.getDoctorFromState();
        const { data } = await axios.post(this.$fosGenerate('front.doctor.documents.new', this.options), { ...this.value });
        if (data.success) {
          this.$snotify.success('Pomyślnie utworzono dokument!');
          this.$emit('closeNewDocumentDialog');
          this.$emit('documentsChanged', data.list);
        } else {
          data.errors.forEach((error) => this.$snotify.error(error.message));
        }
      } catch (e) {
        this.$snotify.error('Coś poszło nie tak, przepraszamy...');
        console.error(`Send create document request error: ${e}`);
      }
      this.loading = false;
    },
    async createDocument() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        this.$snotify.error('Formularz nie został wypełniony poprawnie.');

        return;
      }

      await this.sendCreateDocumentRequest();
    },
  },
};
</script>

<style scoped>

</style>
