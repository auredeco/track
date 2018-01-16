<template>
  <div class="home block">
    <div class="heading">
      <img class="bg-image" :src="require('@/assets/img/heading.jpg')" alt="">
      <img class="logo" :src="require('@/assets/img/logo.png')" alt="logo">
    </div>
    <div class="pages">
        <router-link :to="{ name: 'overview'}" class="page overview">
          <i class="fa fa-list fa-3x" aria-hidden="true"></i><br>
          Overzicht voertuigen
        </router-link>
        <router-link :to="{ name: 'BestSellers'}" class="page topsellers">
          <i class="fa fa-arrow-up fa-3x" aria-hidden="true"></i><br>
          Top aanbieders
        </router-link>
        <router-link :to="{ name: 'Profile'}" class="page profile-page">
            <i class="fa fa-user fa-3x" aria-hidden="true"></i><br>
            Mijn profiel
        </router-link>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'home',
  data () {
    return {
      title: 'Home',
      user: null,
      bookings: null
    }
  },
  methods: {
    RemoveClassFromBody() {
      document.body.className -= 'homepage'
    },
    checkIfUserLogin() {
      if(localStorage.getItem('Track-User')) {
        this.$parent.user = JSON.parse(localStorage.getItem('Track-User'));
      } else {
        this.$router.push('/');
      }
    }
  },
  mounted() {
    this.checkIfUserLogin();
    this.RemoveClassFromBody();
  }
}
</script>

<style>
.heading {
  position: fixed;
  top: 0;
  left: 0;
  z-index:99;
  max-height: 250px;
  overflow: hidden;
}

.heading .logo {
  position: absolute;
  top: 0;
  width: 80%;
  margin: 25px 10%;
}

.pages {
  position: fixed;
  top: 250px;
  left: 0;
  width: 100%;
}

.pages a {
  display: block;
  width: 100%;
  color: #2D2D2D;
  text-align: center;
  padding: 2.3rem;
}

.overview {
  background: #fac556
}

.profile-page {
  background: #2D2D2D;
  color: #FFF !important;
}
</style>
