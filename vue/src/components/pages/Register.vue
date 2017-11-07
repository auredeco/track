<template>
  <div class="register">
    <h1>{{ title }}</h1>
    <form action="POST">
      <div class="input-field">
          <figure>
              <i class="fa fa-align-left" aria-hidden="true"></i>
          </figure>
          <input type="text" name="firstname" placeholder="First name" v-model="firstname">
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-align-left" aria-hidden="true"></i>
          </figure>
          <input type="text" name="firstname" placeholder="Last name" v-model="lastname">
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-envelope" aria-hidden="true"></i>
          </figure>
          <input type="text" name="firstname" placeholder="Email" v-model="email">
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-lock" aria-hidden="true"></i>                            
          </figure>
          <input type="password" name="firstname" placeholder="Password" v-model="password">
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-lock" aria-hidden="true"></i>                            
          </figure>
          <input type="password" name="firstname" placeholder="Password confirm" v-model="password_confirm">
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
      password_confirm: ''
    }
  },
  methods: {
      
  }
}
</script>
