<template>
  <div class="bookingpage" v-cloak>
    <h1>Booking</h1>
    <datepicker v-model="startdate" calendar-button=True :highlighted="state.highlighted" :disabled="state.disabled" placeholder="start date" calendar-button-icon="fa fa-calendar" format="dd MMM yyyy"></datepicker>
    <datepicker v-model="enddate" calendar-button=True :highlighted="state.highlighted" :disabled="state.disabled" placeholder="end date" calendar-button-icon="fa fa-calendar" format="dd MMM yyyy"></datepicker>
    <form action="POST">
      <input type="submit" class="btn btn-orange" value="Boeken" @click.prevent="MakeBooking">
    </form>
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
          self.SetArrayOfHighlightedDates();
        })
        .catch(e => {
          //this.errors.push(e)
        });
        
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
        //self.$router.push('booking/succes');
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
      console.log(JSON.stringify(this.vehicle));
      let car = this.vehicle;

      axios({
        method: 'PATCH',
        baseURL: 'http://cmsdev.localhost/',
        url: 'track/vehicle/' + vehicleId + '?_format=json',
        data: car
      }).then(response => {
        console.log(response.data);
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
