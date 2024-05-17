<template>
  <div>
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

          <v-spacer />

          <v-dialog
            v-model="isNewDialogOpen"
            persistent
            max-width="500px"
            @keydown.esc="isNewDialogOpen = false"
          >
            <template #activator="{ on, attrs }">
              <v-btn
                color="secondary"
                class="mb-2"
                v-bind="attrs"
                v-on="on"
              >
                Stwórz dokument
              </v-btn>
            </template>

            <new-document-form
              :options="options"
              @closeNewDocumentDialog="isNewDialogOpen = false"
              @documentsChanged="setDocuments"
            />
          </v-dialog>
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

        <v-btn
          text
          color="warning"
          @click="editDocument(item)"
        >
          <v-icon>mdi-file-edit</v-icon>
        </v-btn>
      </template>
    </v-data-table>

    <v-dialog
      v-model="isEditDialogOpen"
      persistent
      max-width="500px"
    >
      <edit-document-form
        :document="editItem"
        :options="options"
        @editDialogClose="isEditDialogOpen = false"
        @documentsChanged="setDocuments"
      />
    </v-dialog>
  </div>
</template>

<script>
import axios from 'axios';
import { get, has } from 'lodash';
import NewDocumentForm from './Forms/NewDocumentForm';
import EditDocumentForm from './Forms/EditDocumentForm';

export default {
  name: 'DoctorDocumentsList',
  components: { EditDocumentForm, NewDocumentForm },
  data: () => ({
    headers: [
      {
        text: 'Typ dokumentu',
        sortable: false,
        value: 'type',
      },
      {
        text: 'Pacjent',
        sortable: false,
        value: 'patient',
      },
      {
        text: 'Data utworzenia dokumentu',
        sortable: false,
        value: 'createdAt',
      },
      {
        text: 'Data edytowania dokumentu',
        sortable: false,
        value: 'updatedAt',
      },
      {
        text: 'Akcje',
        sortable: false,
        value: 'actions',
      },
    ],
    options: {
      itemsPerPage: 25,
      page: 1,
    },
    rowsPerPageItems: [25, 50, 100, 250],
    isNewDialogOpen: false,
    isEditDialogOpen: false,
    editItem: {},
    loading: false,
    documents: [],
  }),
  watch: {
    options: {
      deep: true,
      async handler(newValue) {
        const rowsPerPageKey = 'itemsPerPage';
        const pageKey = 'page';
        if (has(newValue, rowsPerPageKey) && has(newValue, pageKey)) {
          await this.updatePagination({
            page: get(newValue, pageKey),
            rows_per_page: get(newValue, rowsPerPageKey),
          });
        }
      },
    },
  },
  mounted() {
    this.setDocuments(get(window, 'state.documents', []));
  },
  methods: {
    showDocument({ hash }) {
      window.open(this.$fosGenerate('front.document.generate', { hash }), '_blank');
    },
    editDocument(document) {
      this.editItem = document;
      this.isEditDialogOpen = true;
    },
    async updatePagination(pagination) {
      if (this.loading) {
        return;
      }

      this.loading = true;
      try {
        const { data } = await axios.get(this.$fosGenerate('front.doctor.documents.list', pagination));
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
    setDocuments(documents) {
      this.documents = documents;
    },
  },
};
</script>

<style scoped>

</style>
