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
            <p v-if="vehicle.field_location.field_city">{{ vehicle.field_location.field_city[0].value }}</p>
          </div>
          <div class="rating">
            <i class="fa fa-users" aria-hidden="true"></i>
            <p>{{ vehicle.field_seats[0].value }}</p>
          </div>
        </div>
        <div class="description">
          <h1><span>Beschrijving</span></h1>
          <p>{{ vehicle.field_description[0].value }}</p>
        </div>
        <div class="conditions">
          <h1><span>Specificaties &amp; voorwaarden</span></h1>
          <ul>
            <li v-if="vehicle.field_age"> Bouwjaar: {{ vehicle.field_age[0].value }}</li>
            <li> Zitplaatsen: {{ vehicle.field_seats[0].value }}</li>
            <li v-if="vehicle.field_conditions" v-for="condition in vehicle.field_conditions"> {{ condition.value }} </li>
          </ul>
        </div>
        <div class="map-container">
          <v-map ref="map" :zoom=13 :center="mapSettings.center">
             <v-tilelayer url="http://{s}.tile.osm.org/{z}/{x}/{y}.png"></v-tilelayer>
             <v-marker v-if="mapSettings.marker" :lat-lng="mapSettings.marker"></v-marker>
          </v-map>
        </div>
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
      bookings: [],
      mapSettings: {
        zoom: 13,
        center: [51.086784, 3.671661],
        url: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        marker: null,
      }
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
          self.getVehicleOwner(response.data.user_id[0].target_id);
          self.getVehicleLocation(self.vehicle.field_location[0].target_id)
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
    getVehicleLocation(locationId) {
      let self = this;
      axios({
        method: 'get',
        baseURL: 'http://cmsdev.localhost/',
        url: 'track/location/' + locationId + '?_format=json',
      }).then(response => {
        self.vehicle.field_location = response.data;
        self.getLatLngFromLocation();
      })
    },
    getLatLngFromLocation() {
      let self = this;
      let locationData = this.vehicle.field_location.field_streetname[0].value + ',' +
                     this.vehicle.field_location.field_postal[0].value + ',' +
                     this.vehicle.field_location.field_city[0].value + ',' +
                     this.vehicle.field_location.field_country[0].value;

      axios({
        method: 'get',
        baseURL: 'https://maps.googleapis.com/maps/api/geocode/',
        url: 'json?address=' + locationData + '&key=' + self.$parent.GoogleApiKey,
      }).then(response => {
        self.mapSettings.center = [response.data.results[0].geometry.location.lat, response.data.results[0].geometry.location.lng];
        self.mapSettings.marker = L.latLng(response.data.results[0].geometry.location.lat, response.data.results[0].geometry.location.lng);
      })
    }
  },
  mounted() {
      this.getVehicleById(this.$route.params.id);
  }
}
</script>

<style>
@import "~leaflet/dist/leaflet.css";

.conditions {
  margin-top: 2rem;
}
</style>