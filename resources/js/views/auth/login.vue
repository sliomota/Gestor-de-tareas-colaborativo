<template>
    <form>
        <label for="email">Email</label>
        <input
            type="text"
            name="email"
            autocomplete="email"
            v-model="form.email"
        />
        <label for="password">Contraseña</label>
        <input
            type="text"
            name="password"
            autocomplete="new-passwor"
            v-model="form.password"
        />
        <button @click.prevent="submitHandler"></button>
    </form>
</template>
<script setup>
import { reactive } from "vue";
import axios from "axios";

const form = reactive({
    email: "",
    password: "",
});

const submitHandler = () => {
    axios
        .post("api/auth/login", form)
        .then((response) => {
        token.userToken = response.data.token;
    });
};
</script>
