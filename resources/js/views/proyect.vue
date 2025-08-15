<template>
    <div class="task">
        <label for="title">titulo</label>
        <input type="text" name="title" id="title" v-model="taskForm.title" />
        <label for="descripcion">descripcion</label>
        <input
            type="text"
            name="descripcion"
            id="descripcion"
            v-model="taskForm.description"
        />
        <button @click="createTaskHandler">create task</button>
    </div>
    {{ task}}
</template>
<script setup>
import axios from "axios";
import { reactive, onMounted, ref } from "vue";
import { useTokenSotre } from "../stores/token";
const task = ref([]);

const taskForm = reactive({
    title: "",
    description: "",
});
const token = useTokenSotre();
const { id } = defineProps({
    id: String,
});

const opt = { headers: { Authorization: `Bearer ${token.userToken}` } };
onMounted(() => {
    axios.get(`/api/proyect/${id}/tasks`, opt).then((response) => {
        
        response.data.model.length > 0
            ? task.value.push(...response.data.model)
            : [];
    });
    
});

const createTaskHandler = () => {
    axios.post(`/api/proyect/${id}/tasks`, taskForm, opt).then(response =>{task.value.push(response.data.model)
    });
};
</script>
