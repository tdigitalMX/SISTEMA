<template>
  <div class="md-layout">
    <div class="md-layout-item">
      <md-card>
        <md-card-header header-color="blue" class="md-card-header-text md-card-header-danger">
          <div class="card-text">
            <h4 class="title">
              <md-icon>list</md-icon>Registro de productos
            </h4>
          </div>
        </md-card-header>
        <md-card-content>
          <div v-if="leyendo===true">
            <center>
              <div class="holder">
                <div class="preloader" v-if="errorServidor===false">
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
          <div style="float:right">
            <div>
              <md-button class="md-success md-sm md-just-icon md-round" @click="irAForm">
                <i class="fas fa-plus"></i>
                <md-tooltip md-direction="bottom">Agregar</md-tooltip>
              </md-button>
              <md-button
                @click="$router.push('/catalogo/importar-producto')"
                class="md-warning md-sm md-just-icon md-round"
              >
                <i class="fas fa-upload"></i>
                <md-tooltip md-direction="bottom">Importar desde Excel</md-tooltip>
              </md-button>
              <md-button v-if="productos.length > 0" class="md-info md-sm md-just-icon md-round">
                <i class="fas fa-download"></i>
                <md-tooltip md-direction="bottom">Exportar a Excel</md-tooltip>
              </md-button>
            </div>

            <br>
            <br>
          </div>
          <div v-if="productos.length > 0 || FormBusqueda.Buscando">
            <br>
            <br>
            <div class="md-layout">
              <div class="md-layout-item md-xsmall-size-100 md-size-15">
                <md-field>
                  <label for>Tipo busqueda</label>
                  <md-select v-model="FormBusqueda.Tipo" name="Selecciona" id>
                    <md-option value="1">Codigo</md-option>
                    <md-option value="2">Nombre comercial</md-option>
                    <md-option value="3">Nombre generico</md-option>
                  </md-select>
                </md-field>
              </div>
              <div class="md-layout-item md-xsmall-size-75 md-size-25">
                <md-field>
                  <label>
                    <i class="fas fa-search"></i> Busqueda
                  </label>
                  <md-input @input="BuscarProductos" v-model="FormBusqueda.TextoBusqueda"></md-input>
                </md-field>
                <br>
              </div>
              <div class="md-layout-item md-xsmall-size-25 md-size-5"></div>
              <div class="md-layout-item md-xsmall-size-100 md-size-25"></div>
              <div class="md-layout-item md-xsmall-size-50 md-size-15">
                <md-field>
                  <label for>Ordenar por</label>
                  <md-select @input="ordenarPor(false)" v-model="OrdenarPor">
                    <md-option value="1">Mas nuevo</md-option>
                    <md-option value="2">Mas antiguo</md-option>
                  </md-select>
                </md-field>
                <br>
              </div>
              <div class="md-layout-item md-xsmall-size-50 md-size-15">
                <md-field>
                  <label for>Mostrar elementos</label>
                  <md-select v-model="Paginador.MostrarPorPagina">
                    <md-option value="12">12</md-option>
                    <md-option value="24">24</md-option>
                    <md-option value="36">36</md-option>
                    <md-option value="48">48</md-option>
                    <md-option value="72">72</md-option>
                  </md-select>
                </md-field>
              </div>
            </div>


            <md-table
              v-model="productos"
              table-header-color="dark"
              :class="[{'table-striped':productos.length > 0 },'table-hover']"
              md-sort="NombreComercial"
              md-sort-order="asc"
              md-card
              @md-selected="onSelect"
            >
              <md-table-empty-state
                md-label="Ningun producto encontrado"
                :md-description="`Intenta con otro termino de busqueda`"
              ></md-table-empty-state>

              <md-table-row
                slot="md-table-row"
                slot-scope="{ item }"
                @click="editarEnForm(item.CodigoDeBarras)"
                md-selectable="multiple"
                md-auto-select
              >
                <md-table-cell
                  md-sort-by="CodigoDeBarras"
                  md-numeric
                  md-label="Codigo"
                >{{ item.CodigoDeBarras }}</md-table-cell>
                <md-table-cell
                  md-label="Nombre Comercial"
                  md-sort-by="NombreComercial"
                >{{ item.NombreComercial }}</md-table-cell>
                <md-table-cell
                  md-label="Nombre Generico"
                  md-sort-by="Contenido"
                >{{ item.NombreGenerico }}</md-table-cell>
                <md-table-cell
                  md-label="Forma Farmacéutica"
                  md-sort-by="FormaFarmaucetica"
                >{{ item.FormaFarmaucetica }}</md-table-cell>
                <md-table-cell
                  md-label="Presentación"
                  md-sort-by="Presentacion"
                >{{ item.Presentacion }}</md-table-cell>

                <md-table-cell md-label="Opciones">
                  <div style="display: inline-block!important">
                    <md-switch
                      v-if="item.Estado"
                      @change="desactivar(item.CodigoDeBarras)"
                      v-model="item.Estado"
                    ></md-switch>
                    <md-switch v-else @change="activar(item.CodigoDeBarras)" v-model="item.Estado"></md-switch>
                    <div style="margin-left:45px;margin-top:12px">
                      <md-button
                        style="margin-top:-40px!important"
                        v-if="!item.Estado"
                        class="md-danger md-just-icon md-round"
                      >
                        <i class="fas fa-trash"></i>
                      </md-button>
                    </div>
                  </div>
                </md-table-cell>
              </md-table-row>
            </md-table>
            <div style="float:right;display:inline!important">
              <pagination
                v-model="Paginador.PaginaActual"
                :page-count="this.Paginador.TotalDePaginas"
              ></pagination>
            </div>
          </div>
          <div v-else>
            <CENTER>
              <md-empty-state
                style="margin-top:100px"
                md-icon="fa fa-bars"
                md-label="Agrega un producto"
                md-description="Agrega un producto para visualizar mas opciones"
              >
                <md-button
                  style="margin-bottom:80px"
                  class="md-round md-danger"
                  :to="'form-producto'"
                >
                  <md-icon>add</md-icon>Registrar producto
                </md-button>
              </md-empty-state>
            </CENTER>
          </div>
          <br>
        </md-card-content>
      </md-card>
    </div>

    <!--<md-button class="md-primary md-just-icon md-round btn-lg" style="right:35px;position:fixed;bottom:0px!important;z-index:5000;"><md-icon >favorite</md-icon></md-button>
    -->
    <fab
      v-if="Seleccionados.length > 0 && Seleccionados[0] !== undefined"
      :position="position"
      :bg-color="bgColor"
      :actions="fabActions"
      @activarSeleccionados="activarSeleccionados"
      @desactivarSeleccionados="desactivarSeleccionados"
    ></fab>
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
const toLower = text => {
  return text.toString().toLowerCase();
};

const searchByName = (items, term, type) => {
  if (term) {
    console.log(items);

    if (type == "1") {
      return items.filter(item =>
        toLower(item.CodigoDeBarras).includes(toLower(term))
      );
    } else if (type == "2") {
      return items.filter(item =>
        toLower(item.NombreComercial).includes(toLower(term))
      );
    } else if (type == "3") {
      return items.filter(item =>
        toLower(item.NombreGenerico).includes(toLower(term))
      );
    }
  }

  return items;
};

import StatsCard from "../../../components/Cards/StatsCard.vue";
import Modal from "../../../components/Modal.vue";
import swal from "sweetalert2";
import $ from "jquery";
import Pagination from "../../../components/pagination.vue";
import Collapse from "../../../components/Collapse.vue";
import fab from "vue-fab";
import moment from "moment";

export default {
  data() {
    return {
      errorServidor: false,
      mensajeError: "",
      bgColor: "#ea4743",
      position: "bottom-right",
      fabActions: [
        {
          name: "activarSeleccionados",
          icon: "done"
        },
        {
          name: "desactivarSeleccionados",
          icon: "clear"
        }
      ],
      leyendo: true,
      OrdenarPor: 1,
      Seleccionados: [],
      EliminarMultiple: false,
      itemADesactivar: "",
      productos: [],
      productosTotales: [],

      FormBusqueda: {
        Tipo: "1",
        TextoBusqueda: "",
        Buscando: false
      },
      Paginador: {
        MostrarPorPagina: 48,
        PaginaActual: 1,
        TotalDePaginas: 0
      }
    };
  },
  created() {
    this.validarLocalStorage();
    if (
      this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos
        .ProductosCargados === false
    ) {
      this.Paginador.PaginaActual = this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.Paginador;
      this.obtenerDatosDelServidor();
    } else {
      this.Paginador.PaginaActual = this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.Paginador;
      this.productosTotales = this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.ListaProductos;
      this.formatearDatos(false);
      this.PaginacionValidar();
      this.leyendo = false;
    }
  },
  mounted() {

  },
  methods: {
    PaginacionValidar(cc = false) {
      if (cc) {
        this.Paginador.PaginaActual = 1;
      }
      var TotalElementos = Object.keys(this.productosTotales).length - 1;

      if (TotalElementos % this.Paginador.MostrarPorPagina === 0) {
        var TotalPaginas = TotalElementos / this.Paginador.MostrarPorPagina;
      } else {
        var TotalPaginas =
          parseInt(TotalElementos / this.Paginador.MostrarPorPagina) + 1;
      }

      this.Paginador.TotalDePaginas = TotalPaginas;
      this.cambiarPagina();
    },
    obtenerDatosDelServidor() {
      var ths = this;
      this.$http.get("/get/catalogos/productos").then(
        response => {
          if (response.data.length > 0) {
            ths.productosTotales = response.data;
            ths.leyendo = false;
            ths.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.ProductosCargados = true;
            ths.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.ListaProductos =
              response.data;

            ths.formatearDatos(true);
            ths.PaginacionValidar();
          } else {
            ths.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.ProductosCargados = true;
             ths.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.ListaProductos = []
            ths.leyendo = false;
          }
        },
        error => {
          ths.mensajeError = "Error al comunicarnos con el servidor remoto";
          ths.errorServidor = true;
        }
      );
    },
    formatearDatos(servidor = false) {
      var ths = this;
      if (servidor) {
        var ordernar = this.ordenarPor(true);
      } else {
        var ordernar = true;
      }

      if (ordernar) {
        this.productosTotales.forEach(function(element) {
          if (element.Estado == 1) {
            element.Estado = true;
          } else if (element.Estado == 0) {
            element.Estado = false;
          }
        });
      }
    },
    cambiarPagina() {
      var TotalElementos = Object.keys(this.productosTotales).length - 1;
      this.productos = [];
      var init =
        this.Paginador.PaginaActual * this.Paginador.MostrarPorPagina -
        this.Paginador.MostrarPorPagina;
      var end =
        TotalElementos -
        this.Paginador.PaginaActual * this.Paginador.MostrarPorPagina;
      end = TotalElementos - end;
      if (end > TotalElementos) {
        end = TotalElementos;
      }

      for (var i = init; i <= end; i++) {
        this.productos.push(this.productosTotales[i]);
      }
    },
    BuscarProductos() {
      if (
        this.FormBusqueda.TextoBusqueda !== "" ||
        this.FormBusqueda.TextoBusqueda !== null
      ) {
        this.FormBusqueda.Buscando = true;
        this.productos = searchByName(
          this.productos,
          this.FormBusqueda.TextoBusqueda,
          this.FormBusqueda.Tipo
        );
      } else {
        this.FormBusqueda.Buscando = false;
      }
    },
    AgregarProducto() {
      this.ValidarFormulario();
    },
    validarLocalStorage() {
      if (localStorage.getItem("__local__catalogosProductos__preferencias")) {
        var preferencias = JSON.parse(
          localStorage.getItem("__local__catalogosProductos__preferencias")
        );
        this.OrdenarPor = preferencias.OrdenarPor;
        this.Paginador.MostrarPorPagina = preferencias.MostrarElementos;
      } else {
        var estructura = {
          OrdenarPor: 1,
          MostrarElementos: "12"
        };
        localStorage.setItem(
          "__local__catalogosProductos__preferencias",
          JSON.stringify(estructura)
        );
        this.validarLocalStorage();
      }
    },
    ValidarFormulario() {
      if (
        this.FormAgregarProducto.CodigoDeBarras.val != null &&
        this.FormAgregarProducto.CodigoDeBarras.val > 0
      ) {
        this.FormAgregarProducto.CodigoDeBarras.isValid = true;
      } else {
        this.FormAgregarProducto.CodigoDeBarras.isValid = false;
      }

      if (this.FormAgregarProducto.NombreComercial.val != "") {
        this.FormAgregarProducto.NombreComercial.isValid = true;
      } else {
        this.FormAgregarProducto.NombreComercial.isValid = false;
      }

      if (this.FormAgregarProducto.NombreGenerico.val != "") {
        this.FormAgregarProducto.NombreGenerico.isValid = true;
      } else {
        this.FormAgregarProducto.NombreGenerico.isValid = false;
      }

      if (this.FormAgregarProducto.FormaFarmaucetica.val != "") {
        this.FormAgregarProducto.FormaFarmaucetica.isValid = true;
      } else {
        this.FormAgregarProducto.FormaFarmaucetica.isValid = false;
      }

      if (this.FormAgregarProducto.Presentacion.val != "") {
        this.FormAgregarProducto.Presentacion.isValid = true;
      } else {
        this.FormAgregarProducto.Presentacion.isValid = false;
      }

      if (this.FormAgregarProducto.Contenido.val != "") {
        this.FormAgregarProducto.Contenido.isValid = true;
      } else {
        this.FormAgregarProducto.Contenido.isValid = false;
      }
    },
    desactivar(item = null) {
      var ths = this;
      this.itemADesactivar = item;
      this.productos.forEach(function(element) {
        if (element.CodigoDeBarras == ths.itemADesactivar) {
          element.Estado = true;
        }
      });

      swal({
        title: "¿Estas seguro?",
        text: "Estas intentando desactivar un producto",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Seguro",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "md-button md-success",
        cancelButtonClass: "md-button md-danger",
        buttonsStyling: false,
        allowOutsideClick: false
      }).then(result => {
        if (result.value) {
          this.$http
            .put("/update/catalogos/productos", {
              data: ths.itemADesactivar,
              type: "Desactivar"
            })
            .then(
              response => {
                if (response.data) {
                  ths.productos.forEach(function(element) {
                    if (element.CodigoDeBarras == ths.itemADesactivar) {
                      element.Estado = false;
                    }
                  });

                  ths.validarBotonesSeleccionMultiple();
                  swal({
                    title: "Se ha desactivado",
                    text: "Este producto se ha desactivado satisfactoriamente",
                    type: "success",
                    confirmButtonClass: "md-button md-success",
                    buttonsStyling: false
                  });
                }
              },
              error => {
                ths.productos.forEach(function(element) {
                  if (element.CodigoDeBarras == ths.itemADesactivar) {
                    element.Estado = true;
                  }
                });

                swal({
                  title: "Error",
                  text: "Ha ocurrido un error desconocido",
                  type: "error",
                  confirmButtonClass: "md-button md-success",
                  buttonsStyling: false
                });
              }
            );
        } else if (result.dismiss === swal.DismissReason.cancel) {
          this.productos.forEach(function(element) {
            if (element.CodigoDeBarras == ths.itemADesactivar) {
              element.Estado = true;
            }
          });
          this.validarBotonesSeleccionMultiple();
        }
      });
    },
    onSelect(items) {
      var array = [];
      items.forEach(function(element) {
        array.push(element.CodigoDeBarras);
      });
      this.Seleccionados = array;
    },
    activar(itemActivar) {
      var ths = this;
      this.$http
        .put("/update/catalogos/productos", {
          data: itemActivar,
          type: "Activar"
        })
        .then(
          response => {
            if (response.data) {
              ths.productos.forEach(function(element) {
                if (element.CodigoDeBarras == ths.itemActivar) {
                  element.Estado = true;
                }
              });

              ths.validarBotonesSeleccionMultiple();
              swal({
                title: "Se ha activado",
                text: "Este producto se ha activado satisfactoriamente",
                type: "success",
                confirmButtonClass: "md-button md-success",
                buttonsStyling: false
              });
            }
          },
          error => {
            ths.productos.forEach(function(element) {
              if (element.CodigoDeBarras == ths.itemActivar) {
                element.Estado = false;
              }
            });
            swal({
              title: "Error",
              text: "Ha ocurrido un error desconocido",
              type: "error",
              confirmButtonClass: "md-button md-success",
              buttonsStyling: false
            });
          }
        );
      this.validarBotonesSeleccionMultiple();
    },
    validarBotonesSeleccionMultiple() {
      var ths = this;
      var Activados = 0;
      this.Seleccionados.forEach(function(element) {
        ths.productos.forEach(function(element2) {
          if (element == element2.CodigoDeBarras) {
            if (element2.Estado) {
              Activados++;
            }
          }
        });
      });

      if (Activados > 0) {
        this.EliminarMultiple = false;
        this.fabActions = [
          {
            name: "activarSeleccionados",
            icon: "done"
          },
          {
            name: "desactivarSeleccionados",
            icon: "clear"
          }
        ];
      } else {
        this.EliminarMultiple = true;
        if (this.fabActions[2] == null || this.fabActions[2] == undefined) {
          this.fabActions.push({
            name: "elimarSeleccionados",
            bgColor: "green",
            icon: "delete"
          });
        }
      }
    },
    activarSeleccionados() {
      var ths = this;
      this.$http
        .put("/update/catalogos/productos", {
          data: ths.Seleccionados,
          type: "Activar_Multiple"
        })
        .then(
          response => {
            if (response.data) {
              this.Seleccionados.forEach(function(element) {
                ths.productos.forEach(function(element2) {
                  if (element == element2.CodigoDeBarras) {
                    element2.Estado = true;
                  }
                });
              });
              swal({
                title: "Completado",
                text: "Se han activado los elementos que seleccionaste",
                type: "success",
                confirmButtonClass: "md-button md-success",
                buttonsStyling: false
              });
              this.validarBotonesSeleccionMultiple();
            }
          },
          error => {
            this.Seleccionados.forEach(function(element) {
              ths.productos.forEach(function(element2) {
                if (
                  element == element2.CodigoDeBarras &&
                  element.Estado == false
                ) {
                  element2.Estado = false;
                }
              });
            });

            swal({
              title: "Error",
              text: "Ha ocurrido un error desconocido",
              type: "error",
              confirmButtonClass: "md-button md-success",
              buttonsStyling: false
            });
          }
        );
    },
    desactivarSeleccionados() {
      var ths = this;
      swal({
        title: "¿Estas seguro?",
        text: "Estas intentando desactivar uno o varios productos",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Seguro",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "md-button md-success",
        cancelButtonClass: "md-button md-danger",
        buttonsStyling: false,
        allowOutsideClick: false
      }).then(result => {
        if (result.value) {
          this.$http
            .put("/update/catalogos/productos", {
              data: ths.Seleccionados,
              type: "Desactivar_Multiple"
            })
            .then(
              response => {
                if (response.data) {
                  ths.Seleccionados.forEach(function(element) {
                    ths.productos.forEach(function(element2) {
                      if (element == element2.CodigoDeBarras) {
                        element2.Estado = false;
                      }
                    });
                  });

                  this.validarBotonesSeleccionMultiple();
                  swal({
                    title: "Completado",
                    text: "Se han desactivado los elementos que seleccionaste",
                    type: "success",
                    confirmButtonClass: "md-button md-success",
                    buttonsStyling: false
                  });
                }
              },
              error => {
                ths.Seleccionados.forEach(function(element) {
                  ths.productos.forEach(function(element2) {
                    if (
                      element == element2.CodigoDeBarras &&
                      element.Estado == true
                    ) {
                      element2.Estado = true;
                    }
                  });
                });

                swal({
                  title: "Error",
                  text: "Ha ocurrido un error desconocido",
                  type: "error",
                  confirmButtonClass: "md-button md-success",
                  buttonsStyling: false
                });
              }
            );
        }
      });
    },
    editarEnForm(item) {
      var ths = this;
      this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.Editar.EditarProducto = true;
      this.productos.forEach(function(element) {
        if (element.CodigoDeBarras == item) {
          ths.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.Editar.InfoProducto = element;
          ths.$router.push("/catalogo/form-producto");
          return;
        }
      });
    },
    irAForm() {
      this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.Editar.EditarProducto = false;
      this.$router.push("/catalogo/form-producto");
    },
    ordenarPor(load = false) {
      if (load) {
        if (this.OrdenarPor == "2") {
          var productos = [];
          for (var i = this.productosTotales.length - 1; i >= 0; i--) {
            productos.push(this.productosTotales[i]);
          }
          this.productosTotales = productos;
          this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.ListaProductos = this.productosTotales;
          return true;
        } else {
          return true;
        }
      } else {
        var productos = [];
        for (var i = this.productosTotales.length - 1; i >= 0; i--) {
          productos.push(this.productosTotales[i]);
        }
        this.productosTotales = productos;
         this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.ListaProductos = this.productosTotales;
        this.PaginacionValidar(true);
        return true;
      }
    }
  },
  components: {
    StatsCard,
    Modal,
    Pagination,
    Collapse,
    fab
  },
  computed: {
    SeleccionadosCam() {
      return this.Seleccionados;
    },
    CambioPaginador() {
      return this.Paginador.PaginaActual;
    },
    CambioMostrarPorPagina() {
      return this.Paginador.MostrarPorPagina;
    },
    CambioCajaBusqueda() {
      return this.FormBusqueda.TextoBusqueda;
    },
    CambioOrdenarPor() {
      return this.OrdenarPor;
    },
    CambioStoreProductos() {
      return  this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.ListaProductos;
    }
  },
  watch: {
    SeleccionadosCam() {
      this.validarBotonesSeleccionMultiple();
    },
    CambioPaginador() {
      this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.Paginador = this.Paginador.PaginaActual;
      this.cambiarPagina();
    },
    CambioMostrarPorPagina() {
      this.PaginacionValidar();
      var estructura = {
        OrdenarPor: this.OrdenarPor,
        MostrarElementos: this.Paginador.MostrarPorPagina
      };
      localStorage.setItem(
        "__local__catalogosProductos__preferencias",
        JSON.stringify(estructura)
      );
    },
    CambioOrdenarPor() {
      var estructura = {
        OrdenarPor: this.OrdenarPor,
        MostrarElementos: this.Paginador.MostrarPorPagina
      };
      localStorage.setItem(
        "__local__catalogosProductos__preferencias",
        JSON.stringify(estructura)
      );
        
      
     
    },
    CambioCajaBusqueda() {
      if (this.FormBusqueda.TextoBusqueda == "") {
        this.FormBusqueda.Buscando = false;

        this.PaginacionValidar();
      }
    },
    CambioStoreProductos() {
        
      this.productosTotales = this.$store.state.Interface.Dinamico.Componentes.Catalogo.Productos.ListaProductos;
      this.formatearDatos(false);
      this.PaginacionValidar();
      
    }
  }
};
</script>

<style lang="scss">
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
</style>

