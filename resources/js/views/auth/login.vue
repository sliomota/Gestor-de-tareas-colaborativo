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
        <button @click.prevent="submitHandler">Iniciar sesion</button>
    </form>
</template>
<script setup>
import { reactive } from "vue";
import { useRouter } from "vue-router";
import { useTokenSotre } from "../../stores/token";
import { usePendingToken } from "../../stores/pendingToken";
import axios from "axios";

const pendingToken = usePendingToken();

const token = useTokenSotre();

const router = useRouter();

const form = reactive({
    email: "",
    password: "",
});

const submitHandler = () => {
    axios.post("/api/auth/login", form).then((response) => {
        token.userToken = response.data.token;
       if(pendingToken.token){
        router.push(`/invitation/${pendingToken.token}`);
       } 
        router.push("/dashboard");
    });
};
</script>
