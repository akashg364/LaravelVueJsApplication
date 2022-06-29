import AllWebsites from './components/AllWebsites.vue';
import RegisterForm from './components/RegisterForm.vue';
 
export const routes = [
    {
        name: 'home',
        path: '/',
        component: AllWebsites
    },
    {
        name: 'register',
        path: '/register',
        component: RegisterForm
    }
];