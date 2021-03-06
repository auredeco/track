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
import EditVehicle from '@/components/pages/details/UpdateVehicle'
import Profile from '@/components/pages/Profile'
import Account from '@/components/pages/Account'
import MyVehicleBookings from '@/components/pages/details/MyVehicleBookings'
import BestSellers from '@/components/pages/BestSellers'
import MyBookings from '@/components/pages/details/MyBookings'



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
      path: '/vehicle/:id/edit',
      name: 'Voertuig aanpassen',
      component: EditVehicle
    },
    {
      path: '/profile/',
      name: 'Profile',
      component: Profile
    },
    {
      path: '/account/:id',
      name: 'Account',
      component: Account
    },
    {
      path: '/vehicle/:id/bookings',
      name: 'Voertuig boekingen',
      component: MyVehicleBookings
    },
    {
      path: '/bestsellers',
      name: 'BestSellers',
      component: BestSellers
    },
    {
      path: '/mybookings',
      name: 'Mijn boekingen',
      component: MyBookings
    }
  ]
})
