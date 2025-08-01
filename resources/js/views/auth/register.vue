<template>
    <form>
        <label for="name"> nombre </label>
        <input
            type="text"
            name="name"
            autocomplete="username"
            v-model="form.name"
        />
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
            autocomplete="new-password"
            v-model="form.password"
        />
        <label for="password_confirmation">Confirmar Contraseña</label>
        <input
            type="text"
            name="password_confirmation"
            autocomplete="new-password"
            v-model="form.password_confirmation"
        />
        <button @click.prevent="submitHandler">enviar</button>
    </form>
    <h3>{{ token.userToken }}</h3>
</template>

<script setup>
import { reactive } from "vue";
import { useTokenSotre } from "../../stores/token";
import axios from "axios";
const token = useTokenSotre;
const form = reactive({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submitHandler = () => {
    axios.post("api/auth/register", form).then((response) => {
        token.userToken = response.data.token;
    });
    console.log(token.userToken);
    
};
</script>
