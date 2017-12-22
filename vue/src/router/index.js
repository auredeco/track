import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/pages/Login'
import Register from '@/components/pages/Register'
import Home from '@/components/pages/Home'
import Overview from '@/components/pages/Overview'
import VehicleDetail from '@/components/pages/details/Vehicle-detail'
import BookingPage from '@/components/pages/details/Booking'
import BookingSuccesPage from '@/components/pages/details/BookingSucces'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'login',
      component: Login
    },
    {
      path: '/register',
      name: 'register',
      component: Register
    },
    {
      path: '/home',
      name: 'home',
      component: Home
    },
    {
      path: '/overview',
      name: 'overview',
      component: Overview
    },
    {
      path: '/vehicle/:id',
      name: 'vehicle-detail',
      component: VehicleDetail
    },
    {
      path: '/vehicle/:id/booking',
      name: 'booking',
      component: BookingPage
    },
    {
      path: '/vehicle/:id/booking/succes',
      name: 'BookingSucces',
      component: BookingSuccesPage
    }
  ]
})
