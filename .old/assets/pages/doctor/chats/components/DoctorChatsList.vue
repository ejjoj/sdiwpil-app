<template>
  <v-data-table
    :headers="headers"
    :items="conversations"
    no-data-text="Dla twojego konta nie zostały jeszcze utworzone żadne czaty"
    :options.sync="options"
    :footer-props="{
      'items-per-page-text': 'Ilość wierszy na stronie',
      'items-per-page-options': rowsPerPageItems,
      'page-text': '{0}-{1} z {2}',
    }"
    @click:row="goToParticularChat"
  >
    <template #top>
      <v-toolbar flat>
        <v-toolbar-title>Dostępne czaty</v-toolbar-title>
      </v-toolbar>
    </template>

    <template #item.actions="{ item }">
      <v-btn
        text
        color="primary"
        @click="goToParticularChat(item)"
      >
        <v-icon>mdi-forum</v-icon>
      </v-btn>
    </template>
  </v-data-table>
</template>

<script>

import { mapState } from 'vuex';
import { DOCTOR_CHATS } from '../../../../store/module-namespaces';
import { CONVERSATIONS } from '../../../../store/module-state-properties';

export default {
  name: 'DoctorChatsList',
  data: () => ({
    headers: [
      {
        text: 'Pacjent',
        sortable: false,
        value: 'patient',
      },
      {
        text: 'Czas ostatniej wiadomości',
        sortable: false,
        value: 'lastMessageDate',
      },
      {
        text: 'Data utworzenia konwersacji',
        sortable: false,
        value: 'createdAt',
      },
      {
        text: 'Akcje',
        sortable: false,
        value: 'actions',
      },
    ],
    chats: [],
    options: {
      itemsPerPage: 25,
      page: 1,
    },
    rowsPerPageItems: [25, 50, 100, 250],
  }),
  computed: {
    ...mapState(DOCTOR_CHATS, {
      conversations: CONVERSATIONS,
    }),
  },
  methods: {
    goToParticularChat(chat) {
      window.location.href = this.$fosGenerate('front.doctor.chat.particular', { channelId: chat.channelId });
    },
  },
};
</script>

<style scoped>

</style>
