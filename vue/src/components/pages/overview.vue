<template>
  <div class="block">
    <h1><span>{{ title }}</span></h1>
    <ul id="example-1">
      <li v-for="vehicle in vehicles">
        {{ vehicle.name[0].value }}
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
      console.log(response.data)
      self.vehicles = response.data
    })
    .catch(e => {
      this.errors.push(e)
    })
  }
}
</script>
