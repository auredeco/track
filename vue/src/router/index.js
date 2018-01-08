import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/pages/Login'
import Register from '@/components/pages/Register'
import Home from '@/components/pages/Home'
import Overview from '@/components/pages/Overview'
import VehicleDetail from '@/components/pages/details/Vehicle-detail'
import BookingPage from '@/components/pages/details/Booking'
import BookingSuccesPage from '@/components/pages/details/BookingSucces'
import CreateVehicle from '@/components/pages/details/CreateVehicle'
import Profile from '@/components/pages/Profile'
import MyVehicleBookings from '@/components/pages/details/MyVehicleBookings'
import BestSellers from '@/components/pages/BestSellers'

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
    },
    {
      path: '/create/vehicle',
      name: 'CreateVehicle',
      component: CreateVehicle
    },
    {
      path: '/profile',
      name: 'Profile',
      component: Profile
    },
    {
      path: '/vehicle/:id/bookings',
      name: 'MyVehicleBookings',
      component: MyVehicleBookings
    },
    {
      path: '/bestsellers',
      name: 'BestSellers',
      component: BestSellers
    }
  ]
})
