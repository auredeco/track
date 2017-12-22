<template>
  <div class="block">
    <div class="input-field">
          <figure>
            <i class="fa fa-search" aria-hidden="true"></i>
          </figure>
          <input type="text" name="filter" placeholder="Filter" v-model="search">
      </div>

      <paginate name="filteredVehicles" :list="filterByName" :per="5">
       <div v-for="vehicle in paginated('filteredVehicles')" class="vehicle-block">
         <router-link :to="{ name: 'vehicle-detail', params: { id: vehicle.id[0].value }}">
          <img v-if="vehicle.field_image[0].url" :src="vehicle.field_image[0].url" :alt="vehicle.field_image[0].alt">
          <div class="brand">
            <img v-if="vehicle.field_brand[1]" :src="vehicle.field_brand[1].field_logo[0].url" :alt="vehicle.field_brand[1].field_logo[0].alt">
          </div>
          <div class="vehicle-info">
            <h1 v-if="vehicle.name[0].value">{{vehicle.name[0].value}}</h1>
          </div>  
        </router-link>
      </div>    
      </paginate>
      <paginate-links for="vehicles" :limit="5" :async="true"></paginate-links>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'overview',
  data () {
    return {
      title: 'Overzicht voertuigen',
      search: '',
      vehicles: [],
      paginate: ['filteredVehicles']
    }
  },
  methods: {
    loadVehicles() {
      let self = this
      axios
      .get('http://cmsdev.localhost/vehicles')
      .then(response => {
        // JSON responses are automatically parsed.
        self.vehicles = response.data
        self.vehicles.forEach(vehicle => {
          self.getBrand(vehicle);
        });
      })
      .catch(e => {
        this.errors.push(e)
      })
    },
    getBrand(vehicle) {
      let self = this;
      let vehicleId = vehicle.id[0].value;
      let brandUrl = vehicle.field_brand[0].url;
      axios
      .get('http://cmsdev.localhost' + brandUrl + '?_format=json')
      .then(response => {
        self.vehicles.forEach(vehicle => {
          if(vehicle.id[0].value == vehicleId) {
            vehicle.field_brand.push(response.data);
          }
        });
      })
      .catch(e => {
        this.errors.push(e)
      })
    }
  },
  computed: {
    filterByName() {
      return this.vehicles.filter( vehicle => {
        return vehicle.name[0].value.toLowerCase().indexOf(this.search.toLowerCase()) > -1 ;
      })
    }
  },
  created () {
    this.loadVehicles();
  }
}
</script>
