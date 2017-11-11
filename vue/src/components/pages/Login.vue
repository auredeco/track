<template>
  <div class="login">
    <h1>{{ msg }}</h1>
    <form action="">
      <div class="input-field">
          <figure>
             <i class="fa fa-envelope" aria-hidden="true"></i>
          </figure>
          <input type="text" name="username" placeholder="Emailadress">
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-lock" aria-hidden="true"></i> 
          </figure>
          <input type="password" name="password" placeholder="Password">
      </div>
    </form>
    <div class="button-field">
      <router-link :to="{ name: 'register'}" class="btn btn-white">
          Register
      </router-link>
      <router-link :to="{ name: 'home'}" class="btn btn-orange">
          Login
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'login',
  data () {
    return {
      msg: 'Login'
    }
  }
}
</script>

<style>
.button-field {
  margin-top: 2rem;
}
</style>