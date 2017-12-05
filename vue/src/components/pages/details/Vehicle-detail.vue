<template>
  <div class="block vehicle-detail-page" v-cloak>
    <!--<div class="vehicle-image">
        <img v-if="vehicle" :src="vehicle.field_image[0].url" v-bind:alt="vehicle.field_image[0].alt">
    </div>-->
    <div v-if='vehicle' class="vehicle-details">
      <div class="vehicle-detail-header">
        <div class="owner">
          <i class="fa fa-user" aria-hidden="true"></i>
          <h1 v-if="owner" class="owner-name"> {{ owner.field_first_name[0].value }} {{ owner.field_last_name[0].value }}</h1>
        </div>
        <!--<div class="price">
          <p>€{{ vehicle.field_price[0].value }}/dag</p>
        </div>-->
      </div>

      <!--<div class="vehicle-detail-body">
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
        <div class="availability">
          <h1><span>Beschikbaarheid</span></h1>
          <datepicker calendar-button="true" calendar-button-icon="fa fa-calendar" :placeholder="vehicle.field_available_dates[0].value" format="dd MMM yyyy"></datepicker>
        </div>
        <div class="description">
          <h1><span>Beschrijving</span></h1>
          <p>{{ vehicle.field_description[0].value }}</p>
        </div>
        <div class="conditions">
          <h1><span>Voorwaarden</span></h1>
          <ul>
            <li v-for="condition in vehicle.field_conditions"> {{ condition.value }} </li>
          </ul>
        </div>
      </div>-->
      <datepicker calendar-button="true" calendar-button-icon="fa fa-calendar" format="dd MMM yyyy"></datepicker>
      <datepicker calendar-button="true" calendar-button-icon="fa fa-calendar" format="dd MMM yyyy"></datepicker>
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
            console.log(vehicleBookings[i]);
          }
          //this.getVehicleOwner();
        })
        .catch(e => {
          //this.errors.push(e)
        });
        
    },
    getVehicleOwner() {
      let self = this;
      let uri = this.$parent.uri;
      let ownerId = this.vehicle.field_owner[0].target_id

      axios
        .get( uri + 'user/' + ownerId + '?_format=json')
        .then(response => {
          self.owner = response.data
        })
        .catch(e => {
          this.errors.push(e)
        });
    },
    getVehicleBookings(bookingId) {
      let self = this;
      axios({
        method: 'get',
        baseURL: 'http://cmsdev.localhost/',
        url: 'track/booking/' + bookingId + '?_format=json',
      }).then(response => {
        self.bookings.push(response.data);
      }).catch( error =>{
      });
    }
  },
  mounted () {
      this.getVehicleById(this.$route.params.id);
  }
}
</script>
