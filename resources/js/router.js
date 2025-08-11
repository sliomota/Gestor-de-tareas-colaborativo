import { createWebHistory, createRouter } from "vue-router";

const Home = () => import("./views/home.vue");
const Register = () => import("./views/auth/register.vue");
const Login = () => import("./views/auth/login.vue");
const Dashboard = ()=> import("./views/dashboard.vue");
const routes = [
    { path: "/", component: Home },
    { path: "/register", component: Register },
    { path: "/login", component: Login },
    { path: "/dashboard", component: Dashboard },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
