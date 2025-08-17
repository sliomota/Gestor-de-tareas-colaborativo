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
        <button @click="createTaskHandler" class="text-red-700">
            create task
        </button>
    </div>
    <div v-for="value in task" :key="value.id">
        <h3>{{ value.title }}</h3>
        <p>{{ value.description }}</p>
        <label for="status">{{
            value.status ? "completado" : "pendiente"
        }}</label>
        <input
            type="checkbox"
            name="status"
            id="status"
            :checked="value.status"
            @click="taskStatusHandler(value.id)"
        />
        <button @click="deleteTaskHandler(value.id)">X</button>
        <button @click="openModal(value.id, value.title, value.description)">
            E
        </button>
    </div>
    <modal-component>
        <label for="title">titulo </label>
        <input
            type="text"
            name="title"
            id="title"
            v-model="editTaskForm.title"
        />
        <label for="descripcion">descripcion </label>
        <input
            type="text"
            name="descripcion"
            id="descripcion"
            v-model="editTaskForm.description"
        />
        <button @click="editTaskHandler" class="mx-4">save</button>
    </modal-component>
</template>
<script setup>
import axios from "axios";
import { reactive, onMounted, ref } from "vue";
import { useTokenSotre } from "../stores/token";
import { useModalStore } from "../stores/modal";
import modalComponent from "../components/modalComponent.vue";
const task = ref([]);
const modal = useModalStore();
const taskForm = reactive({
    title: "",
    description: "",
});
const editTaskForm = reactive({
    title: "",
    description: "",
});
const modelId = ref("");
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
    axios.post(`/api/proyect/${id}/tasks`, taskForm, opt).then((response) => {
        task.value.push(response.data.model);
    });
};

const taskStatusHandler = (id) => {
    axios.patch(`/api/tasks/${id}/status`, opt).then((response) => {
        task.value = task.value.map((c) =>
            c.id == id ? response.data.model : c
        );
    });
};

const deleteTaskHandler = (id) => {
    axios.delete(`/api/tasks/${id}`, opt).then(() => {
        task.value = task.value.filter((c) => c.id !== id);
    });
};

const openModal = (id, title, description) => {
    modal.openModal();
    modelId.value = id;
    editTaskForm.title = title;
    editTaskForm.description = description;

    // axios.put(`/api/tasks/${id}`, opt, editTaskForm).then(() => {
    //     task.value = task.value.filter((c) => c.id !== id);
    // });
};

const editTaskHandler = () => {
    axios.patch(`/api/tasks/${modelId.value}`, editTaskForm, opt).then((response) => {
        console.log(response.data);
    });
};
</script>
