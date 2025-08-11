<template>
    <button @click="createProyectHandler">Crear Proyecto</button>

    <div>
        <label for="title">Title: </label>
        <input type="text" name="title" id="title" v-model="form.name" />
        <label for="description">Description: </label>
        <input
            type="text"
            name="description"
            id="description"
            v-model="form.description"
        />
    </div>
    <router-link
        v-for="value in proyects"
        :key="value.id"
        :to="`/proyects/${value.id}`"
        >{{ value.name }}</router-link
    >
</template>
<script setup>
import axios from "axios";
import { useTokenSotre } from "../stores/token";

import { reactive, ref } from "vue";
const token = useTokenSotre();
const form = reactive({
    name: "",
    description: "",
});
const proyects = ref([]);
const opt = {
    headers: { Authorization: `Bearer ${token.userToken}` },
};

axios.get("api/proyects/", opt).then((response) => {
    proyects.value.push(...response.data.model);
});

const createProyectHandler = () => {
    axios.post("api/proyects/", form, opt).then((response) => {
        proyects.value.push(...response.data.model);
    });
};
</script>
