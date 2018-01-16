<template>
  <div class="register">
    <h1>{{ title }}</h1>
    <form action="POST" @submit.prevent="validateForm()">
      <div class="input-field">
          <figure>
             <i class="fa fa-address-card" aria-hidden="true"></i>
          </figure>
          <input type="text" name="firstname" placeholder="First name" v-model="firstname" v-validate="'required'">
      </div>
      <div class="input-field">
          <figure>
             <i class="fa fa-address-card-o" aria-hidden="true"></i>
          </figure>
          <input type="text" name="lastname" placeholder="Last name" v-model="lastname" v-validate="'required'">
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-home" aria-hidden="true"></i>
          </figure>
          <input type="text" name="streetname" placeholder="Straatnaam" v-model="streetname" v-validate="'required'">
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-align-left" aria-hidden="true"></i>
          </figure>
          <input type="text" name="number" placeholder="Nummer" v-model="number" v-validate="'required'">
      </div>
       <div class="input-field">
          <figure>
              <i class="fa fa-building" aria-hidden="true"></i>
          </figure>
          <input type="text" name="city" placeholder="Stad" v-model="city" v-validate="'required'">
      </div>
       <div class="input-field">
          <figure>
              <i class="fa fa-building-o" aria-hidden="true"></i>
          </figure>
          <input type="text" name="postal" placeholder="Postcode" v-model="postal" v-validate="'required'">
      </div>
       <div class="input-field">
          <figure>
              <i class="fa fa-flag" aria-hidden="true"></i>
          </figure>
          <input type="text" name="country" placeholder="Land" v-model="country" v-validate="'required'">
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
      streetname: '',
      number: '',
      city: '',
      postal: '',
      country: ''
    }
  },
  methods: {
        removeClassFromBody() {
            document.body.className -= 'homepage'
        },
      validateForm() {
        let self = this;
        this.$validator
        .validateAll()
        .then(response => {
          // Validation success if response === true
          if(response) {
             self.createLocation()
          } else {
              console.warn(response)
          }
          
        })
        .catch(function(e) {
          
        })
    },
    registerUser (location) {
        let self = this;
        console.log(location);
        axios({
            method: 'POST',
            baseURL: 'http://cmsdev.localhost/',
            url: 'user/register?_format=hal_json',
            data: {
                "name": [
                    {
                        "value": self.email
                    }
                ],
                "mail": [
                    {
                        "value": self.email
                    }
                ],
                "field_first_name": [
                    {
                        "value": self.firstname
                    }
                ],
                "field_last_name": [
                    {
                        "value": self.lastname
                    }
                ],
                "field_location": [
                    {
                        "target_id": location.id[0].value
                    }
                ]
            }
        }).then(response => {
            self.$router.push('/');
        }).catch( error => {
            console.log(error);
        });
    },
    createLocation() {
    let self = this;
    axios({
        method: 'POST',
        baseURL: 'http://cmsdev.localhost/',
        url: 'entity/location?_format=json',
        data: {
            "name": [
                {
                    "value": self.firstname + " " + self.lastname + "'s address"
                }
            ],
            "field_city": [
                {
                    "value": self.city
                }
            ],
            "field_country": [
                {
                    "value": self.country
                }
            ],
            "field_number": [
                {
                    "value": self.number
                }
            ],
            "field_postal": [
                {
                    "value": self.postal
                }
            ],
            "field_streetname": [
                {
                    "value": self.streetname
                }
            ]
        }
    }).then(response => {
       self.registerUser(response.data);
    }).catch( error => {
        console.log(error);
    });
  }
  },
  mounted() {
      this.removeClassFromBody();
  }
}
</script>

<style>
.button-field {
    margin-bottom: 1rem;
}
</style>