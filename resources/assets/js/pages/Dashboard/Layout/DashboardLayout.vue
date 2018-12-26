<template>
  <div class="wrapper" :class="[{'nav-open': $sidebar.showSidebar}]">
    <notifications></notifications>
    <side-bar>
      <mobile-menu></mobile-menu>
      <template slot="links">
        <sidebar-item
          :link="{name: 'Escritorio', icon: 'fas fa-tachometer-alt', path: '/escritorio'}"
        ></sidebar-item>
        <sidebar-item :link="{name: 'Acceso', icon: 'fas fa-users'}">
          <sidebar-item :link="{name: 'Usuarios', path: '/acceso/usuarios'}"></sidebar-item>
          <sidebar-item :link="{name: 'Roles', path: '/acceso/roles'}"></sidebar-item>
        </sidebar-item>
        <sidebar-item :link="{name: 'Reportes', icon: 'fas fa-chart-pie'}">
          <sidebar-item :link="{name: 'Pacientes', path: '/reportes/pacientes'}"></sidebar-item>
          <sidebar-item :link="{name: 'Usuarios', path: '/reportes/usuarios'}"></sidebar-item>
        </sidebar-item>
        <sidebar-item :link="{name: 'Catalogos', icon: 'fas fa-clipboard-list'}">
          <sidebar-item :link="{name: 'Categorias', path: '/catalogo/categorias'}"></sidebar-item>
          <sidebar-item :link="{name: 'Productos', path: '/catalogo/productos'}"></sidebar-item>
          <sidebar-item :link="{name: 'Clasificación', icon: 'fas fa-project-diagram'}">
            <sidebar-item :link="{name: 'Grupo', path: '/catalogo/clasificacion/grupo'}"></sidebar-item>
            <sidebar-item
              :link="{name: 'Cuadro Basico', path: '/catalogo/clasificacion/cuadro-basico'}"
            ></sidebar-item>
          </sidebar-item>
        </sidebar-item>
        <sidebar-item :link="{name: 'Atención medica', icon: 'fas fa-user-md'}">
          <sidebar-item :link="{name: 'Certificados', path: '/atencion-general/certificados'}"></sidebar-item>
          <sidebar-item :link="{name: 'Pacientes', path: '/atencion-general/pacientes'}"></sidebar-item>
          <sidebar-item
            :link="{name: 'Recetas Electronicas', path: '/atencion-general/recetas-electronicas'}"
          ></sidebar-item>
        </sidebar-item>
        <sidebar-item :link="{name: 'Ayuda', icon: 'fas fa-question-circle', path: '/ayuda'}"></sidebar-item>
        <sidebar-item :link="{name: 'Acerca de', icon: 'fas fa-info-circle', path: '/info-app'}"></sidebar-item>
      </template>
    </side-bar>
    <div class="main-panel">
      <top-navbar></top-navbar>

      <div :class="{content: !$route.meta.hideContent}" @click="toggleSidebar">
        <modal v-if="modalOffline">
          <template slot="header">
            <md-button
              class="md-simple md-just-icon md-round modal-default-button"
              @click="modalOffline = false"
            >
              <md-icon>clear</md-icon>
            </md-button>
          </template>

          <template slot="body">
            <center>
              <p style="color:red">Hemos perdido la conexión a internet</p>
              <h3 style="margin-top:-15px">¿Deseas activar el modo offline?</h3>

              <small>
                <strong>Recuerda: </strong> En modo offline se desactivan algunas funciones<br>
                 <strong> Nota:   </strong>Tus movimientos / registros se cargaran al conectarte a internet<br>

              </small>
            </center>
          </template>

          <template slot="footer">
            <md-button class="md-simple" @click="modalOffline = false">NO</md-button>
            <md-button class="md-success md-simple" @click="$store.state.Aplicacion.Estado.ModoOffline = true;modalOffline = false">SI</md-button>
          </template>
        </modal>
        <zoom-center-transition :duration="200" mode="out-in">
          <router-view></router-view>
        </zoom-center-transition>
      </div>
      <content-footer v-if="!$route.meta.hideFooter"></content-footer>
    </div>
  </div>
</template>
<script>
/* eslint-disable no-new */
import PerfectScrollbar from "perfect-scrollbar";
import "perfect-scrollbar/css/perfect-scrollbar.css";
import store from "../../../store/";

function hasElement(className) {
  return document.getElementsByClassName(className).length > 0;
}

function initScrollbar(className) {
  if (hasElement(className)) {
    new PerfectScrollbar(`.${className}`);
  } else {
    // try to init it later in case this component is loaded async
    setTimeout(() => {
      initScrollbar(className);
    }, 100);
  }
}

import TopNavbar from "./TopNavbar.vue";
import ContentFooter from "./ContentFooter.vue";
import MobileMenu from "./Extra/MobileMenu.vue";
import UserMenu from "./Extra/UserMenu.vue";
import { ZoomCenterTransition } from "vue2-transitions";
import { Modal } from "@/components";

export default {
  data() {
    return {
      modalOffline: false
    };
  },
  components: {
    TopNavbar,
    ContentFooter,
    MobileMenu,
    UserMenu,
    ZoomCenterTransition,
    Modal
  },
  methods: {
    toggleSidebar() {
      if (this.$sidebar.showSidebar) {
        this.$sidebar.displaySidebar(false);
      }
    }
  },
  mounted() {
    let docClasses = document.body.classList;
    let isWindows = navigator.platform.startsWith("Win");
    if (isWindows) {
      // if we are on windows OS we activate the perfectScrollbar function
      initScrollbar("sidebar");
      initScrollbar("sidebar-wrapper");
      initScrollbar("main-panel");

      docClasses.add("perfect-scrollbar-on");
    } else {
      docClasses.add("perfect-scrollbar-off");
    }
  },
  computed: {
    InternetStatus() {
      return this.$store.state.Aplicacion.Estado.Conexion;
    }
  },
  watch: {
    InternetStatus() {
      if (!store.state.Aplicacion.Estado.Conexion) {
        this.modalOffline = true;
      }else{
         this.modalOffline = false;
        store.state.Aplicacion.Estado.ModoOffline = false
      }
    }
  }
};
</script>
<style lang="scss">
$scaleSize: 0.95;
@keyframes zoomIn95 {
  from {
    opacity: 0;
    transform: scale3d($scaleSize, $scaleSize, $scaleSize);
  }
  to {
    opacity: 1;
  }
}
.main-panel .zoomIn {
  animation-name: zoomIn95;
}
@keyframes zoomOut95 {
  from {
    opacity: 1;
  }
  to {
    opacity: 0;
    transform: scale3d($scaleSize, $scaleSize, $scaleSize);
  }
}
.main-panel .zoomOut {
  animation-name: zoomOut95;
}
</style>
