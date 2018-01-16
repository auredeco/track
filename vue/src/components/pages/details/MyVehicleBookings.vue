<template>
  <div class="block vehicle-detail-page" v-cloak>
    <div class="vehicle-image">
        <img v-if="vehicle" :src="vehicle.field_image[0].url" v-bind:alt="vehicle.field_image[0].alt">
    </div>
    <div v-if='vehicle' class="vehicle-details">
      <h3>Boekingen {{ vehicle.name[0].value }}</h3>
      <div class="vehicle-detail-body">
        <table v-if="bookings.length > 0" >
          <div class="booking-info" v-for="booking in bookings">
            <tr>
              <td>Huurder:</td>  <td>{{ booking.field_booker.field_first_name[0].value }} {{ booking.field_booker.field_last_name[0].value }}</td>
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
          <p>Er zijn geen boekingen voor dit voertuig!</p>
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
      vehicle: null,
    }
  },
  methods: {
      moment (date) {
        return moment(date).format('DD-MM-YYYY');
      },
      getVehicleById(id) {
        let self = this;
        let uri = this.$parent.uri;

        axios
        .get( uri + 'track/vehicle/' + id + '?_format=json')
        .then(response => {
          self.vehicle = response.data;
          let vehicleBookings = JSON.parse(JSON.stringify(response.data.field_bookings));
          for(let i = 0; i < vehicleBookings.length; i++) {
            self.getVehicleBookings(vehicleBookings[i].target_id);
          }
          self.checkUser(self.$parent.user.current_user.uid);
          console.log(self.bookings);
        })
        .catch(e => {
          //this.errors.push(e)
        });
    },
    getVehicleBookings(vehicleId) {
      let self = this;
      axios({
        method: 'get',
        baseURL: 'http://cmsdev.localhost/',
        url: 'track/booking/' + vehicleId + '?_format=json',
      }).then(response => {
        self.bookings.push(response.data);
        self.GetVehicleBookers(response.data.field_booker[0].url)
      })
      .catch( error =>{
      });
    },
    GetVehicleBookers(url) {
      let self = this;
      axios({
        method: 'get',
        baseURL: 'http://cmsdev.localhost',
        url: url + '?_format=json',
      }).then(response => {
        for(let i = 0; i <= self.bookings.length; i++) {
          self.bookings[i].field_booker = response.data;
        }
      })
      .catch( error =>{
      });
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
    this.getVehicleById(this.$route.params.id);
  }
}
</script>

<style>

table {
  width: 100%;
}

.booking-info {
  margin: 1rem 0;
  border-left: 2px solid black;
  padding: 0 1rem;
}

td {
  padding: 0.5rem 0.5rem 0.5rem 0;
}
</style>