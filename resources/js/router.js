import {createRouter, createWebHistory} from "vue-router";
import FileUploadComponent from "./components/FileUploadComponent.vue";
import UsersComponent from "./components/users/UsersComponent.vue";
import UsersCreateComponent from "./components/users/UsersCreateComponent.vue";

const routes = [
    { path: '/', component: FileUploadComponent },
    { path: '/users', component: UsersComponent },
    { path: '/create', component: UsersCreateComponent },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router;
