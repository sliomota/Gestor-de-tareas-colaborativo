<template></template>
<script setup>
import { onMounted } from "vue";
import { useTokenSotre } from "../stores/token";
import { usePendingToken } from "../stores/pendingToken";
import { useRouter } from "vue-router";
import axios from "axios";

const router = useRouter();
const userToken = useTokenSotre();
const pendingToken = usePendingToken();
const { token } = defineProps({ token: String });

onMounted(() => {
    if (!userToken.userToken) {
        pendingToken.token = token;
        router.push("/login");
    } else {
        axios
            .post(
                "/api/invitation/accept",
                { token: token },
                { headers: { Authorization: `Bearer ${userToken.userToken}` } }
            )
            .then((response) => {
                pendingToken.resetToken();
                router.push("/dashboard");
            });
    }
});
</script>
