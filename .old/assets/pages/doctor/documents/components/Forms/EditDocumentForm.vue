<template>
  <v-card>
    <v-card-title>Wypełnij formularz edycji dokumentu</v-card-title>

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
        color="warning"
        :disabled="loading"
        @click.prevent="$emit('editDialogClose')"
      >
        Anuluj
      </v-btn>

      <v-spacer />

      <v-btn
        color="success"
        :disabled="loading"
        @click.prevent="editDocument"
      >
        Zapisz
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import axios from 'axios';
import { assignIn, get, set } from 'lodash';
import { validationMixin } from 'vuelidate';
import { maxLength, required } from 'vuelidate/lib/validators';
import vuelidateErrors from '../../../../../mixins/vuelidateErrors';
import EditDocumentModel from '../../models/EditDocumentModel';

export default {
  name: 'EditDocumentForm',
  mixins: [validationMixin, vuelidateErrors],
  props: {
    document: {
      type: Object,
      // eslint-disable-next-line vue/require-valid-default-prop
      default: {},
    },
    options: {
      type: Object,
      required: true,
    },
  },
  data: () => ({
    value: new EditDocumentModel(),
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
  watch: {
    document: {
      deep: true,
      handler() {
        this.setValue();
      },
    },
  },
  mounted() {
    this.setValue();
  },
  methods: {
    async sendEditDocumentRequest() {
      this.loading = true;
      try {
        const { data } = await axios.post(this.$fosGenerate('front.document.edit', this.options), { ...this.value });
        if (data.success) {
          this.$snotify.success('Pomyślnie edytowano dokument!');
          this.$emit('editDialogClose');
          this.$emit('documentsChanged', data.list);
        } else {
          data.errors.forEach((error) => this.$snotify.error(error.message));
        }
      } catch (e) {
        this.$snotify.error('Coś poszło nie tak, przepraszamy...');
        console.error(`Send edit document request error: ${e}`);
      }
      this.loading = false;
    },
    async editDocument() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        this.$snotify.error('Formularz nie został wypełniony poprawnie.');

        return;
      }

      await this.sendEditDocumentRequest();
    },
    setType() {
      const typeObject = this.types.find((type) => type.text.toLowerCase() === this.document.type);
      this.value.type = typeObject.value;
    },
    setPatient() {
      const patientObject = this.patients.find((patient) => patient.text === this.document.patient);
      this.value.patient = patientObject.value;
    },
    setValue() {
      this.value.document = this.document.id;
      this.setType();
      this.setPatient();
      const mappings = {
        medicamentDescription: 'prescription.medicamentDescription',
        medicamentName: 'prescription.medicamentName',
        medicamentRemission: 'prescription.medicamentRemission',
        medicamentUsageDescription: 'prescription.medicamentUsageDescription',
      };

      // eslint-disable-next-line no-restricted-syntax
      for (const [valuePath, documentPath] of Object.entries(mappings)) {
        set(this.value, valuePath, get(this.document, documentPath));
      }
    },
  },
};
</script>

<style scoped>

</style>
