import { createWebHistory, createRouter } from 'vue-router'

const Home= ()=> import('./views/home.vue');
const Register= ()=> import('./views/auth/register.vue');

const routes = [
  { path: '/', component: Home },
  { path: '/register', component: Register },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router;