import { createRouter, createWebHistory } from 'vue-router'

import Home from '../views/Home.vue';
import Rules1 from '../views/RulesOne.vue';
import Rules2 from '../views/RulesTwo.vue';
import Demo from '../views/DemoView.vue';
import Rules3 from '@/views/RulesThree.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'home', component: Home },
    { path: '/rules-1', name: 'rules-1', component: Rules1 },
    { path: '/rules-2', name: 'rules-2', component: Rules2 },
    { path: '/rules-3', name: 'rules-3', component: Rules3 },

    { path: '/demo', name: 'demo', component: Demo },
  ],
});

export default router
