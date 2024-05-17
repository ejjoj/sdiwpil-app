<template>
  <v-card
    flat
  >
    <v-card-text
      class="message mb-4"
      :class="[belongsToCurrentUser && 'message-current']"
    >
      {{ content }}
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name: 'ChatMessage',
  props: {
    belongsToCurrentUser: {
      type: Boolean,
      required: true,
    },
    content: {
      type: String,
      required: true,
    },
  },
};
</script>

<style scoped lang="scss">
@import 'assets/styles/colors';

.message {
  background-color: rgba($secondary, .1);
  border-radius: 12px;

  &-current {
    background-color: rgba($primary, .1);
  }
}
</style>
