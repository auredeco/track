<template>
  <div class="createvehicle" v-cloak>
    <h1>Voertuig aanbieden</h1>
    <form action="POST">
      <div class="input-field">
          <figure>
             <i class="fa fa-car" aria-hidden="true"></i>
          </figure>
          <input type="text" v-model="newVehicle.name" name="vehiclename" placeholder="Voertuig naam">
      </div>
      <div class="select-wrapper">
        <select v-model="newVehicle.field_age" name="age" id="age">
          <option selected disabled value>Leeftijd</option>
        </select>
        <i aria-hidden="true" class="fa fa-caret-down"></i>
      </div>
      <div class="select-wrapper">
        <select v-model="newVehicle.field_seats" name="seats" id="seats">
          <option value selected disabled>Zitplaatsen</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
        </select>
        <i aria-hidden="true" class="fa fa-caret-down"></i>
      </div>
      <div class="select-wrapper">
        <select v-model="newVehicle.field_brand" name="brand">
          <option value disabled default>Kies uw merk</option>
          <option v-for="brand in brands" :value="brand.id">{{brand.name[0].value}}</option>
        </select>
        <i aria-hidden="true" class="fa fa-caret-down"></i>
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-align-left" aria-hidden="true"></i>
          </figure>
          <textarea v-model="newVehicle.field_description" name="description" placeholder="Beschrijving">
          </textarea>
      </div>
        <div class="input-field">
          <figure>
              <i class="fa fa-eur" aria-hidden="true"></i>
          </figure>
          <input type="text" v-model="newVehicle.field_price" name="price" placeholder="Prijs">
      </div>
      <div class="select-field" id="conditions">
        <div class="license">
          <h3>Rijbewijs</h3>
          <input type="radio" name="license" value="Rijbewijs A" v-model="newVehicle.license"> Rijbewijs A<br>
          <input type="radio" name="license" value="Rijbewijs B" v-model="newVehicle.license"> Rijbewijs B<br>
          <input type="radio" name="license" value="Rijbewijs C" v-model="newVehicle.license"> Rijbewijs C<br>
          <input type="radio" name="license" value="Rijbewijs D" v-model="newVehicle.license"> Rijbewijs D<br>
          <input type="radio" name="license" value="Rijbewijs G" v-model="newVehicle.license"> Rijbewijs G<br>
        </div>
        <h3>Voorwaarden</h3>
        <div>
          <input type="checkbox" id="Rookvrij" name="condition" value="Rookvrij" v-model="newVehicle.conditions">
          <label for="Rookvrij">Rookvrij</label>
        </div>
        <div>
          <input type="checkbox" id="Opgeladen" name="condition" value="Batterij opgeladen terug bezorgen" v-model="newVehicle.conditions">
          <label for="Opgeladen">Batterij opgeladen terug bezorgen</label>
        </div>
      </div>
      <h3>Beschikbare datums</h3>
      <div class="input-field">
        <p>Van:</p>
        <datepicker v-model="ava_dates.start" :disabled="state.disabled" placeholder="Start datum" format="dd MMM yyyy"></datepicker>
        <p>Tot:</p>
        <datepicker v-model="ava_dates.end" :disabled="state.disabled" placeholder="Eind datum" format="dd MMM yyyy"></datepicker>
      </div>
      <div class="button-field">
       <input type="submit" class="btn btn-orange" value="Registreer voertuig" @click.prevent="createVehicle">
      </div>
    </form>
  </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
import axios from 'axios';
import moment from 'moment'
window.moment = moment;

export default {
  name: 'CreateVehicle',
  data () {
    return {
      brands: [],
      user: null,
      ava_dates: {
        start: null,
        end: null
      },
      newVehicle: {
        name: "",
        field_brand: null,
        field_description: "",
        field_price: null,
        field_ava: [],
        field_owner: null,
        field_age: null,
        field_seats: null,
        field_conditions: [],
        license: null
      },
      newLocation: {

      },
      state: {
        disabled: {
            to: new Date(),
            ranges: [],
        },
        highlighted: {
          dates: []
        }
      }
    }
  },
  components: {
    Datepicker
  },
  methods: {
    createVehicle() {
      let self = this;
      this.CreateArrayOfAvailableDates();
      let license = this.newVehicle.license;
      let conditions = [
        {
          "value": license
        }
      ];
      for(let i = 0; i <= this.newVehicle.field_conditions.length; i++) {
        let condition = {
          "value": this.newVehicle.field_conditions[i]
        }
        conditions.push(condition);
      }
      axios({
        method: 'post',
        baseURL: 'http://cmsdev.localhost/',
        url: 'entity/vehicle',
        data: {
          "name": [
              {
                  "value": self.newVehicle.name
              }
          ],
          "field_ava": self.newVehicle.field_ava,
          "user_id": [
            {
              "target_id": JSON.parse(localStorage.getItem('Track-User')).current_user.uid
            }
          ],
          "field_brand": [
              {
                  "target_id": self.newVehicle.field_brand[0].value
              }
          ],
          "field_description": [
              {
                  "value": self.newVehicle.field_description
              }
          ],
          "field_owner": [
              {
                  "target_id": self.$parent.user.current_user.uid
              }
          ],
          "field_price": [
              {
                  "value": self.newVehicle.field_price
              }
          ],
          "field_location": [
            {
              "target_id": self.user.field_location[0].target_id
            }
          ],
          "field_age": [
            {
              "value": self.newVehicle.field_age
            }
          ],
          "field_seats": [
            {
              "value": self.newVehicle.field_seats
            }
          ],
          "field_conditions": conditions
      }
      }).then(response => {
        console.log(response.data);
        this.$router.push("/home");
      }).catch( error => {
        console.log(error);
      });
    },
    loadAllBrands() {
      let self = this;
      axios({
        method: 'get',
        baseURL: 'http://cmsdev.localhost/',
        url: 'brands?_format=json',
      }).then(response => {
        self.brands = response.data;
      }).catch( error => {
      });
    },
    CreateArrayOfAvailableDates() {
      let dates = [];
      let startDate = new Date(this.ava_dates.start);
      let endDate = new Date(this.ava_dates.end);
      while(startDate <= endDate) {
        let newDate = {
          "value": this.customFormatter(startDate) + "T00:00:00"
        }
        dates.push(newDate);
        startDate.setDate(startDate.getDate() + 1);
      }
      this.newVehicle.field_ava = dates;
      //console.log(dates)
    },
    populateSelectList() {
      var start = 2000;
      var end = new Date().getFullYear();
      var options = "";
      for(var year = start ; year <=end; year++){
        options += "<option value="+ year +">"+ year +"</option>";
      }
      document.getElementById("age").innerHTML += options;
    },
    getUser() {
      let self = this;
      axios({
        method: 'get',
        baseURL: 'http://cmsdev.localhost/',
        url: 'user/' + JSON.parse(localStorage.getItem('Track-User')).current_user.uid + '?_format=json',
      }).then(response => {
        self.user = response.data;
      })
    },
    customFormatter(date) {
      return moment(date).format('YYYY-MM-DD');
    },
    checkIfUserLogin() {
      if(localStorage.getItem('Track-User')) {
        this.$parent._data.user = JSON.parse(localStorage.getItem('Track-User'));
        this.newVehicle.field_owner = { 
          target_id: JSON.parse(localStorage.getItem('Track-User')).current_user.uid
        }
      }
      this.getUser();
    }
  },
  mounted() {
    this.populateSelectList();
    this.checkIfUserLogin();
    this.loadAllBrands();
  }
}
</script>

<style>
.select-wrapper {
    border: 1px solid lightgray !important;
    padding: 0.5rem;
    border-radius: 4px;
    margin: 0.5rem 0;
}

.select-wrapper select {
  width: 95%;
}

textarea {
  width: 100%;
  padding:0.5rem;
  height: 100px;
  background: transparent;
  border: none;
}

.vdp-datepicker {
  margin-top: 9px;
}
</style>