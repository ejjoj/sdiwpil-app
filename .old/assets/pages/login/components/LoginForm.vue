<template>
  <v-card
    :loading="loading"
    max-width="350px"
    @keydown.enter.prevent="login"
  >
    <v-card-text>
      <v-form>
        <v-text-field
          v-model="username"
          label="Wpisz e-mail"
          type="email"
        />

        <v-text-field
          v-model="password"
          label="Wpisz hasło"
          type="password"
        />
      </v-form>
    </v-card-text>

    <v-card-actions>
      <v-btn
        color="primary"
        :disabled="loading"
        @click.prevent="login"
      >
        Zaloguj się
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import axios from 'axios';

export default {
  name: 'LoginForm',
  data: () => ({
    username: '',
    password: '',
    loading: false,
  }),
  methods: {
    handleSuccessfulLogin(response) {
      const timeout = 1500;
      this.$snotify.success(response.message, { timeout });
      setTimeout(() => {
        window.location.href = response.route;
      }, timeout + 500);
    },
    handleLoginError(error) {
      this.$snotify.error(error);
    },
    handleAxiosError(error) {
      this.$snotify.error('Przepraszamy. Coś poszło nie tak');
      console.error(`Login error: ${error}`);
    },
    async login() {
      this.loading = true;
      const url = this.$fosGenerate('front.login.check');
      const { username, password } = this;
      try {
        const { data } = await axios.post(url, { username, password });
        if (data.success) {
          this.handleSuccessfulLogin(data);
        } else {
          this.handleLoginError(data.message);
        }
      } catch (e) {
        this.handleAxiosError(e);
      }
      this.loading = false;
    },
  },
};
</script>

<style scoped>

</style>
