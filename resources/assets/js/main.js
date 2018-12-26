
import Echo from 'laravel-echo'

window.io = require('socket.io-client');
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: '192.168.100.150:6001'
}); 



import Vue from "vue";
import VueRouter from "vue-router";
import DashboardPlugin from "./material-dashboard";
import store from './store';  

import axios from 'axios'
import VueAxios from 'vue-axios'

import VueScrollTo from 'vue-scrollto'

Vue.use(VueScrollTo)
 
Vue.use(VueAxios, axios)



// Plugins
import App from "./App.vue";
import Chartist from "chartist";

// router setup
import routes from "./routes/routes";

// plugin setup
Vue.use(VueRouter);
Vue.use(DashboardPlugin);



// configure router
const router = new VueRouter({
  routes, // short for routes: routes
  linkExactActiveClass: "nav-item active",
  scrollBehavior: () => {
   
      return { x: 0, y: 0 }
    }
  
});

import vueScrollBehavior from 'vue-scroll-behavior'
 
Vue.use(vueScrollBehavior, { router: router })

// global library setup
Object.defineProperty(Vue.prototype, "$Chartist", {
  get() {
    return this.$root.Chartist;
  }
});

/* eslint-disable no-new */
new Vue({
  el: "#app",
   store,
  render: h => h(App),
  router,
  data: {
    Chartist: Chartist
  }
});
