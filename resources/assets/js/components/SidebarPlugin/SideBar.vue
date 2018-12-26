<template>
  <div
    class="sidebar"
    :data-color="activeColor"
    :data-image="backgroundImage"
    :data-background-color="backgroundColor"
    :style="sidebarStyle"
  >
    <div class="logo">
      <a href class="simple-text logo-mini" target="_blank">
        <!--  <div class="logo-img">
         <img :src="logo">
        </div>-->
      </a>
      <a href class="simple-text logo-normal" target="_blank">
        <template>{{title}}</template>
      </a>
      <div class="navbar-minimize">
        <md-button
          id="minimizeSidebar"
          class="md-round md-just-icon md-transparent"
          @click="minimizeSidebar"
        >
          <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
          <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
        </md-button>
      </div>
    </div>
    <div class="sidebar-wrapper" ref="sidebarScrollArea">
      <slot></slot>
      <md-list class="nav">
        <slot name="links">
          <sidebar-item v-for="(link, index) in sidebarLinks" :key="link.name + index" :link="link">
            <br>
            <sidebar-item
              v-for="(subLink, index) in link.children"
              :key="subLink.name + index"
              :link="subLink"
            ></sidebar-item>
          </sidebar-item>
        </slot>

        <div style="bottom:0px!important;padding:30px;margin-top: 140px;">
          <center>
            <div style="display:inline!important">
              <div
                id="circle"
                :class="[{'circle_online':store.state.Aplicacion.Estado.Conexion},{'circle_offline':!store.state.Aplicacion.Estado.Conexion}]"
              ></div>
              <div v-if="!showText">
                <span
                  v-if="store.state.Aplicacion.Estado.Conexion"
                  style="color:white;margin-left:-50px!important;margin-top:-5px!important"
                >Conectado</span>
                <span v-else style="color:white;margin-left:22px;margin-top:-3px">Sin conexión</span>
                <br>
                <span v-if="store.state.Aplicacion.Estado.ModoOffline" style="color:#6c6d6d"><small>Modo offline activado</small></span>
              </div>
            </div>
          </center>
        </div>
      </md-list>
    </div>
  </div>
</template>
<script>
import store from "../../store/";
import $ from "jquery";

export default {
  data() {
    return {
      store: store,
      showText: false
    };
  },
  name: "sidebar",
  props: {
    title: {
      type: String,
      default: "SISTEMA"
    },
    activeColor: {
      type: String,
      default: "green",
      validator: value => {
        let acceptedValues = [
          "",
          "primary",
          "azure",
          "green",
          "orange",
          "danger",
          "rose"
        ];
        return acceptedValues.indexOf(value) !== -1;
      }
    },
    backgroundImage: {
      type: String,
      default: "./img/sidebar-2.jpg"
    },
    backgroundColor: {
      type: String,
      default: "black",
      validator: value => {
        let acceptedValues = ["", "black", "white", "red"];
        return acceptedValues.indexOf(value) !== -1;
      }
    },
    logo: {
      type: String,
      default: "./img/vue-logo.png"
    },
    sidebarLinks: {
      type: Array,
      default: () => []
    },
    autoClose: {
      type: Boolean,
      default: true
    }
  },
  provide() {
    return {
      autoClose: this.autoClose
    };
  },
  methods: {
    minimizeSidebar() {
      if (this.$sidebar) {
        this.$sidebar.toggleMinimize();
        this.showText = $("body").hasClass("sidebar-mini");
      }
    }
  },
  computed: {
    sidebarStyle() {
      return {
        backgroundImage: `url(${this.backgroundImage})`
      };
    }
  },
  beforeDestroy() {
    if (this.$sidebar.showSidebar) {
      this.$sidebar.showSidebar = false;
    }
  }
};
</script>
<style>
@media (min-width: 992px) {
  .navbar-search-form-mobile,
  .nav-mobile-menu {
    display: none;
  }
}

#circle {
  width: 15px;
  height: 15px;
  -moz-border-radius: 50px;
  -webkit-border-radius: 50px;
  border-radius: 50px;
  position: absolute;
  margin-top: 3px;
}

.circle_online {
  background: #4caf50;
}

.circle_offline {
  background: red;
}
</style>
