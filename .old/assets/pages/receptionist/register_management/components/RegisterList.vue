<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="items"
      no-data-text="Nie znaleziono podań o rejestrację w systemie"
      :options.sync="options"
      :loading="loading"
      :footer-props="{
        'items-per-page-text': 'Ilość wierszy na stronie',
        'items-per-page-options': rowsPerPageItems,
        'page-text': '{0}-{1} z {2}',
      }"
    >
      <template #top>
        <v-toolbar flat>
          <v-toolbar-title>Podania rejestracji</v-toolbar-title>
        </v-toolbar>
      </template>

      <template #item.actions="{ item }">
        <v-btn
          text
          color="success"
          @click="showAcceptanceModal = true"
        >
          <v-icon>
            mdi-check-circle
          </v-icon>
        </v-btn>

        <v-btn
          text
          color="error"
          @click="showRejectModal = true"
        >
          <v-icon>
            mdi-close-box
          </v-icon>
        </v-btn>
      </template>
    </v-data-table>

    <v-dialog
      v-model="showAcceptanceModal"
      max-width="456px"
      persistent
    >
      <v-card>
        <v-card-title>Czy wszystkie dane zostały zweryfikowane?</v-card-title>
        <v-card-actions>
          <v-btn
            text
            color="warning"
            @click="showAcceptanceModal = false"
          >
            Powrót
          </v-btn>

          <v-spacer />

          <v-btn
            color="primary"
            @click="showAcceptanceModal = false"
          >
            Potwierdź
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="showRejectModal"
      max-width="456px"
      persistent
    >
      <v-card>
        <v-card-title>Czy jesteś pewien?</v-card-title>
        <v-card-actions>
          <v-btn
            text
            color="warning"
            @click="showRejectModal = false"
          >
            Powrót
          </v-btn>

          <v-spacer />

          <v-btn
            color="primary"
            @click="showRejectModal = false"
          >
            Potwierdź
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  name: 'RegisterList',
  data: () => ({
    headers: [
      {
        text: 'Adres e-mail',
        sortable: false,
        value: 'email',
      },
      {
        text: 'Imię',
        sortable: false,
        value: 'firstName',
      },
      {
        text: 'Nazwisko',
        sortable: false,
        value: 'lastName',
      },
      {
        text: 'Numer PESEL',
        sortable: false,
        value: 'pesel',
      },
      {
        text: 'Akcje',
        sortable: false,
        value: 'actions',
      },
    ],
    items: [
      {
        email: 'jan@kowalski.com',
        firstName: 'Jan',
        lastName: 'Kowalski',
        pesel: '12345678912',
      },
      {
        email: 'janina@kowalska.com',
        firstName: 'Janina',
        lastName: 'Kowalska',
        pesel: '12345678912',
      },
    ],
    loading: false,
    options: {
      itemsPerPage: 25,
      page: 1,
    },
    rowsPerPageItems: [25, 50, 100, 250],
    showAcceptanceModal: false,
    showRejectModal: false,
  }),
};
</script>

<style scoped>

</style>
