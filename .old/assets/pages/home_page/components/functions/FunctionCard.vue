<template>
  <v-card
    class="mx-auto functions-card"
    max-width="374"
  >
    <v-img
      height="250"
      :src="image"
    />

    <v-card-title>{{ title }}</v-card-title>

    <v-card-text>
      <v-row
        align="center"
        class="mx-0"
      >
        <div>{{ description }}</div>
      </v-row>
    </v-card-text>
    <v-card-actions>
      <v-btn
        color="secondary"
        block
        :href="url"
      >
        Sprawdź
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  name: 'FunctionCard',
  props: {
    image: {
      type: String,
      required: true,
    },
    title: {
      type: String,
      required: true,
    },
    description: {
      type: String,
      required: true,
    },
    url: {
      type: String,
      required: true,
    },
  },
};
</script>

<style scoped lang="scss">
.functions {
  &-card {
     border-radius: 8px;
   }
}

::v-deep .v-card__actions {
  padding: 16px;
}
</style>
