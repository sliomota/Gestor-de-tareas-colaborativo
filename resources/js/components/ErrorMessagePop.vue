<template>
        <TransitionGroup name="list" tag="div" class="flex flex-col gap-2 w-2/3">
            <div
                v-for="(message, i) in errorMesage.messages"
                class="border w-full p-2 px-4 rounded-md bg-red-500/65 flex justify-between"
                :key="i"
            >
                <div>{{ message }}</div>
                <button @click="errorMesage.deleteMessage(i)">X</button>
            </div>
        </TransitionGroup>
</template>
<script setup>
import { useErrorMessageStore } from "../stores/error";
const errorMesage = useErrorMessageStore();
</script>
