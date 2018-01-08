<template>
  <div class="block">
    <h1><span>{{ title }}</span></h1>
    <router-link :to="{ name: 'overview'}" class="btn btn-orange">
        Overzicht voertuigen
    </router-link>
    <router-link :to="{ name: 'BestSellers'}" class="btn btn-orange">
        Top aanbieders
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
  },
  methods: {
    RemoveClassFromBody() {
      document.body.className -= 'homepage'
    }
  },
  mounted() {
    this.RemoveClassFromBody();
  }
}
</script>
