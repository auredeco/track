<template v-cloak>
<div>
  <h1>Pas uw voertuig aan</h1>
  <form v-if="vehicle" action="POST">
      <div class="input-field">
          <figure>
             <i class="fa fa-car" aria-hidden="true"></i>
          </figure>
          <input type="text" v-model="vehicle.name[0].value" name="vehiclename" placeholder="Voertuig naam">
      </div>
      <div class="select-wrapper">
        <i class="fa fa-users" aria-hidden="true"></i>
        <select v-model="vehicle.field_seats[0].value" name="seats" id="seats">
          <option value="0" disabled>Zitplaatsen</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
        </select>
        <i class="fa fa-caret-down" aria-hidden="true"></i>
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-align-left" aria-hidden="true"></i>
          </figure>
          <textarea v-model="vehicle.field_description[0].value" name="description" placeholder="Beschrijving">
          </textarea>
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-eur" aria-hidden="true"></i> 
          </figure>
          <input type="text" v-model="vehicle.field_price[0].value" name="price" placeholder="Prijs">
      </div>
      <div class="button-field">
       <input type="submit" class="btn btn-orange" value="Aanpassen" @click.prevent="updateVehicle">
      </div>
    </form>
</div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'UpdateVehicle',
  data () {
    return {
      vehicle: null
    }
  },
  methods: {
    getVehicleById(id) {
        let self = this;
        let uri = this.$parent.uri;

        axios
        .get( uri + 'track/vehicle/' + id + '?_format=json')
        .then(response => {
          self.vehicle = response.data;
          //console.log(response.data);
        })
        .catch(e => {
          //this.errors.push(e)
        });
    },
    updateVehicle() {
      let self = this;
      let updatedVehicle = this.vehicle;
      let vehicleId = updatedVehicle.id[0].value;
      console.log(updatedVehicle);
      if(this.vehicle.changed || this.vehicle.changed)
      {
        delete updatedVehicle.changed;
        delete updatedVehicle.created;
      }
      axios({
        method: 'PATCH',
        baseURL: 'http://cmsdev.localhost/',
        url: 'track/vehicle/' + vehicleId + '?_format=json',
        data: updatedVehicle
      }).then(response => {
        console.log(response.data);
        this.$router.push('/Profile')
      }).catch( error => {
        console.log(error);
      })
    }
  },
  mounted() {
    this.getVehicleById(this.$route.params.id);
  }
}
</script>

<style>
[v-cloak] {
  display: none;
}

.select-wrapper {
    border: 1px solid lightgray !important;
    padding: 0.5rem;
    border-radius: 4px;
    margin: 1.5rem 0 0 0;
    display: flex;
}

.select-wrapper .fa-users{
  align-self: center;
  border-right: 2px solid #2D2D2D;
  padding: 0.3rem;
  padding-right: 0.7rem;
}

.fa-caret-down {
  align-self: center;
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
</style>