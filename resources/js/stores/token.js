import { defineStore } from "pinia";
export const useTokenSotre = defineStore(
    "token",
    () => {
        const userToken = ref("");
        function tokenReset() {
            userToken.value = "";
        }
        const getToken = computed(() => userToken.value);
        return { userToken, tokenReset };
    },
    { persist: true, }
);
