import { createWebHistory, createRouter } from "vue-router";

const Home = () => import("./views/home.vue");
const Register = () => import("./views/auth/register.vue");
const Login = () => import("./views/auth/login.vue");
const Dashboard = () => import("./views/dashboard.vue");
const Proyect = () => import("./views/proyect.vue");
const Invitation = () => import("./views/invitation.vue");
const routes = [
    { path: "/", component: Home },
    { path: "/register", component: Register },
    { path: "/login", component: Login },
    {
        path: "/dashboard",
        component: Dashboard,
    },
    { path: "/proyect/:id", component: Proyect, name: "proyect", props: true },
    {
        path: "/invitation/:token",
        component: Invitation,
        name: "invitation",
        props: true,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
