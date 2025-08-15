import { defineStore } from "pinia";
import { ref, reactive } from "vue";

export const useProyectIdStore = defineStore(
    "ProyectId",
    () => {
        const id = ref();
        const idReset = () => {
            id.value = "";
        };
        return { id, idReset };
    },
    { persist: true }
);
