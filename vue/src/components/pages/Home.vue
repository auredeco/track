<template>
  <div class="block">
    <h1><span>{{ title }}</span></h1>
    <router-link :to="{ name: 'overview'}" class="btn btn-orange">
        Overzicht voertuigen
    </router-link>
  </div>
</template>

<script>
export default {
  name: 'home',
  data () {
    return {
      title: 'Home'
    }
  }
}
</script>
