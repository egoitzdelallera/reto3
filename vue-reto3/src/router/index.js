import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/InicioView.vue'
import BasketView from '../views/BasketView.vue'
import BoxeoView from '../views/BoxeoView.vue'
import FutbolView from '../views/FutbolView.vue'
import TenisView from '../views/TenisView.vue'
import IniciarSesionComponent from '@/components/IniciarSesionComponent.vue'
import IntranetComponent from '@/components/IntranetComponent.vue'

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
    component: () => import('../views/NavView.vue'),
  },
  {
    path: '/login',
    name: 'login',
    component: IniciarSesionComponent,
  },
  {
    path: '/intranet',
    name: 'intranet',
    component: IntranetComponent,
  },
  {
    path: '/:categoryName',
    name: 'NotFound',
    component: FutbolView,
    props: route => ({ categoryName: route.params.categoryName })
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

export default router