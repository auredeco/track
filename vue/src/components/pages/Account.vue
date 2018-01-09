<template>
  <div class="profile">
    <h1>Profile</h1>
    <div v-if="user" class="profile-data">
      <div class="profile-picture">
        <img :src="user.user_picture[0].url" alt="">
      </div>
      <div class="user-info">
        <h3>{{ user.field_first_name[0].value }} {{ user.field_last_name[0].value }}</h3>
        <div v-if="userVehicles.length > 0" class="vehicles">
          <h3>{{ user.field_first_name[0].value }}'s Vehicles</h3>
          <div v-if="userVehicles.length > 0" v-for="vehicle in userVehicles" class="vehicle">
            <p>{{ vehicle.name[0].value }}</p>
            <router-link :to="{ name: 'MyVehicleBookings', params: { id: vehicle.id[0].value }}">
              <p>Bekijk boekingen</p>
            </router-link>
          </div>
          <div v-if="!userVehicles" >
            <p>Geen voertuigen om weer te geven</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Account',
  data () {
    return {
      user: null,
      userVehicles: []
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
        if(response.data.field_vehicles.length > 0) {
          self.getUserVehicles();
        }
      }).catch( error => {
        console.log(error);
      });
    },
    getUserVehicles() {
      let self = this;
      for(let i = 0; i < this.user.field_vehicles.length; i++) {
        axios({
          method: 'get',
          baseURL: 'http://cmsdev.localhost',
          url: self.user.field_vehicles[i].url + "?_format=json"
        }).then(response => {
          self.userVehicles.push(response.data);
        }).catch( error => {
          console.log(error);
        });
      }
    },
    checkIfUserLogin() {
      if(localStorage.getItem('Track-User')) {
        this.$parent._data.user = JSON.parse(localStorage.getItem('Track-User'));
      }
    }
  },
  mounted () {
    this.checkIfUserLogin();
    this.getUserData(this.$route.params.id);
  }
}
</script>