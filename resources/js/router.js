import { createWebHistory, createRouter } from "vue-router";

const Home = () => import("./views/home.vue");
const Register = () => import("./views/auth/register.vue");
const Login = () => import("./views/auth/login.vue");

const routes = [
    { path: "/", component: Home },
    { path: "/register", component: Register },
    { path: "/login", component: Login },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
