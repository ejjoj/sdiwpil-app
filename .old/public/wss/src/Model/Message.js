class Message {
  constructor(
      {
        content = '',
        conversation = 0,
        sender = 0,
      } = {},
    ) {
    this.content = content;
    this.conversation = conversation;
    this.sender = sender;
  }
}

module.exports = Message;
