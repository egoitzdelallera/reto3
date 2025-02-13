import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/InicioView.vue'
import BasketView from '../views/BasketView.vue'
import BoxeoView from '../views/BoxeoView.vue'
import FutbolView from '../views/FutbolView.vue'
import TenisView from '../views/TenisView.vue'
import IniciarSesionComponent from '@/components/IniciarSesionComponent.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
  },
  {
    path: '/basket',
    name: 'basket',
    component: BasketView,
  },
  {
    path: '/boxeo',
    name: 'boxeo',
    component: BoxeoView,
  },
  {
    path: '/futbol',
    name: 'futbol',
    component: FutbolView,
  },
  {
    path: '/tenis',
    name: 'tenis',
    component: TenisView,
  },
  {
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (About.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import('../views/NavView.vue'),
  },
  {
    path: '/login',
    name: 'login',
    component: IniciarSesionComponent,
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

export default router
