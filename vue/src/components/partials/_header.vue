<template>

    <header id="header">

      <figure class="back">
      
       <a href="javascript:history.go(-1)"> <i class="fa fa-arrow-left fa-2x" aria-hidden="true"></i></a>
      
      </figure>

          <p class="title">{{ $route.name }}</p>
        

        <figure id="hamburger" v-on:click="openNav">

            <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
        
        </figure>

    </header>

</template>

<script>
export default {
  name: 'vueheader',
  data () {
    return {
      currentPage: null
    }
  },
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

<style>
.back {
    padding: 0;
    margin: 0 0 0 1rem;
    flex: 1;
    z-index: 999;
}

.title {
  text-align: center;
  text-transform: uppercase;
}
</style>