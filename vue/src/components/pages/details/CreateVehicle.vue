<template>
  <div class="createvehicle" v-cloak>
    <h1>Create vehicle</h1>
    <form action="POST">
      <div class="input-field">
          <figure>
             <i class="fa fa-envelope" aria-hidden="true"></i>
          </figure>
          <input type="text" v-model="newVehicle.name" name="vehiclename" placeholder="Voertuig naam">
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-lock" aria-hidden="true"></i> 
          </figure>
          <textarea v-model="newVehicle.field_description" name="description" placeholder="Beschrijving">
          </textarea>
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-lock" aria-hidden="true"></i> 
          </figure>
          <select v-model="newVehicle.field_brand" name="brand">
            <option v-for="brand in brands" :value="brand.id">{{brand.name[0].value}}</option>
          </select>
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-lock" aria-hidden="true"></i> 
          </figure>
          <input type="text" v-model="newVehicle.field_price" name="price" placeholder="Prijs">
      </div>
      <h2>Beschikbare datums</h2>
      <div class="input-field">
        <p>Van:</p>
        <datepicker v-model="ava_dates.start" :disabled="state.disabled" placeholder="start date" format="dd MMM yyyy"></datepicker>
        <p>Tot:</p>
        <datepicker v-model="ava_dates.end" :disabled="state.disabled" placeholder="start date" format="dd MMM yyyy"></datepicker>
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
        field_owner: null
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
          ]
      }
      }).then(response => {
        console.log(response.data);
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
    }
  },
  mounted() {
    this.checkIfUserLogin();
    this.loadAllBrands();
  }
}
</script>
