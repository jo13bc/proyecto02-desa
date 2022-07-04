import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import App from './App.vue';
import Login from './Login.vue';
import Register from './Register.vue';
import Home from './Home.vue';
import Help from './Help.vue';
import Plans from './Plans.vue';
import Users from './Users.vue';
import Calendar from './Calendar.vue';


const routes = [
    { path: '/', component: Home },
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/help', component: Help },
    { path: '/plans', component: Plans },
    { path: '/calendar/users', component: Users },
    { path: '/calendar/:id', component: Calendar }
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes
});

const app = createApp(App);

app.use(router);
app.use(VueSweetalert2);

app.mount('#app');