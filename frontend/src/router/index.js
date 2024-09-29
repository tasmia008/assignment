// Import necessary modules from Vue Router
import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';

// Define the routes for your app
const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/about',
    name: 'about',
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  }
];

// Create a router instance and pass the `routes` option
const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

// Export the router instance so it can be used in the main Vue app
export default router;
