import { defineStore } from "pinia";
import {ref,reactive} from "vue";
export const useTokenSotre = defineStore(
    "token",
    () => {
        const userToken = ref("");
        function tokenReset() {
            userToken.value = "";
        }
        return { userToken, tokenReset };
    },
    { persist: true, }
);
