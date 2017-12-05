<template>
  <div class="register">
    <h1>{{ title }}</h1>
    <form action="POST" @submit.prevent="validateForm()">
      <div class="input-field">
          <figure>
              <i class="fa fa-align-left" aria-hidden="true"></i>
          </figure>
          <input type="text" name="firstname" placeholder="First name" v-model="firstname" v-validate="'required'">
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-align-left" aria-hidden="true"></i>
          </figure>
          <input type="text" name="lastname" placeholder="Last name" v-model="lastname" v-validate="'required'">
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-envelope" aria-hidden="true"></i>
          </figure>
          <input type="text" name="email" placeholder="Email" v-model="email" v-validate="'required|email'">
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-lock" aria-hidden="true"></i>                            
          </figure>
          <input type="password" name="password" placeholder="Password" v-validate="'required'" v-model="password">
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-lock" aria-hidden="true"></i>                            
          </figure>
          <input type="password" name="password_confirm" placeholder="Password confirm" v-validate="'required|confirmed:password'">
      </div>
      <div class="button-field">
        <router-link :to="{ name: 'login'}" class="btn btn-white warning">
            Cancel
        </router-link>
        <input type="submit" class="btn btn-orange" value="registreren">
      </div>
  </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'register',
  data () {
    return {
      title: 'Register',
      firstname: '',
      lastname: '',
      username: '',
      email: '',
      password: '',
      self: this
    }
  },
  methods: {
      validateForm() {
          let self = this;
        this.$validator
        .validateAll()
        .then(response => {
          // Validation success if response === true
          if(response) {
             self.registerUser()
          } else {
              console.warn(response)
          }
          
        })
        .catch(function(e) {
          
        })
    },
    registerUser () {
        let self = this;
        let uri = this.$parent.uri;
        let headers = this.$parent.headers;
        console.log("registering user...");
        axios.post('http://cmsdev.localhost/user/register?_format=hal_json', {
            /*"_links": {
                "type": {
                    "href": "http://cmsdev.localhost/rest/type/user/user"
                }
            },*/
            "name":[{"value": self.email }],
            "mail":[{"value": self.email}],
            "pass":[{"value": self.password}],
            "field_first_name": [{"value": self.firstname}],
            "field_last_name": [{"value": self.lastname}]
        }, headers) 
        .then(response => {
            self.$router.push('home')
        })
        .catch(function (error) {
            console.log(error);
        });
    }
  }
}
</script>
