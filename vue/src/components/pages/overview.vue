<template>
  <div class="block">
    <div class="button-field">
      <router-link :to="{ name: 'CreateVehicle'}">
        <div class="small-button btn-orange"><i class="fa fa-plus" aria-hidden="true"></i> Voertuig aanbieden</div>
      </router-link>
    </div>
    <div class="input-field">
          <figure>
            <i class="fa fa-search" aria-hidden="true"></i>
          </figure>
          <input type="text" name="filter" placeholder="Filter" v-model="search">
    </div>
    <div class="input-field">
      <select v-model="selectedBrandFilter" name="brand" id="brand">
        <option value="0"> Selecteer uw merk</option>
        <option v-for="brand in brands" :value="brand.id[0].value">{{ brand.name[0].value }}</option>
      </select>
    </div>  
      <paginate name="filteredVehicles" :list="filterByName" :per="5">
       <div v-for="vehicle in paginated('filteredVehicles')" class="vehicle-block">
         <router-link :to="{ name: 'vehicle-detail', params: { id: vehicle.id[0].value }}">
          <img v-if="vehicle.field_image[0]" :src="vehicle.field_image[0].url" :alt="vehicle.field_image[0].alt">
          <div class="brand">
            <img v-if="vehicle.field_brand[1]" :src="vehicle.field_brand[1].field_logo[0].url" :alt="vehicle.field_brand[1].field_logo[0].alt">
          </div>
          <div class="vehicle-info">
            <h1 v-if="vehicle.name[0].value">{{vehicle.name[0].value}}</h1>
            <p>{{ vehicle.field_age[0].value }}</p>
            <p>{{ vehicle.field_conditions[0].value }}</p>
            <p>{{ vehicle.field_location.DistanceFromUser }}km</p>
            <p>€{{ vehicle.field_price[0].value }}</p>
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
  name: 'Overview',
  data () {
    return {
      title: 'Overzicht voertuigen',
      search: '',
      vehicles: [],
      brands: [],
      selectedBrandFilter: 0,
      paginate: ['filteredVehicles'],
      user: null
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
          self.getVehicleLocation(vehicle);
          self.getBrand(vehicle);
        });
      })
      .catch(e => {
        console.log(e)
      })
    },
    getAllBrands() {
      let self = this
      axios
      .get('http://cmsdev.localhost/brands')
      .then(response => {
        self.brands = response.data;
      })
      .catch(e => {
        console.log(e)
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
    },
    getUser(id) {
      let self = this;
      axios({
        method: 'GET',
        baseURL: 'http://cmsdev.localhost/',
        url: 'user/' + id + '?_format=json',
      }).then(response => {
        self.user = response.data
        self.getUserLocation(self.user.field_location[0].url)
      })
      .catch( error =>{
        console.log(error.response);
      });
    },
    getUserLocation(location) {
      let self = this;
      axios({
        method: 'GET',
        baseURL: 'http://cmsdev.localhost',
        url: location + '?_format=json',
      }).then(response => {
        self.user.field_location = response.data
        self.convertUserLocationToLatLng(self.user.field_location);
      })
      .catch( error =>{
        console.log(error.response);
      });
    },
    getVehicleLocation(vehicle) {
      let self = this;
      let vehicleId = vehicle.id[0].value
      let locationId = vehicle.field_location[0].target_id;
      axios({
        method: 'GET',
        baseURL: 'http://cmsdev.localhost',
        url: vehicle.field_location[0].url + '?_format=json',
      }).then(response => {
        for(let i = 0; i < self.vehicles.length; i++) {
          if(self.vehicles[i].id[0].value == vehicleId) {
            self.vehicles[i].field_location = response.data;
            self.convertVehicleLocationToLatLng(self.vehicles[i].field_location, self.vehicles[i].id[0].value);
          }
        }
      })
      .catch( error =>{
        console.log(error.response);
      });
    },
    convertUserLocationToLatLng(location) {
      let self = this;
      let locationData = location.field_streetname[0].value + ',' +
                     location.field_postal[0].value + ',' +
                     location.field_city[0].value + ',' +
                     location.field_country[0].value;

      axios({
        method: 'get',
        baseURL: 'https://maps.googleapis.com/maps/api/geocode/',
        url: 'json?address=' + locationData + '&key=' + self.$parent.GoogleApiKey,
      }).then(response => {
        self.user.field_location["LatLng"] = response.data.results[0].geometry.location
      })
    },
    convertVehicleLocationToLatLng(location, vehicleId) {
      let self = this;
      let locationData = location.field_streetname[0].value + ',' +
                     location.field_postal[0].value + ',' +
                     location.field_city[0].value + ',' +
                     location.field_country[0].value;
      axios({
        method: 'get',
        baseURL: 'https://maps.googleapis.com/maps/api/geocode/',
        url: 'json?address=' + locationData + '&key=' + self.$parent.GoogleApiKey,
      }).then(response => {
        //self.user.field_location["LatLng"] = response.data.results[0].geometry.location
        for(let i = 0; i < self.vehicles.length; i++) {
          if(self.vehicles[i].id[0].value == vehicleId) {
            self.vehicles[i].field_location["LatLng"] = response.data.results[0].geometry.location;
            self.vehicles[i].field_location["DistanceFromUser"] = Math.round(self.getDistanceFromLatLonInKm(self.user.field_location.LatLng.lat, self.user.field_location.LatLng.lng, self.vehicles[i].field_location.LatLng.lat, self.vehicles[i].field_location.LatLng.lng ));
          }
        }
        
      })
    },
    getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
      var R = 6371; // Radius of the earth in km
      var dLat = this.deg2rad(lat2-lat1);  // deg2rad below
      var dLon = this.deg2rad(lon2-lon1); 
      var a = 
      Math.sin(dLat/2) * Math.sin(dLat/2) +
      Math.cos(this.deg2rad(lat1)) * Math.cos(this.deg2rad(lat2)) * 
      Math.sin(dLon/2) * Math.sin(dLon/2); 
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
      var d = R * c; // Distance in km
      return d;
    },
    deg2rad(deg) {
        return deg * (Math.PI/180)
    },
    checkIfUserLogin() {
      if(localStorage.getItem('Track-User')) {
        this.$parent._data.user = JSON.parse(localStorage.getItem('Track-User'));
      } else {
        this.$router.go('/');
      }
    }
  },
  computed: {
    filterByName() {
      return this.vehicles.filter( vehicle => {
        if(this.selectedBrandFilter == 0) {
          return vehicle.name[0].value.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
        } else {
          return vehicle.name[0].value.toLowerCase().indexOf(this.search.toLowerCase()) > -1 && vehicle.field_brand[0].target_id == this.selectedBrandFilter;
        }
      })
    }
  },
  created () {
    this.checkIfUserLogin();
    this.getUser(this.$parent.user.current_user.uid);
    this.loadVehicles();
    this.getAllBrands();
  }
}
</script>
