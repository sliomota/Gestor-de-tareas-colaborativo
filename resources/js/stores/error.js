import { defineStore } from "pinia";
import { ref } from "vue";

export const useErrorMessageStore = defineStore("ErrorMessage", () => {
    const messages = ref([]);
    const deleteMessage = (idx) => {
        messages.value = messages.value.filter((c, i) => i !== idx);
    };
    const clearMessages = () => {
        messages.value = [];
    };
    return { messages, deleteMessage,clearMessages };
});
