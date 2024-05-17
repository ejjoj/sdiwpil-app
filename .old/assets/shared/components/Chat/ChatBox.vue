<template>
  <v-card
    class="chat-box"
    elevation="3"
    outlined
  >
    <v-card-text
      ref="messagesBox"
      class="chat-box--text"
    >
      <chat-message
        v-for="({content, sender}, i) in messages"
        :key="i"
        :belongs-to-current-user="doesBelongToCurrentUser(sender)"
        :content="content"
        class="chat-box--message"
        :class="[doesBelongToCurrentUser(sender) && 'chat-box--message-current']"
      />
    </v-card-text>

    <v-card-actions>
      <v-row>
        <v-col>
          <v-textarea
            v-model="messageContent"
            label="Wpisz treść wiadomości"
            auto-grow
            clearable
            rows="1"
            @keydown.enter.prevent="sendMessage"
          />
        </v-col>

        <v-col
          class="chat-box--send"
          cols="auto"
        >
          <v-btn
            color="primary"
            @click.prevent="sendMessage"
          >
            Wyślij
          </v-btn>
        </v-col>
      </v-row>
    </v-card-actions>
  </v-card>
</template>

<script>
import { get } from 'lodash';
import { io } from 'socket.io-client';
import ChatMessage from './ChatMessage';

const socket = io(`${window.location.protocol}//${window.location.host}:3000/`);

export default {
  name: 'ChatBox',
  components: { ChatMessage },
  data: () => ({
    conversation: 0,
    messages: [],
    userId: 0,
    messageContent: '',
  }),
  mounted() {
    this.setUserId();
    this.setMessages();
    this.setConversation();
    socket.on('message', this.setMessageFromWss);
    this.$nextTick(() => this.scrollMessagesBoxToBottom());
  },
  methods: {
    setUserId() {
      this.userId = get(window, 'state.userId', 0);
    },
    setMessages() {
      const messages = get(window, 'state.messages', []);
      if (messages.length) {
        this.messages = messages;
      }
    },
    setConversation() {
      this.conversation = get(window, 'state.conversation', 0);
    },
    doesBelongToCurrentUser(sender) {
      return this.userId === sender;
    },
    sendMessage() {
      if (!this.messageContent.length) {
        return;
      }

      const message = {
        conversation: this.conversation,
        content: this.messageContent,
        sender: this.userId,
      };

      socket.emit('message', message);
      this.messageContent = '';
    },
    setMessageFromWss(message) {
      if (this.conversation === message.conversation) {
        this.messages.push(message);
        this.scrollMessagesBoxToBottom();
      }
    },
    scrollMessagesBoxToBottom() {
      const { messagesBox } = this.$refs;
      if (!messagesBox) {
        return;
      }

      messagesBox.scroll({ top: messagesBox.scrollHeight });
    },
  },
};
</script>

<style scoped lang="scss">
@import 'assets/styles/breakpoints';

.chat {
  &-box {
    min-height: 100vh;
    display: flex;
    flex-direction: column;

    @media (min-width: $sm) {
      min-height: 500px;
    }

    &--text {
      flex-grow: 1;
      max-height: 400px;
      overflow-y: auto;
    }

    &--message {
      margin-left: 51%;

      &-current {
        margin-left: 0;
        margin-right: 51%;
      }
    }

    &--send {
      display: flex;
      align-items: center;
    }
  }
}
</style>
