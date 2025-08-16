<template>
    <h1>hello world</h1>
    <router-link to="/register">Registrarse</router-link>
    <router-link to="/login">Iniciar sesion</router-link>
    <button @click="logoutHandler">logout</button>
</template>

<script setup>
import axios from "axios";
import { useRouter } from "vue-router";
import { useTokenSotre } from "../stores/token";
const token = useTokenSotre();
const router = useRouter();
const logoutHandler = () => {
    axios
        .post(
            "api/auth/logout",
            {},
            {
                headers: {
                    Authorization: `Bearer ${token.userToken}`,
                },
            }
        )
        .then((response) => {
            token.tokenReset();
            router.push("/");
        });
};
</script>
