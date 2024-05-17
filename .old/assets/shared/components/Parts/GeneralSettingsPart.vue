<template>
  <v-card>
    <v-card-title>Ustawienia ogólne</v-card-title>

    <v-card-text>
      <v-text-field
        v-model="settings.email"
        type="email"
        label="Adres e-mail"
        :error-messages="getError($v.settings.email)"
        @touch="$v.settings.email.$touch()"
        @input="$v.settings.email.$touch()"
      />

      <v-text-field
        v-model="passwordFirst"
        type="password"
        label="Nowe hasło"
        :error-messages="getError($v.passwordFirst)"
        @touch="$v.passwordFirst.$touch()"
        @input="$v.passwordFirst.$touch()"
      />

      <v-text-field
        v-model="passwordSecond"
        type="password"
        label="Powtórz nowe hasło"
        :error-messages="getError($v.passwordSecond)"
        @touch="$v.passwordSecond.$touch()"
        @input="$v.passwordSecond.$touch()"
      />
    </v-card-text>
  </v-card>
</template>

<script>
import { get } from 'lodash';
import { validationMixin } from 'vuelidate';
import {
  email, maxLength, minLength, required, sameAs,
} from 'vuelidate/lib/validators';
import vuelidateErrors from '../../../mixins/vuelidateErrors';

export default {
  name: 'GeneralSettingsPart',
  mixins: [validationMixin, vuelidateErrors],
  data: () => ({
    settings: {
      email: '',
      password: {
        first: '',
        second: '',
      },
    },
  }),
  validations() {
    return {
      settings: {
        email: {
          required,
          email,
        },
      },
      passwordFirst: {
        minLength: minLength(6),
        maxLength: maxLength(255),
        sameAs: sameAs('passwordSecond'),
      },
      passwordSecond: {
        minLength: minLength(6),
        maxLength: maxLength(255),
        sameAs: sameAs('passwordFirst'),
      },
    };
  },
  computed: {
    passwordFirst: {
      get() {
        return this.settings.password.first;
      },
      set(value) {
        this.settings.password.first = value;
      },
    },
    passwordSecond: {
      get() {
        return this.settings.password.second;
      },
      set(value) {
        this.settings.password.second = value;
      },
    },
    isValid() {
      this.$v.$touch();

      return !this.$v.$invalid;
    },
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
    this.settings.email = get(window, 'state.email', '');
  },
};
</script>

<style scoped>

</style>
