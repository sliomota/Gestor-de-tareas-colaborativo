<template>
    <div>
        <h2>Invitacion</h2>
        <button class="border-1 black" v-if="loading">...cargando</button>
        <button
            class="border-1 black"
            v-if="!loading && !error"
            @click="aceptInvitation"
        >
            aceptar invitation
        </button>
        <h3 v-if="error && !loading">{{ error }}</h3>
    </div>
</template>
<script setup>
import { onMounted, ref } from "vue";
import { useTokenSotre } from "../stores/token";
import { usePendingToken } from "../stores/pendingToken";
import { useRouter } from "vue-router";
import axios from "axios";

const router = useRouter();
const userToken = useTokenSotre();
const pendingToken = usePendingToken();
const { token } = defineProps({ token: String });

const loading = ref(true);
const error = ref("");

onMounted(async () => {
    axios
        .get(`/api/invitation/${token}`, {
            headers: { Authorization: `Bearer ${userToken.userToken}` },
        })
        .then((response) => {
            loading.value = false;
        })
        .catch((e) => {
            loading.value = false;
            error.value = e.response.data.message;
        });
});

const aceptInvitation = async () => {
    if (!userToken.userToken) {
        pendingToken.token = token;
        router.push("/login");
    } else {
        axios
            .post(
                "/api/invitation/accept",
                { token: token },
                {
                    headers: {
                        Authorization: `Bearer ${userToken.userToken}`,
                    },
                }
            )
            .then((response) => {
                pendingToken.resetToken();
                router.push("/dashboard");
            });
    }
};
</script>
