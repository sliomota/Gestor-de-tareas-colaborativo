import { defineStore } from "pinia";
import { ref } from "vue";
export const usePendingToken = defineStore(
    "pendingToken",
    () => {
        const token = ref("");
        const resetToken = () => {
            token.value = "";
        };
        return { token, resetToken };
    },
    { persist: true }
);
