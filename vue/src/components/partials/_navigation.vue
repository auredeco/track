<template>

    <nav id="main-nav">

        <h1><span>Navigatie</span></h1>
        
        <ul>
        
            <li>
                <router-link :to="{ name: 'overview'}">
                    <i class="fa fa-list" aria-hidden="true"></i>Overzicht voertuigen
                </router-link>
            </li>
        
            <li><router-link :to="{ name: 'BestSellers'}">
                    <i class="fa fa-arrow-up" aria-hidden="true"></i>Top aanbieders
                </router-link>
            </li>
        
            <li>
                <router-link :to="{ name: 'Profile'}">
                    <i class="fa fa-user" aria-hidden="true"></i>Mijn profiel
                </router-link>
            </li>

            <li>
                <router-link :to="{ name: 'Mijn boekingen'}">
                   <i class="fa fa-book" aria-hidden="true"></i>Mijn boekingen
                </router-link>
            </li>
        
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
          
      },
      closeNav() {
        const nav = document.getElementById('main-nav')
        nav.onclick = function () {
            nav.classList.toggle('nav-open')
        }
      }
  },
  mounted () {
      this.closeNav();
  }
}
</script>