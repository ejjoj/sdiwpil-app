const express = require('express');
const socket = require('socket.io');
const axios = require('axios');
const Message = require('./src/Model/Message');
const ResponseDataModel = require('./src/Model/ResponseDataModel');
const getMessageDate = require('./src/Function/getMessageDate');

process.env.TZ = 'Europe/Warsaw';

// App setup
const PORT = 3000;
const app = express();
const server = app.listen(PORT, () => {
  console.log(`Listening on port ${PORT}`);
  console.log(`http://localhost:${PORT}`);
});

// Socket setup
const io = socket(server, {
  cors: {
    origin: 'http://www.sdiwpil.online',
    methods: ["GET", "POST"]
  }
});

let messages = [];
const saveMessages = async () => {
  if (messages.length === 0) {
    return;
  }

  try {
    const { data } = await axios.post('http://www.sdiwpil.online/message/new', { messages });
    const responseData = new ResponseDataModel(data);
    if (responseData.success) {
      messages = [];
    } else {
      responseData.errors.forEach((error) => console.error(error.message))
    }
  } catch (e) {
    console.error(`Save message error: ${e}`);
  }
}

const processMessage = async data => {
  const message = new Message(data);
  io.emit('message', message);
  messages.push(message);
  if (messages.length < 5) {
    return;
  }

  await saveMessages();
};

io.on('connection', socket => {
  socket.on('message', processMessage);
  socket.on('disconnecting', async reason => {
    await saveMessages();
  })
});

io.on('disconnect', async socket => {
  await saveMessages();
});

const interval = 5 /* minutes */ * 60 /* seconds */ * 1000 /* milliseconds */
setInterval(async () => {
  console.log('---');
  console.log('Synchronizacja wiadomości:');
  console.log('Ilość wiadomości w pamięci: ', messages.length);
  console.log('Interwał: 5 min');
  console.log('Czas: ', getMessageDate());
  await saveMessages();
}, interval);
