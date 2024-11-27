import { createRouter, createWebHistory } from 'vue-router'

import Home from '../views/Home.vue';
import Rules1 from '../views/Rules1.vue';
import Rules2 from '../views/Rules2.vue';
import Demo from '../views/DemoView.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'home', component: Home },
    { path: '/rules-1', name: 'rules-1', component: Rules1 },
    { path: '/rules-2', name: 'rules-2', component: Rules2 },
    { path: '/demo', name: 'demo', component: Demo },
  ],
});

export default router
