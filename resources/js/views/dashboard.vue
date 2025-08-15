<template>
    <div>
        <button @click="createProyectHandler">Crear Proyecto</button>

        <div>
            <label for="title">Title: </label>
            <input
                type="text"
                name="title"
                id="title"
                v-model="proyectForm.name"
            />
            <label for="description">Description: </label>
            <input
                type="text"
                name="description"
                id="description"
                v-model="proyectForm.description"
            />
        </div>
        <router-link
            v-for="value in proyects"
            :key="value.id"
            :to="{ name: 'proyect', params: { id: value.id } }"
        >
            {{ value.name }}
        </router-link>
    </div>
</template>
<script setup>
import axios from "axios";
import { reactive, ref, watch, onMounted } from "vue";

import { useTokenSotre } from "../stores/token";

const token = useTokenSotre();

const proyectForm = reactive({
    name: "",
    description: "",
});

const { id } = defineProps({ id: String });

const proyects = ref([]);

const opt = {
    headers: { Authorization: `Bearer ${token.userToken}` },
};

const createProyectHandler = () => {
    axios.post("/api/proyects/", proyectForm, opt).then((response) => {
        proyects.value.push(response.data.model);
    });
};
let url = "";

onMounted(() => {
    axios.get("/api/proyects/", opt).then((response) => {
        proyects.value.push(...response.data.model);
    });
});

watch(
    () => id,
    (newId) => {
        const url = "/api/tasks/" + newId;
        axios.get(url, opt).then((response) => {
            console.log(response.data);
        });
    }
);
</script>
