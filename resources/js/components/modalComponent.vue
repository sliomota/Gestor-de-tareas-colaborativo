<template>
<div class="fixed inset-0 bg-black opacity-70 flex items-center justify-center z-50" v-show="modal.open" @click.self="modal.close">
<div class="bg-white rounded-lg shadow-xl p-6 w-11/12 md:w-1/2 lg:w-1/3 relative">
    <slot/>
    <button @click="modal.close">X</button>
    </div>
</div>
</template>
<script setup>
import { useModalStore } from '../stores/modal';
const modal = useModalStore();
</script>