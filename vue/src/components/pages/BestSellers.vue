<template>
  <div class="block" v-cloak>
    <h1><span>{{ title }}</span></h1>
    <div v-for='user in users'>
      <router-link :to="{ name: 'Account', params: { id: user.uid[0].value }}">
        <p v-if="user.field_first_name != null">{{ user.field_first_name[0].value }} {{ user.field_last_name[0].value }} {{ user.field_rating }}</p>
      </router-link>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'BestSellers',
  data () {
    return {
      title: 'Top aanbieders',
      users: [],
    }
  },
  methods: {
    getBestSellers() {
      let self = this;
      axios({
        method: 'get',
        baseURL: 'http://cmsdev.localhost/',
        url: 'users',
      }).then(response => {
        self.users = response.data;
        this.calculateRating();
        self.users.sort(this.sortByRating);
        self.users = self.users.splice(0, 5);
      }).catch( error => {
        console.log(error);
      });   
    },
    calculateRating() {
      for(let i = 0; i < this.users.length; i++ ) {
        let user = this.users[i];
        let ratings = 0;
        if(user.field_rating.length > 0) {
          let iterations = 0;
          for(let j = 0; j < user.field_rating.length; j++) {
            ratings += user.field_rating[j].value
            iterations++
          }
          ratings = (ratings/iterations).toFixed(2);
          iterations = 0;
        }
        user.field_rating = ratings;
        this.users[i] = user
      }
    },
    sortByRating(a, b) {
      if (a.field_rating < b.field_rating)
        return 1;
      if (a.field_rating > b.field_rating)
        return -1;
      return 0;
    },
    RemoveClassFromBody() {
      document.body.className -= 'homepage'
    }
  },
  mounted() {
    this.RemoveClassFromBody();
    this.getBestSellers();
  }
}
</script>