<template>
    <div
        class="w-180 my-10 mx-auto border border-black rounded-md flex flex-col items-center justify-center gap-4 px-2 py-6 *:flex *:gap-2 *:flex-col shadow-md"
    >
        <error-message-pop></error-message-pop>
        <h3 class="text-xl font-semibold">Iniciar Sesión</h3>
        <div class="w-2/3">
            <label for="email">Email</label>
            <input
                type="text"
                name="email"
                id="email"
                autocomplete="email"
                v-model="form.email"
                class="input"
            />
        </div>
        <div class="w-2/3">
            <label for="password">Contraseña</label>
            <input
                type="text"
                name="password"
                id="password"
                autocomplete="new-passwor"
                v-model="form.password"
                class="input"
            />
        </div>
        <button
            @click.prevent="submitHandler"
            class="w-2/3 button hover:bg-gray-200"
        >
            Iniciar sesion
        </button>
    </div>
</template>
<script setup>
import { reactive } from "vue";
import { useRouter } from "vue-router";
import ErrorMessagePop from "../../components/ErrorMessagePop.vue";
import { useTokenSotre } from "../../stores/token";
import { useErrorMessageStore } from "../../stores/error";
import { usePendingToken } from "../../stores/pendingToken";
import axios from "axios";

const pendingToken = usePendingToken();

const errorMesage = useErrorMessageStore();

const token = useTokenSotre();

const router = useRouter();

const form = reactive({
    email: "",
    password: "",
});

const submitHandler = () => {
    axios
        .post("/api/auth/login", form)
        .then((response) => {
            token.userToken = response.data.token;
            if (pendingToken.token) {
                router.push(`/invitation/${pendingToken.token}`);
            }
            router.push("/dashboard");
        })
        .catch((error) => {
            errorMesage.messages = Object.values(
                error.response.data.errors
            ).flatMap((c) => c);
            setTimeout(errorMesage.clearMessages,10000 )
        });
};
</script>
