import { routes as home } from '../views/Home/index';
import MainPage from '../views/Main/pages/Main.vue';

export default [
    {
        path: '/',
        component: MainPage,
        children: [
            ...home
        ]
    }
]
