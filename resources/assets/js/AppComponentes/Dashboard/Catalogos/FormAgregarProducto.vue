<template>
  <div class="md-layout">
    <div class="md-layout-item">
      <md-card>
        <md-card-header header-color="blue" class="md-card-header-text md-card-header-warning">
          <div class="card-text">
            <h4 class="title">
              <div
                v-if="this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.Editar.EditarProducto"
              >
                <md-icon>edit</md-icon>Editar producto
              </div>
              <div v-else>
                <md-icon>add</md-icon>Agregar producto
              </div>
            </h4>
          </div>
        </md-card-header>
        <md-card-content>
          <div v-if="subiendo===true">
            <center>
              <div class="holder">
                <div class="preloader">
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
                </div>
              </div>
              <br>
            </center>
          </div>
          <p style="color:red">* Son obligatorios</p>
          <div
            v-if="this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.Editar.EditarProducto"
            style="float:right"
          >
            <i class="fas fa-calendar-alt"></i>
            <small>Creado / Actualizado el:</small>
            <strong>
              {{ $store.state.Interface.Dinamico.Componentes.Catalogo.Productos.Editar
              .InfoProducto.updated_at | fechaActualizacion}}
            </strong>
          </div>

          <br>
          <br>
          <md-field :class="[{'md-error':FormAgregarProducto.CodigoDeBarras.isValid===false}]">
            <label>
              Codigo de barras
              <span style="color:red">*</span>
            </label>
            <md-input autofocus v-model="FormAgregarProducto.CodigoDeBarras.val" number="true"></md-input>
            <span class="md-helper-text"></span>
          </md-field>
          <br>
          <md-field :class="[{'md-error':FormAgregarProducto.NombreComercial.isValid===false}]">
            <label>
              Nombre comercial
              <span style="color:red">*</span>
            </label>
            <md-input v-model="FormAgregarProducto.NombreComercial.val"></md-input>
            <span class="md-helper-text"></span>
          </md-field>
          <br>
          <md-field :class="[{'md-error':FormAgregarProducto.NombreComercial.isValid===false}]">
            <label>
              Nombre generico
              <span style="color:red">*</span>
            </label>
            <md-input v-model="FormAgregarProducto.NombreGenerico.val"></md-input>
            <span class="md-helper-text"></span>
          </md-field>
          <br>
          <md-field :class="[{'md-error':FormAgregarProducto.FormaFarmaucetica.isValid===false}]">
            <label>
              Forma farmaucetica
              <span style="color:red">*</span>
            </label>
            <md-input v-model="FormAgregarProducto.FormaFarmaucetica.val"></md-input>
            <span class="md-helper-text"></span>
          </md-field>
          <br>
          <md-field :class="[{'md-error':FormAgregarProducto.Presentacion.isValid===false}]">
            <label>
              Presentación
              <span style="color:red">*</span>
            </label>
            <md-input v-model="FormAgregarProducto.Presentacion.val"></md-input>
            <span class="md-helper-text"></span>
          </md-field>
          <br>
          <md-field :class="[{'md-error':FormAgregarProducto.Contenido.isValid===false}]">
            <label>
              Contenido
              <span style="color:red">*</span>
            </label>
            <md-input v-model="FormAgregarProducto.Contenido.val"></md-input>
            <span class="md-helper-text"></span>
          </md-field>
          <br>
          <md-field>
            <label>Comentarios</label>
            <md-input v-model="FormAgregarProducto.Comentarios.val"></md-input>
            <span class="md-helper-text"></span>
          </md-field>
          <br>
          <md-field>
            <label>Categorias</label>
            <md-input v-model="FormAgregarProducto.Categoria.val"></md-input>
            <span class="md-helper-text"></span>
          </md-field>
          <br>
          <md-button @click="regresar" class="md-warning md-round" style="float:left">
            <i class="fas fa-chevron-left"></i>
            <md-tooltip md-direction="bottom">Volver</md-tooltip>
          </md-button>
          <div
            v-if="this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.Editar.EditarProducto"
          >
            <md-button class="md-success md-round" @click="ActualizarProducto" style="float:right">
              <i class="fas fa-save"></i>
              <md-tooltip md-direction="bottom">Actualizar</md-tooltip>
            </md-button>
          </div>
          <div v-else>
            <md-button class="md-success md-round" @click="AgregarProducto" style="float:right">
              <i class="fas fa-save"></i>
              <md-tooltip md-direction="bottom">Guardar</md-tooltip>
            </md-button>
          </div>
        </md-card-content>
      </md-card>
    </div>

    <md-snackbar
      md-position="center"
      :md-duration="Infinity"
      :md-active.sync="errorServidor"
      md-persistent
    >
      <span>{{mensajeError}}</span>
      <md-button class="md-danger" @click="errorServidor = false">Ok</md-button>
    </md-snackbar>
  </div>
</template>

<script>
import Notifications from "../../../components/NotificationPlugin";
import swal from "sweetalert2";
import $ from "jquery";
import VueScrollTo from "vue-scrollto";
import moment from "moment";

export default {
  data() {
    return {
      subiendo: false,
      errorServidor: false,
      mensajeError: "",
      Editar: false,
      FormAgregarProducto: {
        CodigoDeBarras: {
          val: "",
          isValid: null
        },
        NombreComercial: {
          val: "",
          isValid: null
        },
        NombreGenerico: {
          val: "",
          isValid: null
        },
        FormaFarmaucetica: {
          val: "",
          isValid: null
        },
        Presentacion: {
          val: "",
          isValid: null
        },
        Contenido: {
          val: "",
          isValid: null
        },
        Comentarios: {
          val: "",
          isValid: null
        },
        Categoria: {
          val: "",
          isValid: null
        },
        Id: {
          val: ""
        }
      }
    };
  },
  created() {
    if (
      this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.Editar
        .EditarProducto
    ) {
      this.Editar = true;
      var el = this.$store.state.Interface.Dinamico.Componentes.Catalogo
        .Productos.Editar.InfoProducto;
      this.FormAgregarProducto.CodigoDeBarras.val = el.CodigoDeBarras;
      this.FormAgregarProducto.NombreComercial.val = el.NombreComercial;
      this.FormAgregarProducto.NombreGenerico.val = el.NombreGenerico;
      this.FormAgregarProducto.FormaFarmaucetica.val = el.FormaFarmaucetica;
      this.FormAgregarProducto.Presentacion.val = el.Presentacion;
      this.FormAgregarProducto.Contenido.val = el.Contenido;
      this.FormAgregarProducto.Comentarios.val = el.Comentarios;
      if (el.id == undefined || el.id == null) {
        this.FormAgregarProducto.Id.val = el.Id;
      } else {
        this.FormAgregarProducto.Id.val = el.id;
      }
    }
  },
  mounted() {
    window.scrollTo(0, 0);
  },
  methods: {
    AgregarProducto() {
      if (this.ValidarFormulario()) {
        this.subiendo = true;
        var ths = this;
        this.$http
          .get(
            "/validate/catalogos/productos?type=product-only&token=" +
              ths.FormAgregarProducto.CodigoDeBarras.val
          )
          .then(
            response => {
              if (response.data === 1) {
                ths.$http
                  .post("/store/catalogos/productos", {
                    data: {
                      CodigoDeBarras:
                        ths.FormAgregarProducto.CodigoDeBarras.val,
                      NombreComercial:
                        ths.FormAgregarProducto.NombreComercial.val,
                      NombreGenerico:
                        ths.FormAgregarProducto.NombreGenerico.val,
                      FormaFarmaucetica:
                        ths.FormAgregarProducto.FormaFarmaucetica.val,
                      Presentacion: ths.FormAgregarProducto.Presentacion.val,
                      Contenido: ths.FormAgregarProducto.Contenido.val,
                      Comentarios: ths.FormAgregarProducto.Comentarios.val,
                      Id: ths.FormAgregarProducto.Id.val,
                      Estado: true
                    },
                    type: "single"
                  })
                  .then(
                    response => {
                      var respuesta = response.data;
                      if (respuesta.solicitud && respuesta.estatus) {
                        this.FormAgregarProducto.CodigoDeBarras.val = "";
                        this.FormAgregarProducto.NombreComercial.val = "";
                        this.FormAgregarProducto.NombreGenerico.val = "";
                        this.FormAgregarProducto.FormaFarmaucetica.val = "";
                        this.FormAgregarProducto.Presentacion.val = "";
                        this.FormAgregarProducto.Contenido.val = "";
                        this.FormAgregarProducto.Comentarios.val = "";
                        this.FormAgregarProducto.Categoria.val = "";
                        this.FormAgregarProducto.Id.val = "";

                        swal({
                          title: "Correcto",
                          text: "Se ha añadido el producto",
                          type: "success",
                          confirmButtonClass: "md-button md-success",
                          buttonsStyling: false
                        });
                        var preferencias = JSON.parse(
                          localStorage.getItem(
                            "__local__catalogosProductos__preferencias"
                          )
                        );
                        if (preferencias.OrdenarPor == "1") {
                          ths.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.Paginador = 1;
                          var estructura = {
                            OrdenarPor: 1,
                            MostrarElementos: preferencias.MostrarElementos
                          };
                          localStorage.setItem(
                            "__local__catalogosProductos__preferencias",
                            JSON.stringify(estructura)
                          );
                        }

                        ths.subiendo = false;
                        ths.$router.push("/catalogo/productos");
                      } else {
                        ths.subiendo = false;
                        swal({
                          title: "Error",
                          text: "Ocurrio un error, intentalo de nuevo",
                          type: "error",
                          confirmButtonClass: "md-button md-success",
                          buttonsStyling: false
                        });
                      }
                    },
                    error => {
                      ths.subiendo = false;
                      ths.mensajeError =
                        "Ocurrio un error desconocido, intentalo mas tarde";
                      ths.errorServidor = true;
                    }
                  );
              } else {
                ths.subiendo = false;

                ths.FormAgregarProducto.CodigoDeBarras.isValid = false;
                ths.mensajeError =
                  "Ya existe un producto con el mismo codigo de barras";
                ths.errorServidor = true;
              }
            },
            error => {
              ths.mensajeError =
                "Ocurrio un error desconocido, intentalo mas tarde";
              ths.errorServidor = true;
            }
          );
      }
    },
    ActualizarProducto() {
      if (this.ValidarFormulario()) {
        this.subiendo = true;
        var ths = this;
        ths.$http
          .post("/update/catalogos/productos", {
            data: {
              CodigoDeBarras: ths.FormAgregarProducto.CodigoDeBarras.val,
              NombreComercial: ths.FormAgregarProducto.NombreComercial.val,
              NombreGenerico: ths.FormAgregarProducto.NombreGenerico.val,
              FormaFarmaucetica: ths.FormAgregarProducto.FormaFarmaucetica.val,
              Presentacion: ths.FormAgregarProducto.Presentacion.val,
              Contenido: ths.FormAgregarProducto.Contenido.val,
              Comentarios: ths.FormAgregarProducto.Comentarios.val,
              Id: ths.FormAgregarProducto.Id.val
            },
            type: "update_single"
          })
          .then(
            response => {
              var respuesta = response.data;
              if (respuesta) {
                this.FormAgregarProducto.CodigoDeBarras.val = "";
                this.FormAgregarProducto.NombreComercial.val = "";
                this.FormAgregarProducto.NombreGenerico.val = "";
                this.FormAgregarProducto.FormaFarmaucetica.val = "";
                this.FormAgregarProducto.Presentacion.val = "";
                this.FormAgregarProducto.Contenido.val = "";
                this.FormAgregarProducto.Comentarios.val = "";
                this.FormAgregarProducto.Categoria.val = "";

                swal({
                  title: "Correcto",
                  text: "Se ha actualizado el producto",
                  type: "success",
                  confirmButtonClass: "md-button md-success",
                  buttonsStyling: false
                }).then(result => {
                  ths.$router.push("/catalogo/productos");
                });
                ths.subiendo = false;
              } else {
                ths.subiendo = false;
                swal({
                  title: "Error",
                  text: "Ocurrio un error, intentalo de nuevo",
                  type: "error",
                  confirmButtonClass: "md-button md-success",
                  buttonsStyling: false
                });
              }
            },
            error => {
              ths.subiendo = false;
              ths.mensajeError =
                "Ocurrio un error desconocido, intentalo mas tarde";
              ths.errorServidor = true;
            }
          );
      }
    },
    ValidarFormulario() {
      var itemsTotal = 6;
      var itemsVal = 0;
      if (this.FormAgregarProducto.NombreComercial.val != "") {
        this.FormAgregarProducto.CodigoDeBarras.isValid = true;
        itemsVal++;
      } else {
        this.FormAgregarProducto.CodigoDeBarras.isValid = false;
      }

      if (this.FormAgregarProducto.NombreComercial.val != "") {
        this.FormAgregarProducto.NombreComercial.isValid = true;
        itemsVal++;
      } else {
        this.FormAgregarProducto.NombreComercial.isValid = false;
      }

      if (this.FormAgregarProducto.NombreGenerico.val != "") {
        this.FormAgregarProducto.NombreGenerico.isValid = true;
        itemsVal++;
      } else {
        this.FormAgregarProducto.NombreGenerico.isValid = false;
      }

      if (this.FormAgregarProducto.FormaFarmaucetica.val != "") {
        this.FormAgregarProducto.FormaFarmaucetica.isValid = true;
        itemsVal++;
      } else {
        this.FormAgregarProducto.FormaFarmaucetica.isValid = false;
      }

      if (this.FormAgregarProducto.Presentacion.val != "") {
        this.FormAgregarProducto.Presentacion.isValid = true;
        itemsVal++;
      } else {
        this.FormAgregarProducto.Presentacion.isValid = false;
      }

      if (this.FormAgregarProducto.Contenido.val != "") {
        this.FormAgregarProducto.Contenido.isValid = true;
        itemsVal++;
      } else {
        this.FormAgregarProducto.Contenido.isValid = false;
      }

      if (itemsTotal == itemsVal) {
        return true;
      } else {
        return false;
      }
    },
    regresar() {
      if (
        this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos
          .Editar.EditarProducto
      ) {
        this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.Editar.EditarProducto = false;
      }

      this.$router.push("/catalogo/productos");
    }
  },
  filters: {
    fechaActualizacion(val) {
      moment.locale("es-ES");
      return moment(val).format("DD MMMM  YYYY");
    }
  }
};
</script>

<style>
.md-field:before {
  background-color: black !important;
}
</style>
