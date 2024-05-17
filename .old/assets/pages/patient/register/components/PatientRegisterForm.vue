<template>
  <v-card
    :loading="loading"
    @keydown.enter.prevent="onSubmit"
  >
    <v-card-title>Zarejestruj się</v-card-title>
    <v-card-text>
      <v-form>
        <v-text-field
          v-model="value.firstName"
          label="Imię"
          required
          :error-messages="getError($v.value.firstName)"
          @touch="$v.value.firstName.$touch()"
          @input="$v.value.firstName.$touch()"
        />
        <v-text-field
          v-model="value.secondName"
          label="Drugie imię"
          :error-messages="getError($v.value.secondName)"
          @touch="$v.value.secondName.$touch()"
          @input="$v.value.secondName.$touch()"
        />
        <v-text-field
          v-model="value.lastName"
          label="Nazwisko"
          required
          :error-messages="getError($v.value.lastName)"
          @touch="$v.value.lastName.$touch()"
          @input="$v.value.lastName.$touch()"
        />
        <v-text-field
          v-model="value.pesel"
          label="Numer PESEL"
          type="number"
          required
          :error-messages="getError($v.value.pesel)"
          @touch="$v.value.pesel.$touch()"
          @input="$v.value.pesel.$touch()"
        />
        <v-text-field
          v-model="value.email"
          label="Adres e-mail"
          type="email"
          required
          :error-messages="getError($v.value.email)"
          @touch="$v.value.email.$touch()"
          @input="$v.value.email.$touch()"
        />
        <v-text-field
          v-model="passwordFirst"
          label="Hasło"
          type="password"
          required
          :error-messages="getError($v.passwordFirst)"
          @touch="$v.passwordFirst.$touch()"
          @input="$v.passwordFirst.$touch()"
        />
        <v-text-field
          v-model="passwordSecond"
          label="Powtórz hasło"
          type="password"
          required
          :error-messages="getError($v.passwordSecond)"
          @touch="$v.passwordSecond.$touch()"
          @input="$v.passwordSecond.$touch()"
        />
        <v-checkbox
          v-model="value.agreeTerms"
          label="Zaakceptuj warunki"
        />
      </v-form>
    </v-card-text>
    <v-card-actions>
      <v-btn
        block
        color="secondary"
        :disabled="loading"
        @click.prevent="onSubmit"
      >
        Zarejestruj się
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import axios from 'axios';
import { validationMixin } from 'vuelidate';
import {
  maxLength, minLength, required, email, sameAs,
} from 'vuelidate/lib/validators';
import { has } from 'lodash';
import PatientModel from '../models/PatientModel';

export default {
  name: 'PatientRegisterForm',
  mixins: [validationMixin],
  data: () => ({
    value: new PatientModel(),
    loading: false,
  }),
  validations() {
    return {
      value: {
        firstName: {
          required,
          minLength: minLength(3),
          maxLength: maxLength(50),
        },
        secondName: {
          minLength: minLength(3),
          maxLength: maxLength(50),
        },
        lastName: {
          required,
          minLength: minLength(3),
          maxLength: maxLength(75),
        },
        email: {
          required,
          email,
        },
        pesel: {
          required,
          minLength: minLength(11),
          maxLength: maxLength(11),
        },
      },
      passwordFirst: {
        required,
        minLength: minLength(6),
        maxLength: maxLength(255),
        sameAs: sameAs('passwordSecond'),
      },
      passwordSecond: {
        required,
        minLength: minLength(6),
        maxLength: maxLength(255),
        sameAs: sameAs('passwordFirst'),
      },
    };
  },
  computed: {
    passwordFirst: {
      get() {
        return this.value.password.first;
      },
      set(value) {
        this.value.password.first = value;
      },
    },
    passwordSecond: {
      get() {
        return this.value.password.second;
      },
      set(value) {
        this.value.password.second = value;
      },
    },
  },
  methods: {
    getError(vField) {
      const errors = [];
      if (!vField || (vField && !vField.$dirty)) {
        return errors;
      }
      if (has(vField, 'required') && !vField.required) {
        errors.push('To pole jest wymagane');
      }
      if (has(vField, 'minLength') && !vField.minLength) {
        errors.push(`Minimalna ilość znaków to: ${vField.$params.minLength.min}`);
      }
      if (has(vField, 'maxLength') && !vField.maxLength) {
        errors.push(`Maksymalna ilość znaków to: ${vField.$params.maxLength.max}`);
      }
      if (has(vField, 'email') && !vField.email) {
        errors.push('Nieprawidłowy adres e-mail');
      }
      if (has(vField, 'sameAs') && !vField.sameAs) {
        errors.push('Wprowadzone hasła muszą być takie same');
      }

      return errors;
    },
    async register() {
      this.loading = true;
      try {
        const { data } = await axios.post(this.$fosGenerate('front.patient.register.new'), { ...this.value });
        if (data && data.success) {
          this.handleRegisterSuccess(data);
        } else if (data && data.errors) {
          this.handleErrors(data.errors);
        } else {
          this.$snotify.error('Przepraszamy, coś poszło nie tak');
        }
      } catch (e) {
        this.handleAxiosError(e);
      }
      this.loading = false;
    },
    async onSubmit() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        this.$snotify.error('Formularz nie został poprawnie wypełniony');

        return;
      }

      await this.register();
    },
    handleRegisterSuccess({ message, route }) {
      const timeout = 1500;
      this.$snotify.success(message, { timeout });
      setTimeout(() => {
        window.location.href = route;
      }, timeout + 500);
    },
    handleErrors(errors) {
      errors.forEach((error) => this.$snotify.error(error.message));
    },
    handleAxiosError(error) {
      console.error(`Register error: ${error}`);
      this.$snotify.error('Przepraszamy, coś poszło nie tak');
    },
  },
};
</script>

<style scoped>

</style>
