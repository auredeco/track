<template>
  <div class="profile">
    <h3 v-if="user">{{ user.field_first_name[0].value }} {{ user.field_last_name[0].value }}</h3>
    <div v-if="user" class="profile-data">
      <div class="profile-picture">
        <img :src="user.user_picture[0].url" alt="">
      </div>
      <div class="user-info">
        <div class="sub-info">
          <div class="rating">
            <p><span>{{ rating }}</span><br>Gemiddelde score</p>
          </div>
          <div class="amountOfVehicles">
            <p><span>{{ userVehicles.length }}</span><br>Voertuigen</p>
          </div>
        </div>
        <div v-if="userVehicles.length > 0" class="vehicles">
          <h3><span>{{ user.field_first_name[0].value }}'s Vehicles</span></h3>
          <div v-for="vehicle in userVehicles" class="vehicle-block">
         <router-link :to="{ name: 'vehicle-detail', params: { id: vehicle.id[0].value }}">
          <img v-if="vehicle.field_image[0]" :src="vehicle.field_image[0].url" :alt="vehicle.field_image[0].alt">
          <div class="brand">
            <img v-if="vehicle.field_brand[1]" :src="vehicle.field_brand[1].field_logo[0].url" :alt="vehicle.field_brand[1].field_logo[0].alt">
          </div>
          <div class="vehicle-info">
            <h1 v-if="vehicle.name[0].value">{{vehicle.name[0].value}}</h1>
            <p v-if="vehicle.field_age[0].value">{{ vehicle.field_age[0].value }}</p>
            <p v-if="vehicle.field_conditions[0].value">{{ vehicle.field_conditions[0].value }}</p>
            <p v-if="vehicle.field_location.DistanceFromUser >= 0">{{ vehicle.field_location.DistanceFromUser }}km</p>
            <p v-if="vehicle.field_price[0].value">€{{ vehicle.field_price[0].value }}</p>
          </div>  
        </router-link>
        <router-link v-if="$parent.user.current_user.uid == user.uid[0].value" class="bookingRouter" :to="{ name: 'Voertuig boekingen', params: { id: vehicle.id[0].value }}">
          <p>Bekijk boekingen</p>
        </router-link>
        <router-link v-if="$parent.user.current_user.uid == user.uid[0].value" class="edit" :to="{ name: 'Voertuig aanpassen', params: { id: vehicle.id[0].value }}">
          <i class="fa fa-pencil" aria-hidden="true"></i>
        </router-link>
        </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Profile',
  data () {
    return {
      user: null,
      userVehicles: [],
      rating: 0,
      vehicles: 0,
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
        console.log(self.user);
        self.getUserStats();
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
          self.userVehicles.forEach(vehicle => {
            self.getBrand(vehicle);
          })
        }).catch( error => {
          console.log(error);
        });
      }
    },
    calculateRating() {
      let user = this.user;
      let ratings = 0;
      if(user.field_rating.length > 0) {
        let iterations = 0;
        for(let j = 0; j < user.field_rating.length; j++) {
          ratings += user.field_rating[j].value
          iterations++
        }
        ratings = (ratings/iterations).toFixed(2);
        iterations = 0;
      }
      this.rating = ratings;
    },
    getUserStats() {
      this.calculateRating();
    },
    getBrand(vehicle) {
      let self = this;
      let vehicleId = vehicle.id[0].value;
      let brandUrl = vehicle.field_brand[0].url;
      axios
      .get('http://cmsdev.localhost' + brandUrl + '?_format=json')
      .then(response => {
        self.userVehicles.forEach(vehicle => {
          if(vehicle.id[0].value == vehicleId) {
            vehicle.field_brand.push(response.data);
          }
        });
      })
      .catch(e => {
        console.log(e)
      })
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

<style>
.vehicles {
  margin-top: 2rem;
  margin-bottom: 2rem;
}

.vehicles h3 {
  margin-bottom: 2rem;
}

.profile-data {
  position: absolute;
  left: 0;
}
.vehicles {
  padding: 0 20px;
}
.rating {
  background: #fac556;
}
.amountOfVehicles {
  background:#F5D389;
}
.sub-info {
  display: flex;
  text-align: center;
  margin: -3px;
}
.sub-info div {
  flex: 1;
}
p span {
  font-size: 24px;
}
.vehicle-block {
  flex-wrap: wrap;
}

.bookingRouter {
  flex: 1;
  padding: 0 1rem;
  color: #FFF;
  background: #fac556;
}

.edit {
  flex: 1;
  align-self: center;
  text-align: right;
  padding: 0 1rem;
  color: #FFF;
  background: #fac556;
  padding: 16px;
}
</style>