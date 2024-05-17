<template>
  <v-data-table
    :headers="headers"
    :items="documents"
    no-data-text="Nie utworzono dokumentów"
    :options.sync="options"
    :footer-props="{
      'items-per-page-text': 'Ilość wierszy na stronie',
      'items-per-page-options': rowsPerPageItems,
      'page-text': '{0}-{1} z {2}',
    }"
    :loading="loading"
  >
    <template #top>
      <v-toolbar flat>
        <v-toolbar-title>Lista dokumentów</v-toolbar-title>
      </v-toolbar>
    </template>

    <template #item.actions="{ item }">
      <v-btn
        text
        color="primary"
        @click="showDocument(item)"
      >
        <v-icon>mdi-file-find</v-icon>
      </v-btn>
    </template>
  </v-data-table>
</template>

<script>
import { get, has } from 'lodash';
import axios from 'axios';

export default {
  name: 'DocumentsList',
  data: () => ({
    documents: [],
    options: {
      itemsPerPage: 25,
      page: 1,
    },
    rowsPerPageItems: [25, 50, 100, 250],
    loading: false,
  }),
  computed: {
    headers() {
      const headers = [];
      this
        .applyDocumentTypeHeader(headers)
        .applyDoctorHeader(headers)
        .applyCreatedAtHeader(headers)
        .applyUpdatedAtHeader(headers)
        .applyActionHeader(headers);

      return headers;
    },
  },
  watch: {
    options: {
      deep: true,
      async handler(newValue) {
        const rowsPerPageKey = 'itemsPerPage';
        const pageKey = 'page';
        if (!has(newValue, rowsPerPageKey) || !has(newValue, pageKey)) {
          return;
        }

        await this.updatePagination({
          page: get(newValue, pageKey),
          rows_per_page: get(newValue, rowsPerPageKey),
        });
      },
    },
  },
  mounted() {
    this.setDocuments(get(window, 'state.documents', []));
  },
  methods: {
    async updatePagination(pagination) {
      if (this.loading) {
        return;
      }

      this.loading = true;
      try {
        const { data } = await axios.get(this.$fosGenerate('front.patient.documents.list', pagination));
        if (data.success) {
          this.documents = data.list;
        } else {
          data.errors.forEach((error) => this.$snotify.error(error.message));
        }
      } catch (e) {
        console.error(`Pagination update error: ${e}`);
      }
      this.loading = false;
    },
    showDocument({ hash }) {
      window.open(this.$fosGenerate('front.document.generate', { hash }), '_blank');
    },
    setDocuments(documents) {
      this.documents = documents;
    },
    applyDocumentTypeHeader(headers) {
      headers.push({
        text: 'Typ dokumentu',
        sortable: false,
        value: 'type',
      });

      return this;
    },
    applyDoctorHeader(headers) {
      headers.push({
        text: 'Lekarz',
        sortable: false,
        value: 'doctor',
      });

      return this;
    },
    applyCreatedAtHeader(headers) {
      headers.push({
        text: 'Data utworzenia dokumentu',
        sortable: false,
        value: 'createdAt',
      });

      return this;
    },
    applyUpdatedAtHeader(headers) {
      headers.push({
        text: 'Data edytowania dokumentu',
        sortable: false,
        value: 'updatedAt',
      });

      return this;
    },
    applyActionHeader(headers) {
      headers.push({
        text: 'Akcje',
        sortable: false,
        value: 'actions',
      });

      return this;
    },
  },
};
</script>

<style scoped>

</style>
