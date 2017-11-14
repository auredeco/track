<template>
  <div id="app">
    <vueheader></vueheader>
    <vuenav></vuenav>
    <main class="container">
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
import vueheader from './components/partials/_header.vue'
import vuenav from './components/partials/_navigation.vue'

export default {
  name: 'app',
  data() {
    return {
      'uri' : 'http://cmsdev.localhost/',
      'headers': {
        "Accept" : "application/hal+json",
        "Content-Type": "application/hal+json"
      },
      'user': null
    }
  },
  components: {
    'vueheader': vueheader,
    'vuenav': vuenav
  }
}
</script>
