<template>
  <div>
    <router-view></router-view>
  </div>
</template>

<script>
import $ from "jquery";
export default {
  data() {
    return {};
  },
  created() {
    this.internetStatus();
  },
  mounted() {
    var ths = this;
    window.Echo.channel("update").listen("Actualizacion", e => {
      ths.eventoActualizacion(e);
    });
  },
  methods: {
    internetStatus() {
      var ths = this;
      setInterval(() => {
        if (Offline.state == "down") {
          ths.$store.state.Aplicacion.Estado.Conexion = false;
        } else if (Offline.state == "up") {
          ths.$store.state.Aplicacion.Estado.Conexion = true;
        }
      }, 2000);
    },
    eventoActualizacion(data) {
      var ths = this;
      var datos = data.datosActualizacion.data;
      var accion = data.datosActualizacion.task;
      var tipo = data.tipoActualizacion;
      tipo = tipo.split("_");
      if (tipo[0] == "update") {
        if (tipo[1] == "catalogos") {
          if (tipo[2] == "productos") {
            if (
              this.$store.state.Interface.Dinamico.Componentes.Catalogo
                .Productos.ProductosCargados
            ) {
              if (tipo[3] == "single") {
                if (accion == "Desactivar") {
                  $.each(
                    this.$store.state.Interface.Dinamico.Componentes.Catalogo
                      .Productos.ListaProductos,
                    function(index, item) {
                      if (item.CodigoDeBarras == datos) {
                        item.Estado = false;
                      }
                    }
                  );
                } else if (accion == "Activar") {
                  $.each(
                    this.$store.state.Interface.Dinamico.Componentes.Catalogo
                      .Productos.ListaProductos,
                    function(index, item) {
                      if (item.CodigoDeBarras == datos) {
                        item.Estado = true;
                      }
                    }
                  );
                } else if (accion == "update_single") {
                  $.each(
                    this.$store.state.Interface.Dinamico.Componentes.Catalogo
                      .Productos.ListaProductos,
                    function(index, item) {
                      if (item.id == undefined || item.id == null) {
                        var id = item.Id;
                      } else {
                        var id = item.id;
                      }
                      if (id == datos.Id) {
                        item.CodigoDeBarras = datos.CodigoDeBarras;
                        item.NombreComercial = datos.NombreComercial;
                        item.NombreGenerico = datos.NombreGenerico;
                        item.FormaFarmaucetica = datos.FormaFarmaucetica;
                        item.Presentacion = datos.Presentacion;
                        item.Contenido = datos.Contenido;
                        item.Comentarios = datos.Comentarios;
                      }
                    }
                  );
                }
              } else if (tipo[3] == "multiple") {
                if (accion == "Desactivar_Multiple") {
                  $.each(datos, function(index, item) {
                    $.each(
                      ths.$store.state.Interface.Dinamico.Componentes.Catalogo
                        .Productos.ListaProductos,
                      function(index2, item2) {
                        if (item2.CodigoDeBarras == item) {
                          item2.Estado = false;
                        }
                      }
                    );
                  });
                } else if (accion == "Activar_Multiple") {
                  $.each(datos, function(index, item) {
                    $.each(
                      ths.$store.state.Interface.Dinamico.Componentes.Catalogo
                        .Productos.ListaProductos,
                      function(index2, item2) {
                        if (item2.CodigoDeBarras == item) {
                          item2.Estado = true;
                        }
                      }
                    );
                  });
                }
              }
            }
          }
        }
      } else if (tipo[0] == "store") {
        if (tipo[1] == "catalogos") {
          if (tipo[2] == "productos") {
            if (
              this.$store.state.Interface.Dinamico.Componentes.Catalogo
                .Productos.ProductosCargados
            ) {
              if (tipo[3] == "single") {
                var preferencias = JSON.parse(
                  localStorage.getItem(
                    "__local__catalogosProductos__preferencias"
                  )
                );
                var OrdenarPor = preferencias.OrdenarPor;
                if (OrdenarPor == "1") {
                  this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.ListaProductos.unshift(
                    data.datosActualizacion
                  );
                } else {
                  this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.ListaProductos.push(
                    data.datosActualizacion
                  );
                }
              } else if (tipo[3] == "multiple") {
                var preferencias = JSON.parse(
                  localStorage.getItem(
                    "__local__catalogosProductos__preferencias"
                  )
                );
                var OrdenarPor = preferencias.OrdenarPor;
                if (OrdenarPor == "1") {
                  $.each(data.datosActualizacion, function(index, item) {
                    ths.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.ListaProductos.unshift(
                      item
                    );
                  });
                } else {
                  $.each(data.datosActualizacion, function(index, item) {
                    ths.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.ListaProductos.push(
                      item
                    );
                  });
                }
              }
            }
          }
        }
      }
    }
  },
  components: {},
  computed: {},
  watch: {}
};
</script>
<style lang="scss">
$count: 10;
$time: 2; //in seconds
$size: 100;
$color: #f44336;

.holder {
  position: absolute;
  left: 0px;
  top: 0px;
  bottom: 0px;
  right: 0px;
  width: 100%;
  height: 100%;
  z-index: 5000;
  background-color: rgba(255, 255, 255, 1);
}

.preloader {
  /* size */
  width: $size + px;
  height: $size + px;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translateX(-50%) translateY(-50%);
  animation: rotatePreloader $time + s infinite ease-in;
}
@keyframes rotatePreloader {
  0% {
    transform: translateX(-50%) translateY(-50%) rotateZ(0deg);
  }
  100% {
    transform: translateX(-50%) translateY(-50%) rotateZ(-360deg);
  }
}
.preloader div {
  position: absolute;
  width: 100%;
  height: 100%;
  opacity: 0;
}
.preloader div:before {
  content: "";
  position: absolute;
  left: 50%;
  top: 0%;
  width: 10%;
  height: 10%;
  background-color: $color;
  transform: translateX(-50%);
  border-radius: 50%;
}

@for $i from 1 through $count {
  .preloader div:nth-child(#{$i}) {
    transform: rotateZ(((360 / $count) * ($i - 1)) + deg);
    animation: rotateCircle + $i $time + s infinite linear;
    z-index: $count - $i;
  }
  @keyframes rotateCircle#{$i} {
    #{percentage(((50 / $count) * ($i - 1)) / 100)} {
      opacity: 0;
    }
    #{percentage((((50 / $count) + 0.0001) * ($i - 1)) / 100)} {
      opacity: 1;
      transform: rotateZ((0 - ((360 / $count) * ($i - 2))) + deg);
    }
    #{percentage((((50 / $count) * ($i - 0)) + 2) / 100)} {
      transform: rotateZ((0 - ((360 / $count) * ($i - 1))) + deg);
    }
    #{percentage(((50 + ((50 / $count) * ($i - 0))) + 2) / 100)} {
      transform: rotateZ((0 - ((360 / $count) * ($i - 1))) + deg);
    }
    100% {
      transform: rotateZ((0 - ((360 / $count) * ($count - 1))) + deg);
      opacity: 1;
    }
  }
}
.md-checkbox.md-checked .md-checkbox-container:after {
  border-color: #ff9800 !important;
}

.md-select-menu .md-list-item.md-selected .md-list-item-button {
  background-color: #ea4743;
  box-shadow: 0 12px 20px -10px rgb(234, 71, 67),
    0 4px 20px 0px rgba(0, 0, 0, 0.12), 0 7px 8px -5px rgba(234, 71, 67, 0.05);
}

.fab-main[data-v-a57a2e96] {
  width: 65px !important;
  height: 65px !important;
}

.md-field:before {
  background-color: black !important;
}

.md-select-menu .md-list-item .md-list-item-button:hover {
  background-color: #ea4542 !important;
}
.md-select-menu .md-list-item .md-list-item-button:hover {
  background-color: #ea4542 !important;
}
.md-switch.md-checked .md-switch-container {
  background-color: rgb(76, 175, 80) !important;
}

.md-switch.md-checked .md-switch-thumb {
  border: 1px solid #4caf50;
}

.color-green {
  background: #4caf50 !important;
}

.md-icon.md-theme-default.md-icon-font {
  display: none !important;
}

.md-datepicker-dialog .md-datepicker-header{
    background: #4caf50 !important;
    color: white!important;
}

.md-datepicker-today, .md-datepicker-today:hover, .md-datepicker-today:focus, .md-datepicker-selected, .md-datepicker-selected:hover, .md-datepicker-selected:focus{
  background: #4caf50 !important;
}
</style>
