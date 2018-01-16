<template>
  <div class="login">
    <div class="logo">
      <img :src="require('@/assets/img/logo.png')" alt="logo">
    </div>
    <form action="POST">
      <div class="input-field">
          <figure>
             <i class="fa fa-envelope" aria-hidden="true"></i>
          </figure>
          <input type="text" name="username" placeholder="Emailadress" v-model="mail">
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-lock" aria-hidden="true"></i> 
          </figure>
          <input type="password" name="password" placeholder="Password" v-model="pass">
      </div>
    </form>
    <div class="button-field">
      <router-link :to="{ name: 'register'}" class="btn btn-white">
          Register
      </router-link>
      <input type="submit" class="btn btn-orange" value="Login" @click.prevent="loginUser">
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'login',
  data () {
    return {
      msg: 'Login',
      mail: '',
      pass: '',
    }
  },
  methods: {
    checkIfUserLogin() {
      if(localStorage.getItem('Track-User')) {
        this.$parent.user = JSON.parse(localStorage.getItem('Track-User'));
        this.$router.push('/home');
      }
    },
    loginUser() {
      let self = this;
      axios({
        method: 'post',
        baseURL: 'http://cmsdev.localhost/',
        url: 'user/login?_format=json',
        data: {
          name: self.mail,
          pass: self.pass
        }
      }).then(response => {
        localStorage.setItem('Track-User', JSON.stringify(response.data));
        self.$parent.user = response.data;
        self.$router.push('home');
      }).catch( error =>{
      });
    },
    AddClassToBody() {
      document.body.className = 'homepage'
    }
  },
  mounted () {
    document.getElementById('main-nav').classList.remove("nav-open");
    this.AddClassToBody();
    this.checkIfUserLogin();
  }
}
</script>

<style>
.button-field {
  margin-top: 2rem;
}

input {
  color: #FFF;
}

.button-field a {
  flex: 1;
}

.button-field input {
  flex: 1;
}
</style>