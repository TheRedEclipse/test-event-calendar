import { createRouter, createWebHistory } from 'vue-router'
import Index from './pages/Index.vue'
import signIn from './pages/signIn.vue'
import users from './pages/Users.vue'
import departments from './pages/Departments.vue'

const routes = [
    {
        path: '/',
        name: 'index',
        component: Index
    },
    {
        path: '/sign-in',
        name: 'signIn',
        component: signIn
    },
    {
        path: '/users',
        name: 'users',
        component: users
    },
    {
        path: '/departments',
        name: 'departments',
        component: departments
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;
