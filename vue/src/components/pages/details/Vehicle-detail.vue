<template>
  <div class="block vehicle-detail-page" v-cloak>
    <div class="vehicle-image">
        <img v-if="vehicle" :src="vehicle.field_image[0].url" v-bind:alt="vehicle.field_image[0].alt">
    </div>
    <div v-if='vehicle' class="vehicle-details">
      <div class="vehicle-detail-header">
        <div class="owner">
          <i class="fa fa-user" aria-hidden="true"></i>
          <h1 v-if="owner" class="owner-name"> {{ owner.field_first_name[0].value }} {{ owner.field_last_name[0].value }}</h1>
        </div>
        <div class="price">
          <p>€{{ vehicle.field_price[0].value }}/dag</p>
        </div>
      </div>

      <div class="vehicle-detail-body">
        <div class="tiles">
          <div class="battery">
            <i class="fa fa-battery-full" aria-hidden="true"></i>
            <p>100%</p>
          </div>
          <div class="location">
            <i class="fa fa-map-marker" aria-hidden="true"></i>
            <p>Gent</p>
          </div>
          <div class="rating">
            <i class="fa fa-heart" aria-hidden="true"></i>
            <p>22</p>
          </div>
        </div>
        <div class="description">
          <h1><span>Beschrijving</span></h1>
          <p>{{ vehicle.field_description[0].value }}</p>
        </div>
        <!--<div class="conditions">
          <h1><span>Voorwaarden</span></h1>
          <ul>
            <li v-for="condition in vehicle.field_conditions"> {{ condition.value }} </li>
          </ul>
        </div>-->
      </div>
      </div>
    <div class="Book-Button">
      <router-link v-if="vehicle" :to="{ name: 'booking', params: { id: vehicle.id[0].value }}">
      <p>Boeken</p>
      </router-link>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Datepicker from 'vuejs-datepicker';

export default {
  name: 'VehicleDetail',
  data () {
    return {
      vehicle: null,
      owner: null,
      bookings: []
    }
  },
  components: {
    Datepicker
  },
  methods: {
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
          self.getVehicleOwner(response.data.user_id[0].target_id);
        })
        .catch(e => {
          //this.errors.push(e)
        });
        
    },
    getVehicleOwner(ownerId) {
      let self = this;
      axios({
        method: 'get',
        baseURL: 'http://cmsdev.localhost/',
        url: 'user/' + ownerId + '?_format=json',
      }).then(response => {
        self.owner = response.data;
      })
    },
    getVehicleBookings(vehicleId) {
      let self = this;
      axios({
        method: 'get',
        baseURL: 'http://cmsdev.localhost/',
        url: 'track/booking/' + vehicleId + '?_format=json',
      }).then(response => {
        self.bookings.push(response.data);
      })
      .catch( error =>{
      });
    },
  },
  mounted() {
      this.getVehicleById(this.$route.params.id);
  }
}
</script>
