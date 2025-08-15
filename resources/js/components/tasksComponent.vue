<template>
</template>

<script setup>
import { watch } from "vue";
import { useProyectIdStore } from "../stores/proyect";
import { useTokenSotre } from "../stores/token";
import axios from "axios";

const proyectId = useProyectIdStore();
const token = useTokenSotre();

const opt = {
    headers: { Authorization: `Bearer ${token.userToken}` },
};

watch(proyectId.id, (newId)=>{

})

</script>
