<template>
  <div class="block vehicle-detail-page" v-cloak>
    <div class="user-image">
        <img v-if="user" :src="user.user_picture[0].url">
    </div>
    <div class="booking-details">
      <h3>Mijn boekingen</h3>
      <div class="vehicle-detail-body">
        <table v-if="bookings.length > 0" >
         <div class="booking-info" v-for="booking in bookings">
           <tr>
             <td>Voertuig:</td><td v-if="booking.field_vehicle.name[0].value"><router-link :to="{ name: 'vehicle-detail', params: { id: booking.field_vehicle.id[0].value }}">{{booking.field_vehicle.name[0].value}}</router-link></td>
           </tr>
            <tr>
              <td>Startdatum:</td><td>{{ moment(booking.field_start_date[0].value) }}</td>
            </tr>
            <tr>
              <td>Einddatum:</td><td>{{ moment(booking.field_end_date[0].value) }}</td>
            </tr>
          </div>
        </table>
        <div v-else>
          <p>Je hebt nog niets geboekt</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'VehicleBookings',
  data () {
    return {
      bookings: [],
      user: null
    }
  },
  methods: {
    getUserData(id) {
      let self = this
      axios({
        method: 'get',
        baseURL: 'http://cmsdev.localhost/',
        url: 'user/' + id + '?_format=json',
      }).then(response => {
        self.user = response.data
        console.log(self.user);
        self.user.field_user_bookings.forEach(booking => {
          self.getUserBookings(booking.url)
        });
      }).catch( error => {
        console.log(error);
      });
    },
    getUserBookings(url) {
      let self = this
      axios({
        method: 'get',
        baseURL: 'http://cmsdev.localhost/',
        url: url + '?_format=json',
      }).then(response => {
        self.bookings.push(response.data);
        console.log(self.bookings);
        self.getVehicleFromBooking(response.data.id[0].value,response.data.field_vehicle[0].url);
      }).catch( error => {
        console.log(error);
      });
    },
    getVehicleFromBooking(bookingId, url){
      let self = this
      axios({
        method: 'get',
        baseURL: 'http://cmsdev.localhost/',
        url: url + '?_format=json',
      }).then(response => {
        self.bookings.forEach(booking => {
          if(booking.id[0].value == bookingId) {
            booking.field_vehicle = response.data;
          }
        });
        console.log(self.bookings);
      }).catch( error => {
        console.log(error);
      });
    },
    moment (date) {
      return moment(date).format('DD-MM-YYYY');
    },
    checkIfUserLogin() {
      if(localStorage.getItem('Track-User')) {
        this.$parent._data.user = JSON.parse(localStorage.getItem('Track-User'));
      }
    },
    checkUser(id) {
      if(!this.vehicle.user_id[0].target_id == id)
      {
        this.$router.push('/home');
      }
    }
  },
  mounted() {
    this.checkIfUserLogin();
    this.getUserData(this.$parent.user.current_user.uid);
  }
}
</script>

<style>
.user-image {
  position: absolute;
  left: 0;
  top:0;
}

table {
  width: 100%;
}

.booking-info {
  margin: 1rem 0;
  padding: 1rem;
  border-left: 2px solid #2D2D2D;
}

td {
  padding: 0.5rem 0.5rem 0.5rem 0;
}

.booking-details {
  padding: 0 1rem;
  background: rgba(255, 255, 255, 1);
  color: #2D2D2D;
  padding: 1rem;
  border-radius: 15px;
  position: relative;
  top: 10rem;
  -webkit-box-shadow: 8px 4px 42px -15px rgba(0,0,0,0.75);
  -moz-box-shadow: 8px 4px 42px -15px rgba(0,0,0,0.75);
  box-shadow: 8px 4px 42px -15px rgba(0,0,0,0.75);
}
</style>