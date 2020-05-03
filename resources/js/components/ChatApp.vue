<template>
  <div class="chat-app">
    <Conversation :contact="selectedContact" :messages="messages" @new="saveMsg" />
    <ContactList :contacts="contacts" @selected="startConversationWith" />
  </div>
</template>

<script>
import Conversation from "./Conversation";
import ContactList from "./ContactList";
export default {
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      selectedContact: null,
      messages: [],
      contacts: []
    };
  },
  mounted() {
    Echo.private(`messages.${this.user.id}`).listen("NewMessage", e => {
      this.handleIncoming(e.message);
    });
    axios.get("/contacts").then(response => {
      this.contacts = response.data;
    });
  },
  methods: {
    startConversationWith(contact) {
      this.changeUnreadCount(contact, true);
      axios.get(`/conversation/${contact.id}`).then(response => {
        this.messages = response.data;
        this.selectedContact = contact;
      });
    },

    saveMsg(message) {
      this.messages.push(message);
    },
    handleIncoming(message) {
      if (this.selectedContact && this.selectedContact.id == message.from) {
        this.saveMsg(message);
        return;
      }
      this.changeUnreadCount(message.from_contact, false);
    },
    changeUnreadCount(contact, reset) {
      this.contacts = this.contacts.map(single => {
        if (single.id !== contact.id) {
          return single;
        }
        if (reset) single.unread = 0;
        else single.unread += 1;
        return single;
      });
    }
  },
  components: { Conversation, ContactList }
};
</script>
<style lang="scss" scoped>
.chat-app {
  display: flex;
}
</style>
