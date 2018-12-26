<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
        <md-card>
          <md-card-header class="md-card-header-icon md-card-header-danger">
            <div class="card-icon">
              <md-icon>assignment_ind</md-icon>
              <span style="margin-top:5px; color:white; ">Registro de Pacientes</span>
            </div>
            <br>
            <br>
            <p>
              <font color="red">* Son obligatorios</font>
            </p>
          </md-card-header>

          <md-card-content>
            <div class="md-layout md-gutter">
              <div class="md-layout-item md-small-size-100">
                <md-field :class="[{'md-error':FormAgregarPaciente.nombre.isValid===false}]">
                  <label>
                    Nombre del paciente
                    <font color="red">*</font>
                  </label>
                  <md-input
                    type="text"
                    class="form-control"
                    v-model="FormAgregarPaciente.nombre.val"
                  ></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100">
                <md-field
                  :class="[{'md-error':FormAgregarPaciente.apellidopaterno.isValid===false}]"
                >
                  <label>
                    Apellido paterno
                    <font color="red">*</font>
                  </label>
                  <md-input
                    type="text"
                    class="form-control"
                    v-model="FormAgregarPaciente.apellidopaterno.val"
                  ></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100" v-if="switchValidado==true">
                <md-field
                  :class="[{'md-error':FormAgregarPaciente.apellidomaterno.isValid===false}]"
                >
                  <label>
                    Apellido materno
                    <font color="red">*</font>
                  </label>
                  <md-input
                    type="text"
                    class="form-control"
                    v-model="FormAgregarPaciente.apellidomaterno.val"
                  ></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100" v-else>
                <md-field>
                  <label>
                    Apellido materno
                    <font color="red">*</font>
                  </label>
                  <md-input type="text" class="form-control" v-model="apematerno"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100">
                <md-datepicker type="date" v-model="fechanacimiento">
                  <label>Fecha de nacimiento
                    <font color="red">*</font>
                  </label>
                </md-datepicker>
              </div>
            </div>

            <div class="md-layout md-gutter">
              <div class="md-layout-item">
                <md-field>
                  <label>Estado de nacimiento
                    <font color="red">*</font>
                  </label>
                  <md-select v-model="estadonaciemiento">
                    <md-option v-for="item in estadosmexico" :value="item.name">{{item.name}}</md-option>
                  </md-select>
                </md-field>
              </div>
              <div class="md-layout-item">
                <md-field>
                  <label>Nacionalidad</label>
                  <md-select v-model="nacionalidad">
                    <md-option value="Mexicana">Mexicana</md-option>
                    <md-option value="Extrangera">Extrangera</md-option>
                  </md-select>
                </md-field>
              </div>
              <div class="md-layout-item">
                <md-field>
                  <label>Sexo</label>
                  <md-select v-model="sexo">
                    <md-option value="Hombre">Hombre</md-option>
                    <md-option value="Mujer">Mujer</md-option>
                  </md-select>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100">
                <md-field>
                  <label>Tipo de sangre</label>
                  <md-input type="text" class="form-control" v-model="tipodesangre"></md-input>
                </md-field>
              </div>
            </div>

            <div class="md-layout md-gutter">
              <div class="md-layout-item md-small-size-100">
                <md-field>
                  <label>Código postal</label>
                  <md-input
                    type="text"
                    class="form-control"
                    v-model="codigopostal"
                    @input="mostrarCodigoPostal(codigopostal)"
                  ></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100">
                <md-field>
                  <label>Estado</label>
                  <md-input class="form-control" v-model="estado" disabled></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100">
                <md-field>
                  <label>Localidad</label>
                  <md-input class="form-control" v-model="localidad" disabled></md-input>
                </md-field>
              </div>
              <div class="md-layout-item">
                <md-field>
                  <label>Colonias</label>
                  <md-select v-model="colonia">
                    <md-option v-for="(item, key) in colonias" :value="item">{{item}}</md-option>
                  </md-select>
                </md-field>
              </div>
            </div>

            <div class="md-layout md-gutter">
              <div class="md-layout-item md-small-size-100">
                <md-field>
                  <label>Domicilio</label>
                  <md-input type="text" class="form-control" v-model="domicilio"></md-input>
                </md-field>
              </div>
              <div v-if="nacionalidad=='Mexicana'" class="md-layout-item md-xsmall">
                <md-field>
                  <label>CURP</label>
                  <md-input type="text" class="form-control" v-model="curp"></md-input>
                </md-field>
              </div>
              <md-button
                v-if="nacionalidad=='Mexicana'"
                class="md-info md-just-icon md-round"
                style="margin:7px"
              >
                <i class="fas fa-search"></i>
                <md-tooltip md-direction="bottom">Buscar</md-tooltip>
              </md-button>

              <md-checkbox
                v-if="nacionalidad=='Mexicana'"
                class="checboxCURP"
                style="margin:8px"
                v-model="switchValidado"
              >
                <font v-if="switchValidado==true" color="green">CURP Validada</font>
                <font v-else color="red">CURP No Validada</font>
              </md-checkbox>
            </div>

            <div class="md-layout md-gutter">
              <div class="md-layout-item md-small-size-100">
                <md-field>
                  <label>Teléfono particular</label>
                  <md-input type="tel" class="form-control" v-model="telefonoparticular"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100">
                <md-field>
                  <label>Celular particular</label>
                  <md-input type="tel" class="form-control" v-model="celularparticular"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100">
                <md-field>
                  <label>E-mail</label>
                  <md-input type="email" class="form-control" v-model="email"></md-input>
                </md-field>
              </div>
            </div>
            <!--_____________________________________ -->
            <div class="md-layout md-gutter">
              <div class="md-layout-item md-small-size-100"></div>
            </div>

          <!-- Tabla alergias-->
            <md-table
              v-model="alergias"
              table-header-color="green"
              md-sort="id"
              md-sort-order="asc"
              class="table table-striped table-hover"
              md-card
              @md-selected="onSelect"
            >
              <md-table-toolbar>
                <h1 class="md-title">Alergias</h1>
                <md-button
                  class="md-info md-just-icon md-round"
                  style="margin:7px"
                  @click="showDialog = true"
                >
                  <i class="fas fa-plus"></i>
                  <md-tooltip md-direction="bottom">Agregar</md-tooltip>
                </md-button>
                <md-button
                  v-if="selected.length > 0"
                  class="md-danger md-just-icon md-round"
                  style="float:right"
                  @click="showSwal('warning-message-and-confirmation',selected)"
                >
                  <i class="fas fa-trash"></i>
                  <md-tooltip md-direction="bottom">Eliminar</md-tooltip>
                </md-button>
              </md-table-toolbar>
              <md-table-empty-state
                md-label="No hay alergias"
                :md-description="'El paciente no tiene alergias registradas. Desea agregar una nueva alergia.'"
              >
                <md-button
                  class="md-info md-just-icon md-round"
                  style="margin:7px"
                  @click="showDialog = true"
                >
                  <i class="fas fa-plus"></i>
                  <md-tooltip md-direction="bottom">Agregar</md-tooltip>
                </md-button>
              </md-table-empty-state>
              <md-table-row
                slot="md-table-row"
                slot-scope="{ item }"
                md-selectable="multiple"
                md-auto-select
              >
                <md-table-cell md-label="#" md-sort-by="idalergia" md-numeric>{{ item.idalergia }}</md-table-cell>
                <md-table-cell md-label="Alergia">{{ item.nombrealergia }}</md-table-cell>
                <md-table-cell md-label="Fecha">{{ item.fechaalergia }}</md-table-cell>
                <md-table-cell md-label="Estado">
                  <md-switch
                    class="md-primary"
                    style="display:inline!important; margin:6px"
                    v-model="item.estadoalergia"
                    @change="showSwalDesactivar('warning-message-and-confirmation',item.idalergia,item.estadoalergia)"
                  >
                    <md-tooltip md-direction="bottom">Cambiar modo</md-tooltip>
                  </md-switch>
                </md-table-cell>
              </md-table-row>
            </md-table>
          <!-- Tabla alergias-->
            <div>
              <md-button class="md-success md-round" style="float:right" @click="AgregaPaciente()">
               <i class="fas fa-save"></i>
                <md-tooltip md-direction="bottom">Guardar</md-tooltip>
              </md-button>
              <md-button class="md-warning md-round" style="float:left">
                <i class="fas fa-angle-left"></i>
                <md-tooltip md-direction="bottom">Volver</md-tooltip>
              </md-button>
            </div>
          </md-card-content>
        </md-card>
      </div>

      <div>
        <md-dialog :md-active.sync="showDialog">
          <md-dialog-title>Registrar Alergia</md-dialog-title>
          <md-dialog-content>
            <div class="md-layout">
              <div>
                <div class="md-layout md-gutter">
                  <div class="md-layout-item md-small-size-100">
                    <md-field>
                      <label>Alergia</label>
                      <md-input class="form-control" type="tel" v-model="nombrealergia"></md-input>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-small-size-100">
                    <md-datepicker :format="customFormatter" v-model="event_at">
                      <label>Fecha</label>
                    </md-datepicker>
                  </div>
                </div>
              </div>
            </div>
          </md-dialog-content>
          <md-dialog-actions>
            <md-button class="md-warning" @click="showDialog = false">
              <i class="fas fa-times"></i>
              <md-tooltip md-direction="bottom">Volver</md-tooltip>
            </md-button>
            <md-button class="md-success" @click="guardarAlergia()">
              <md-icon>save</md-icon>
              <md-tooltip md-direction="bottom">Guardar</md-tooltip>
            </md-button>
          </md-dialog-actions>
        </md-dialog>
      </div>
    </div>
  </div>
</template>


<script>
import swal from "sweetalert2";
import moment from "moment";

export default {
  name: "RegularCheckboxes",
  data() {
    return {
      FormAgregarPaciente: {
        nombre: {
          val: "",
          isValid: null
        },
        apellidopaterno: {
          val: "",
          isValid: null
        },
        apellidomaterno: {
          val: "",
          isValid: null
        }
      },
      idpaciente: 0,
      apematerno: "",
      domicilio: "",
      colonias: "",
      localidad: "",
      estado: "",
      codigopostal: "",
      telefonoparticular: "",
      celularparticular: "",
      fechanacimiento: "",
      curp: "",
      tipodesangre: "",
      email: "",
      colonia: "",
      switchValidado: false,
      estadopaciente: true,
      sexo: "",
      nacionalidad: "Mexicana",
      idalergia: 0,
      nombrealergia: "",
      event_at: new Date(),
      fechaalergia: "",
      estadoalergia: true,
      alergias: [],
      selected: [],
      pacientes: [],
      showDialog: false,
      estadonaciemiento: "",
      estadosmexico: [
        { name: "Aguascalientes" },
        { name: "Baja California" },
        { name: "Baja California Sur" },
        { name: "Campeche" },
        { name: "Coahuila" },
        { name: "Colima" },
        { name: "Chiapas" },
        { name: "Chihuahua" },
        { name: "Distrito Federal" },
        { name: "Durango" },
        { name: "Guanajuato" },
        { name: "Guerrero" },
        { name: "Hidalgo" },
        { name: "Jalisco" },
        { name: "México" },
        { name: "Michoacán" },
        { name: "Morelos" },
        { name: "Nayarit" },
        { name: "Nuevo León" },
        { name: "Oaxaca" },
        { name: "Puebla" },
        { name: "Querétaro" },
        { name: "Quintana Roo" },
        { name: "San Luis Potosí" },
        { name: "Sinaloa" },
        { name: "Sonora" },
        { name: "Tabasco" },
        { name: "Tamaulipas" },
        { name: "Tlaxcala" },
        { name: "Veracruz" },
        { name: "Yucatán" },
        { name: "Zacatecas" }
      ]
    };
  },
  methods: {
    AgregaPaciente() {
      this.ValidarFormulario();

      if (
        this.FormAgregarPaciente.nombre.val != "" &&
        this.FormAgregarPaciente.apellidopaterno.val != ""
      ) {
        if (
          this.switchValidado == true &&
          this.FormAgregarPaciente.apellidomaterno.val != ""
        ) {
          this.guardarPaciente();
        } else {
        }
        if (this.switchValidado == false) {
          this.guardarPaciente();
        }
      } else {
      }
    },
    ValidarFormulario() {
      if (this.FormAgregarPaciente.nombre.val != "") {
        this.FormAgregarPaciente.nombre.isValid = true;
      } else {
        this.FormAgregarPaciente.nombre.isValid = false;
      }

      if (this.FormAgregarPaciente.apellidopaterno.val != "") {
        this.FormAgregarPaciente.apellidopaterno.isValid = true;
      } else {
        this.FormAgregarPaciente.apellidopaterno.isValid = false;
      }

      if (this.FormAgregarPaciente.apellidomaterno.val != "") {
        this.FormAgregarPaciente.apellidomaterno.isValid = true;
      } else {
        this.FormAgregarPaciente.apellidomaterno.isValid = false;
      }
    },
    mostrarCodigoPostal(cp) {
      console.log("llega al método");
      if (cp.length >= 5) {
        var ths = this;
        ths.colonias = "";
        ths.colonia = "";
        const axios = require("axios");

        var liga =
          "https://api-codigos-postales.herokuapp.com/v2/codigo_postal/" + cp;

        axios
          .get(liga)
          .then(function(response) {
            ths.estado = response.data.estado;
            ths.localidad = response.data.municipio;
            ths.colonias = response.data.colonias;
          })
          .catch(function(error) {});
      } else {
        console.log("CP incompleto");
      }
    },
    onSelect(items) {
      this.selected = items;
    },
    getAlternateLabel(count) {
      let plural = "";

      if (count > 1) {
        plural = "s";
      }

      return `${count} user${plural} selected`;
    },
    guardarPaciente: function() {
      var apmaterno = "";

      if (this.switchValidado == true) {
        apmaterno = this.FormAgregarPaciente.apellidomaterno.val;
      } else {
        apmaterno = this.apematerno;
      }

      this.pacientes.push({
        idPaciente: this.idpaciente,
        Nombre: this.FormAgregarPaciente.nombre.val,
        ApellidoPaterno: this.FormAgregarPaciente.apellidopaterno.val,
        ApellidoMaterno: apmaterno,
        FechaNacimiento: this.fechanacimiento,
        EstadoNacimiento: this.estadonacimiento,
        Nacionalidad: this.nacionalidad,
        Sexo: this.sexo,
        TipoDeSangre: this.tipodesangre,
        CodigoPostal: this.codigopostal,
        Estado: this.estado,
        Localidad: this.localidad,
        Colonia: this.colonia,
        Domicilio: this.domicilio,
        Curp: this.curp,
        CurpValidada: this.switchValidado,
        TelefonoParticular: this.telefonoparticular,
        CelularParticular: this.celularparticular,
        Email: this.email,
        EstadoPaciente: this.estadopaciente
      });
      this.FormAgregarPaciente.nombre.val = "";
      this.FormAgregarPaciente.apellidopaterno.val = "";
      this.FormAgregarPaciente.apellidomaterno.val = "";
      this.apematerno = "";
      this.fechanacimiento = "";
      this.estadonacimiento = "";
      this.nacionalidad = "";
      this.tipodesangre = "";
      this.codigopostal = "";
      this.estado = "";
      this.sexo = "";
      this.localidad = "";
      this.colonia = "";
      this.domicilio = "";
      this.curp = "";
      this.telefonoparticular = "";
      this.celularparticular = "";
      this.email = "";
      this.idpaciente++;

      this.store_post();
    },
    customFormatter(date) {
      return moment(date).format("D MMMM YYYY");
    },
    guardarAlergia: function() {
      var fech = "";
      this.fechaalergia = "" + this.event_at;
      fech = moment(this.fechaalergia).format("YYYY MMM D");

      this.alergias.push({
        idalergia: this.idalergia,
        nombrealergia: this.nombrealergia,
        fechaalergia: fech,
        estadoalergia: this.estadoalergia
      });
      (this.nombrealergia = ""),
        (this.fechaalergia = ""),
        (fech = ""),
        this.event_at,
        (this.showDialog = false);
      this.idalergia++;
    },
    desactivarAlergias: function(idale, estado) {
      if (estado == false) {
        this.alergias.forEach(function(element) {
          if (element.idalergia == idale) {
            element.estadoalergia = false;
          }
        });
      } else {
        this.alergias.forEach(function(element) {
          if (element.idalergia == idale) {
            element.estadoalergia = true;
          }
        });
      }
    },
    showSwal(type, seleccionados) {
      var ths = this;
      var arreglo = [];
      var i = 0;
      var tamarre = arreglo.length;
      var tamalergias = ths.alergias.length;

      seleccionados.forEach(function(element) {
        arreglo[i] = "" + element.idalergia;
        i++;
      });

      if (type === "warning-message-and-confirmation") {
        var cantidad = this.selected.length;
        var txtMostrar = "";

        if (cantidad > 1) {
          txtMostrar = "Intentas eliminar más de una alergia?";
        } else {
          txtMostrar = "Intentas eliminar una alergia?";
        }
        swal({
          title: "Estás seguro?",
          text: "" + txtMostrar,
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "md-button md-success",
          cancelButtonClass: "md-button md-danger",
          confirmButtonText: "Sí, eliminar",
          buttonsStyling: false
        }).then(result => {
          if (tamarre == tamalergias) {
            ths.alergias.splice(0, tamalergias);
            arreglo.splice(0, tamarre);
            seleccionados.splice(0, tamarre);
            if (result.value) {
              swal({
                title: "Eliminadas",
                text: "",
                type: "success",
                confirmButtonClass: "md-button md-success",
                buttonsStyling: false,
                estado: false
              });
            }
          } else {
            var txtTitle = "";
            if (tamarre > 1) {
              txtTitle = "Eliminadas";
            } else {
              txtTitle = "Eliminada";
            }
            arreglo.forEach(function(arreglo) {
              ths.alergias.forEach(function(element, key) {
                if (arreglo == element.idalergia) {
                  ths.alergias.splice(key, 1);
                }
              });
            });
            if (result.value) {
              swal({
                title: "" + txtTitle,
                text: "",
                type: "success",
                confirmButtonClass: "md-button md-success",
                buttonsStyling: false,
                estado: false
              });
            }
          }
        });
      }
    },
    eliminarAlergia: function(seleccionados) {
      var ths = this;
      var arreglo = [];
      var i = 0;
      var tamarre = arreglo.length;
      var tamalergias = ths.alergias.length;

      seleccionados.forEach(function(element) {
        arreglo[i] = "" + element.idalergia;
        i++;
      });

      if (tamarre == tamalergias) {
        ths.alergias.splice(0, tamalergias);
        arreglo.splice(0, tamarre);
        seleccionados.splice(0, tamarre);
      } else {
        arreglo.forEach(function(arreglo) {
          ths.alergias.forEach(function(element, key) {
            if (arreglo == element.idalergia) {
              ths.alergias.splice(key, 1);
            }
          });
        });
      }
    },
    showSwalDesactivar(type, idale, estado) {
      var txtMostrar = "";
      var txtTitle = "";
      var txtConfirmation = "";

      if (estado == false) {
        txtMostrar = "Intentas desactivar una alergia?";
        txtTitle = "Desactivada";
        txtConfirmation = "Si, desactivar";
      } else {
        txtMostrar = "Intentas activar una alergia?";
        txtTitle = "Activada";
        txtConfirmation = "Si, activar";
      }

      if (type === "warning-message-and-confirmation") {
        swal({
          title: "Estás seguro?",
          text: "" + txtMostrar,
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "md-button md-success",
          cancelButtonClass: "md-button md-danger",
          confirmButtonText: "" + txtConfirmation,
          buttonsStyling: false
        }).then(result => {
          if (result.value) {
            swal({
              title: "" + txtTitle,
              text: "",
              type: "success",
              confirmButtonClass: "md-button md-success",
              buttonsStyling: false,
              estado: false
            });
            if (estado == false) {
              this.alergias.forEach(function(element) {
                if (element.idalergia == idale) {
                  element.estadoalergia = false;
                }
              });
            } else {
              this.alergias.forEach(function(element) {
                if (element.idalergia == idale) {
                  element.estadoalergia = true;
                }
              });
            }
          } else {
            if (estado == false) {
              this.alergias.forEach(function(element) {
                if (element.idalergia == idale) {
                  element.estadoalergia = true;
                }
              });
            } else {
              this.alergias.forEach(function(element) {
                if (element.idalergia == idale) {
                  element.estadoalergia = false;
                }
              });
            }
          }
        });
      }
    },
    store_post() {
      const axios = require("axios");
     let ths = this;
      var liga = "http://192.168.100.150/store/atencion-medica/pacientes/";

      axios
        .post(liga, {
          data: ths.pacientes,
          type: "insercion_unica"
        })
        .then(function(response) {
          console.log(response.data);
        })
        .catch(function(error) {});
    }
  }
};
</script>

<style>
.card-body {
  text-align: center;
}
.md-checkbox {
  display: flex;
  justify-content: center;
  align-items: center;
}

.btn-centrado {
  text-align: center;
}
</style>
