<template>
  <div class="md-layout">
    <div class="md-layout-item">
      <md-card>
        <md-card-header header-color="blue" class="md-card-header-text md-card-header-danger">
          <div class="card-text">
            <h4 class="title">
              <md-icon>list</md-icon>Grupo
            </h4>
          </div>
        </md-card-header>
        <md-card-content>
          <div v-if="Grupos.length > 0">
            <div style="float:right">
              <div>
                <md-button class="md-success md-sm" :to="'form-grupos'">
                  <i class="fas fa-plus"></i> Agregar grupo
                </md-button>
                <md-button class="md-warning md-sm">
                  <i class="fas fa-upload"></i> Importar
                </md-button>
                <md-button class="md-info md-sm">
                  <i class="fas fa-download"></i> Exportar
                </md-button>
              </div>
              <br>
              <br>
            </div>

            <div class="md-layout">
              <div class="md-layout-item md-xsmall-size-100 md-size-25">
                <md-field>
                  <label for="movie">Tipo busqueda</label>
                  <md-select v-model="movie" name="Selecciona" id="movie">
                    <md-option value="fight-club">Codigo</md-option>
                    <md-option value="godfather">Nombre comercial</md-option>
                  </md-select>
                </md-field>
              </div>
              <div class="md-layout-item md-xsmall-size-100 md-size-25">
                <md-field>
                  <label>Busqueda</label>
                  <md-input v-model="FormBusqueda.TextoBusqueda"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-xsmall-size-100 md-size-25">
                <md-button class="md-danger">
                  <i class="fas fa-search"></i> Buscar
                </md-button>
              </div>
            </div>

            <br>
            <br>
            <md-table v-model="Grupos" table-header-color="dark" class="table-striped">
              <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell :md-label="''">
                  <md-checkbox v-model="Seleccionados" :value="item.Codigo"></md-checkbox>
                </md-table-cell>
                <md-table-cell md-label="Nombre">{{ item.Codigo }}</md-table-cell>
                <md-table-cell md-label="Nombre comun">{{ item.NombreComun }}</md-table-cell>
                <md-table-cell md-label="Receta">{{ item.Receta }}</md-table-cell>
                <md-table-cell md-label="Opciones">
                  <div style="display: inline-block!important">
                    <md-switch
                      v-if="item.Estado"
                      @change="desactivar(item.Codigo)"
                      style="position:absolute"
                      v-model="item.Estado"
                    ></md-switch>
                    <md-switch
                      v-else
                      @change="activar(item.Codigo)"
                      style="position:absolute"
                      v-model="item.Estado"
                    ></md-switch>
                    <div style="margin-left:45px;margin-top:12px">
                      <md-button class="md-warning md-just-icon md-round">
                        <i class="fas fa-pencil-alt"></i>
                      </md-button>
                      <md-button v-if="!item.Estado" class="md-danger md-just-icon md-round">
                        <i class="fas fa-trash"></i>
                      </md-button>
                    </div>
                  </div>
                </md-table-cell>
              </md-table-row>
            </md-table>
          </div>
          <div v-else>
            <center>
              <h5 style="margin-top:80px">
                <i class="fas fa-exclamation-circle"></i> Aqui no hay nada, prueba agregando un grupo
              </h5>
              <br>
              <md-button style="margin-bottom:80px" class="md-round md-danger" :to="'form-grupos'">
                <md-icon>add</md-icon>Registrar grupo
              </md-button>
            </center>
          </div>
          <div v-if="Seleccionados.length > 0">
            <br>
            <h6>Acciones para seleccionado(s):</h6>
            <md-button
              @click="activarSeleccionados"
              class="md-success md-just-icon md-round color-green"
            >
              <md-icon>done</md-icon>
              <md-tooltip md-direction="bottom">Activar</md-tooltip>
            </md-button>
            <md-button @click="desactivarSeleccionados" class="md-re md-just-icon md-round">
              <md-icon>clear</md-icon>
              <md-tooltip md-direction="bottom">Desactivar</md-tooltip>
            </md-button>
            <md-button v-if="EliminarMultiple" class="md-danger md-just-icon md-round">
              <i class="fas fa-trash"></i>
            </md-button>
          </div>
        </md-card-content>
      </md-card>
      
    </div>
  </div>
</template>

<script>
import StatsCard from "../../../../components/Cards/StatsCard.vue";
import Modal from "../../../../components/Modal.vue";
import swal from "sweetalert2";
import $ from "jquery";

export default {
  data() {
    return {
      Seleccionados: [],
      EliminarMultiple: false,
      modalAlertaDesactivar: false,
      confirmarDesactivar: false,
      itemADesactivar: "",
      Grupos: [
        {
          Nombre: 1,
          NombreComun: 2,
          Receta: 3,
          Estado: true,
          Codigo: 5
        }
      ],
      FormBusqueda: {
        Tipo: "",
        TextoBusqueda: ""
      }
    };
  },
  created() {},
  mounted() {},
  methods: {
    BuscarProductos() {},
    AgregarProducto() {
      this.ValidarFormulario();
    },
    ValidarFormulario() {
      if (
        this.FormAgregarProducto.Codigo.val != null &&
        this.FormAgregarProducto.Codigo.val > 0
      ) {
        this.FormAgregarProducto.Codigo.isValid = true;
      } else {
        this.FormAgregarProducto.Codigo.isValid = false;
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
      this.Grupos.forEach(function(element) {
        if (element.Codigo == ths.itemADesactivar) {
          element.Estado = true;
        }
      });

      swal({
        title: "¿Estas seguro?",
        text: "Estas intentando desactivar un grupo",
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
          this.Grupos.forEach(function(element) {
            if (element.Codigo == ths.itemADesactivar) {
              element.Estado = false;
            }
          });
           this.validarBotonesSeleccionMultiple();
          swal({
            title: "Se ha desactivado",
            text: "Este grupo se ha desactivado satisfactoriamente",
            type: "success",
            confirmButtonClass: "md-button md-success",
            buttonsStyling: false
          });
        } else if (result.dismiss === swal.DismissReason.cancel) {
          this.Grupos.forEach(function(element) {
            if (element.Codigo == ths.itemADesactivar) {
              element.Estado = true;
            }
          });
        }
      });
    },
    activar() {
         swal({
        title: "Completado",
        text: "Se ha activado este grupo",
        type: "success",
        confirmButtonClass: "md-button md-success",
        buttonsStyling: false
      });
      this.validarBotonesSeleccionMultiple();
    },
    validarBotonesSeleccionMultiple() {
      var ths = this;
      var Activados = 0;
      this.Seleccionados.forEach(function(element) {
        ths.Grupos.forEach(function(element2) {
          if (element == element2.Codigo) {
            if (element2.Estado) {
              Activados++;
            }
          }
        });
      });

      if (Activados > 0) {
        this.EliminarMultiple = false;
      } else {
        this.EliminarMultiple = true;
      }
    },
    activarSeleccionados() {
      var ths = this;
      this.Seleccionados.forEach(function(element) {
        ths.Grupos.forEach(function(element2) {
          if (element == element2.Codigo) {
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
    },
      desactivarSeleccionados() {
      var ths = this;
      swal({
        title: "¿Estas seguro?",
        text: "Estas intentando desactivar uno o varios grupos",
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
          this.Seleccionados.forEach(function(element) {
            ths.Grupos.forEach(function(element2) {
              if (element == element2.Codigo) {
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
      });
    }
  },
  components: {
    StatsCard,
    Modal
  },
  computed: {
    SeleccionadosCam() {
      return this.Seleccionados;
    }
  },
  watch: {
    SeleccionadosCam() {
      this.validarBotonesSeleccionMultiple();
    }
  }
};
</script>

<style>
.md-select-menu .md-list-item .md-list-item-button:hover {
  background-color: #ea4542 !important;
}
.md-field:before {
  background-color: black !important;
}

.md-switch.md-checked .md-switch-container {
  background-color: rgb(76, 175, 80) !important;
}

.md-switch.md-checked .md-switch-thumb {
  border: 1px solid #4caf50;
}
</style>

