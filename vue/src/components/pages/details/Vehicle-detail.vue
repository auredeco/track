<template>
  <div class="block">
    <h1>{{ vehicle.name[0].value }}</h1>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'VehicleDetail',
  data () {
    return {
      vehicle: []
    }
  },

  methods: {
      getVehicleById(id) {
        let self = this;
        let uri = this.$parent.uri;

        axios
        .get( uri + 'track/vehicle/' + id + '?_format=hal_json')
        .then(response => {
        // JSON responses are automatically parsed.
        self.vehicle = response.data;
        })
        .catch(e => {
        this.errors.push(e)
        })
    }
  },
  created () {
      this.getVehicleById(this.$route.params.id)
  }
}
</script>
