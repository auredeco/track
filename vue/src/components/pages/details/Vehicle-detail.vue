<template>
  <div class="block" v-cloak>
    <h1 v-if='vehicle'>{{ vehicle.name[0].value }}</h1>
    <img v-if="vehicle" :src="vehicle.field_image[0].url" v-bind:alt="vehicle.field_image[0].alt">
    <p v-if="owner">{{ owner.name[0].value }}</p>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'VehicleDetail',
  data () {
    return {
      vehicle: null,
      owner: null
    }
  },

  methods: {
      getVehicleById(id) {
        let self = this;
        let uri = this.$parent.uri;

        axios
        .get( uri + 'track/vehicle/' + id + '?_format=json')
        .then(response => {
          // JSON responses are automatically parsed.
          self.vehicle = response.data;
          //this.getVehicleOwner();
        })
        .catch(e => {
          this.errors.push(e)
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
    }
  },
  mounted () {
      this.getVehicleById(this.$route.params.id);
  }
}
</script>
