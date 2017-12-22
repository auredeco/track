<template>

    <header id="header">
        
        <figure id="logo">

          <router-link :to="{ name: 'home'}">
         
              <img :src="require('@/assets/track.png')" alt="logo">
         
          </router-link>
        
        </figure>

        <figure id="hamburger" v-on:click="openNav">

            <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
        
        </figure>

    </header>

</template>

<script>
export default {
  name: 'vueheader',
  methods: {
    openNav () {
      const hamburger = document.getElementsByClassName('fa-bars')[0]
      const nav = document.getElementById('main-nav')
      hamburger.onclick = function () {
        nav.classList.toggle('nav-open')
      }
    }
  }
}
</script>
