<template>

    <nav id="main-nav">

        <h1><span>Navigatie</span></h1>
        
        <ul>
        
            <li><i class="fa fa-list" aria-hidden="true"></i>Overzicht voertuigen</li>
        
            <li><i class="fa fa-shopping-cart" aria-hidden="true"></i>Aanbiedingen</li>
        
            <li><i class="fa fa-arrow-up" aria-hidden="true"></i>Top Aanbieders</li>
        
            <li><i class="fa fa-user" aria-hidden="true"></i>Mijn profiel</li>
        
            <li v-on:click="logoutTrackUser"><i class="fa fa-power-off" aria-hidden="true"></i>Uitloggen</li>
        
        </ul>
    
    </nav>

</template>

<script>
export default {
  name: 'vuenav',
  methods: {
      logoutTrackUser() {
          this.$parent.user = null;
          localStorage.removeItem('Track-User');
          this.$router.push('/');
          document.getElementById('main-nav').classList.remove("nav-open");
      }
  }
}
</script>