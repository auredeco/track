<template>
  <div class="block vehicle-detail-page" v-cloak>
    <div class="vehicle-image">
        <img v-if="vehicle" :src="vehicle.field_image[0].url" v-bind:alt="vehicle.field_image[0].alt">
    </div>
    <div v-if='vehicle' class="vehicle-details">
      <div class="vehicle-detail-header">
        <div class="owner">
          <i class="fa fa-user" aria-hidden="true"></i>
          <h1 v-if="owner" class="owner-name"> {{ owner.field_first_name[0].value }} {{ owner.field_last_name[0].value }}</h1>
        </div>
        <div class="price">
          <p>€{{ vehicle.field_price[0].value }}/dag</p>
        </div>
      </div>
      <div class="datepickers">
        <datepicker v-model="startdate" calendar-button=True :highlighted="state.highlighted" :disabled="state.disabled" placeholder="start date" calendar-button-icon="fa fa-calendar" format="dd MMM yyyy"></datepicker>
        <datepicker v-model="enddate" calendar-button=True :highlighted="state.highlighted" :disabled="state.disabled" placeholder="end date" calendar-button-icon="fa fa-calendar" format="dd MMM yyyy"></datepicker>
      </div>
      <form action="POST">
        <input type="submit" class="btn btn-orange" value="Boeken" @click.prevent="MakeBooking">
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Datepicker from 'vuejs-datepicker';
import moment from 'moment'
window.moment = moment;


export default {
  name: 'BookingPage',
  data () {
    return {
      vehicle: null,
      startdate: "",
      enddate: "",
      bookings: [],
      owner: null,
      state: {
        disabled: {
            to: new Date(),
            ranges: [],
        },
        highlighted: {
          dates: []
        }
      }
    }
  },
  components: {
    Datepicker
  },
  methods: {
      getVehicleById(id) {
        let self = this;
        let uri = this.$parent.uri;

        axios
        .get( uri + 'track/vehicle/' + id + '?_format=json')
        .then(response => {
          self.vehicle = response.data;
          let vehicleBookings = JSON.parse(JSON.stringify(response.data.field_bookings));
          for(let i = 0; i < vehicleBookings.length; i++) {
            self.getVehicleBookings(vehicleBookings[i].target_id);
          }
          self.getVehicleOwner(response.data.user_id[0].target_id);
          self.SetArrayOfHighlightedDates();
        })
        .catch(e => {
          //this.errors.push(e)
        });
        
    },
    getVehicleOwner(ownerId) {
      let self = this;
      axios({
        method: 'get',
        baseURL: 'http://cmsdev.localhost/',
        url: 'user/' + ownerId + '?_format=json',
      }).then(response => {
        self.owner = response.data;
      })
    },
    getVehicleBookings(vehicleId) {
      let self = this;
      axios({
        method: 'get',
        baseURL: 'http://cmsdev.localhost/',
        url: 'track/booking/' + vehicleId + '?_format=json',
      }).then(response => {
        self.bookings.push(response.data);
        this.SetArrayOfDisabledDates(response.data);
      })
      .catch( error =>{
      });
      
    },
    SetArrayOfDisabledDates(booking) {
      booking = booking || null;
      let self = this;
      let toDate = new Date(booking.field_end_date[0].value);
      let newRange = {
        from: new Date(booking.field_start_date[0].value),
        to: new Date(toDate.setDate(toDate.getDate() + 1))
      }
      this.state.disabled.ranges.push(newRange);
    },
    SetArrayOfHighlightedDates() {
      let self = this;
      for(let i = 0; i < this.vehicle.field_ava.length; i++) {
        let newDate = new Date(this.vehicle.field_ava[i].value);
        self.state.highlighted.dates.push(newDate);
      }
    },
    MakeBooking() {
    let storage = JSON.parse(localStorage.getItem("Track-User"));
    let self = this;
      axios({
        method: 'POST',
        baseURL: 'http://cmsdev.localhost/',
        url: 'entity/booking',
        data: {
          "name": {"value": storage.current_user.name + " books vehicle #" + self.vehicle.id[0].value },
          "field_booker":{"value": storage.current_user.uid},
          "field_end_date":{"value": self.customFormatter(self.enddate) + "T00:00:00"},
          "field_start_date":{"value":self.customFormatter(self.startdate)+ "T00:00:00"},
          "field_vehicle":{"value": self.vehicle.id[0].value}
        }
      }).then(response => {
        self.UpdateVehicleBookings(response.data);
        self.getBooker(response.data);
      })
      .catch( error =>{
        console.log(error.response);
      });
    },
    UpdateVehicleBookings(booking) {
      let vehicleId = booking.field_vehicle[0].target_id;
      let newBooking = {
        "target_id": booking.id[0].value,
        "target_type": "booking",
        "target_uuid": booking.uuid[0].value,
        "url": "/track/booking/" + booking.id[0].value
      }
      this.vehicle.field_bookings.push(newBooking);
      if(this.vehicle.changed || this.vehicle.changed || this.vehicle.field_comments)
      {
        delete this.vehicle.changed;
        delete this.vehicle.created;
        delete this.vehicle.field_comments;
      }
      let car = this.vehicle;

      axios({
        method: 'PATCH',
        baseURL: 'http://cmsdev.localhost/',
        url: 'track/vehicle/' + vehicleId + '?_format=json',
        data: car
      }).then(response => {
      }).catch( error => {
        console.log(error);
      })
    },
    getBooker(booking) {
      let self = this;
      let id = booking.field_booker[0].target_id;
      axios({
        method: 'GET',
        baseURL: 'http://cmsdev.localhost/',
        url: 'user/' + id + '?_format=json',
      }).then(response => {
        let user = response.data;
        self.UpdateUserBookings(user, booking);
      }).catch( error => {
        console.log(error);
      })
    },
    UpdateUserBookings(user, booking) {
      let userId = user.uid[0].value
      let newBooking = {
        "target_id": booking.id[0].value,
        "target_type": "booking",
        "target_uuid": booking.uuid[0].value,
        "url": "/track/booking/" + booking.id[0].value
      }
      user.field_user_bookings.push(newBooking);
      delete user.changed;
      delete user.created;

      axios({
        method: 'PATCH',
        baseURL: 'http://cmsdev.localhost/',
        url: 'user/' + userId + '?_format=json',
        data: user
      }).then(response => {
        self.$router.push('/home');
      }).catch( error => {
        console.log(error);
      })
    },
    customFormatter(date) {
      return moment(date).format('YYYY-MM-DD');
    }
  },
  mounted() {
      this.getVehicleById(this.$route.params.id);
  }
}
</script>

<style>
.btn-orange {
    background: #fac556;
    border: none;
    padding: 1rem;
    width: 100%;
    margin-top: 1rem;
}

.datepickers {
  margin-top: 1rem;
}

.vdp-datepicker {
    border: 1px solid lightgray;
    padding: 0.5rem;
    border-radius: 4px;
    margin: 0.5rem 0;
}
</style>