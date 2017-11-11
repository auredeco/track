<template>
  <div class="block">
    <h1><span>{{ title }}</span></h1>
    <ul id="example-1">
       <li v-for="vehicle in vehicles">
         <router-link :to="{ name: 'vehicle-detail', params: { id: vehicle.id[0].value }}">
          {{ vehicle.name[0].value }}
        </router-link>
      </li>    
    </ul>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'overview',
  data () {
    return {
      title: 'Overzicht voertuigen',
      vehicles: []
    }
  },
  created () {
    let self = this
    axios
    .get('http://cmsdev.localhost/vehicles')
    .then(response => {
      // JSON responses are automatically parsed.
      self.vehicles = response.data
    })
    .catch(e => {
      this.errors.push(e)
    })
  }
}
</script>
