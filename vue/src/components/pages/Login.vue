<template>
  <div class="login">
    <h1>{{ msg }}</h1>
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
      pass: ''
    }
  },
  methods: {
    loginUser() {
      let self = this;
      let format = '?_format=hal_json'
      axios.post( 'http://cmsdev.localhost/user/login' + format, {
          "_links": {
          "type": {
            "href": "http://cmsdev.localhost/rest/type/user/user"
          }
        },
        "name": self.mail,
        "pass": self.pass
      }).then( response => {
        let user = response.data;
        self.getUserById(user.current_user.uid);
        self.$router.push('home');
      });
    },
    getUserById(id) {
      let self = this;
      let format = '?_format=hal_json';
      axios.get( 'http://cmsdev.localhost/user/' + id + format)
      .then( response => {
        console.log(response.data);
        self.$parent.user = response.data;
      })
    }
  }
}
</script>

<style>
.button-field {
  margin-top: 2rem;
}
</style>