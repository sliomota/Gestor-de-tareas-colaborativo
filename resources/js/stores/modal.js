import { defineStore } from "pinia";
import { ref, reactive } from "vue";

export const useModalStore = defineStore(
    "Modal",
    () => {
        let open = ref(false);
        const close = () => {
            open.value = false;
        };
        const openModal = ()=>{
            open.value = true;
        }
        return {open,close,openModal};
    },
);
