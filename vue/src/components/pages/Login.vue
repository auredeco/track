<template>
  <div class="login">
    <h1>{{ msg }}</h1>
    <form action="">
      <div class="input-field">
          <figure>
              <i class="fa fa-align-left" aria-hidden="true"></i>
          </figure>
          <input type="text" name="firstname" placeholder="First name">
      </div>
      <div class="input-field">
          <figure>
              <i class="fa fa-align-left" aria-hidden="true"></i>
          </figure>
          <input type="text" name="firstname" placeholder="Last name">
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