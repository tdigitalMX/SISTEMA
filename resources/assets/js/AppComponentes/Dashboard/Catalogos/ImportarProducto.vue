<template>
  <div>
    <md-card>
      <md-card-header header-color="blue" class="md-card-header-text md-card-header-danger">
        <div class="card-text">
          <h4 class="title">
            <i class="fas fa-upload"></i>Importar
          </h4>
        </div>
      </md-card-header>
      <md-card-content>
        <br>
        <h6>*Solo se permiten archivos con formato .xlsx</h6>
        <br>
        <div class="md-layout">
          <div class="md-layout-item md-xsmall-size-100 md-size-75">
            <!--<md-field>
              <label>Selecciona archivo de Excel</label>
              <md-file/>
            </md-field>-->
            <md-button @click="selectArchivo" class="md-simple" style="margin-left: -35px;">
              <md-icon>attach_file</md-icon>Selecciona un archivo Excel
            </md-button>
            <br>
            <md-field disabled style="margin-top: -18px;">
              <md-input v-model="nombreArchivo" disabled></md-input>
            </md-field>

            <input @change="validar($event)" type="file" style="visibility:hidden" id="file">
          </div>
          <div class="md-layout-item md-xsmall-size-100 md-size-25">
            <md-button v-if="iniciarImportacion" @click="leerExcel" class="md-warning">Cargar</md-button>
          </div>
        </div>
        <md-snackbar
          md-position="center"
          :md-duration="Infinity"
          :md-active.sync="alertaError"
          md-persistent
        >
          <span>El archivo que elegiste no es valido, intenta con otro</span>
          <md-button class="md-danger" @click="alertaError = false">Ok</md-button>
        </md-snackbar>

        <md-snackbar
          md-position="center"
          :md-duration="6000"
          :md-active.sync="alertaError2"
          md-persistent
        >
          <span>Elige una opcion para los campos obligatorios</span>
          <md-button class="md-danger" @click="alertaError2 = false">Ok</md-button>
        </md-snackbar>

        <md-snackbar
          md-position="center"
          :md-duration="6000"
          :md-active.sync="respuestaServidor"
          md-persistent
        >
          <span>{{ mensajeServidor}}</span>
          <md-button class="md-danger" @click="alertaError2 = false">Ok</md-button>
        </md-snackbar>

        <br>

        <div v-if="leyendo===true">
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
        <br>
        <br>

        <div v-if="leyendo===false && iniciarImportacion && DatosExcel !== null">
          <div class="md-layout">
            <div class="md-layout-item md-xsmall-size-100 md-size-50">
              <span>Codigo De Barras*</span>
            </div>
            <div class="md-layout-item md-xsmall-size-100 md-size-50">
              <md-field>
                <label for="movie">¿Cual corresponde a codigo de barras?</label>
                <md-select v-model="camposImportar.CodigoDeBarras" name="Selecciona" id="movie">
                  <md-option v-for="(item, key) in datosExcel[0]" :value="key">{{key}}</md-option>
                </md-select>
              </md-field>
            </div>
          </div>
          <div class="md-layout">
            <div class="md-layout-item md-xsmall-size-100 md-size-50">
              <span>Nombre Comercial*</span>
            </div>
            <div class="md-layout-item md-xsmall-size-100 md-size-50">
              <md-field>
                <label for="movie">¿Cual corresponde a nombre comercial?</label>
                <md-select v-model="camposImportar.NombreComercial" name="Selecciona" id="movie">
                  <md-option v-for="(item, key) in datosExcel[0]" :value="key">{{key}}</md-option>
                </md-select>
              </md-field>
            </div>
          </div>
          <div class="md-layout">
            <div class="md-layout-item md-xsmall-size-100 md-size-50">
              <span>Nombre Generico*</span>
            </div>
            <div class="md-layout-item md-xsmall-size-100 md-size-50">
              <md-field>
                <label for="movie">¿Cual corresponde a nombre generico?</label>
                <md-select v-model="camposImportar.NombreGenerico" name="Selecciona" id="movie">
                  <md-option v-for="(item, key) in datosExcel[0]" :value="key">{{key}}</md-option>
                </md-select>
              </md-field>
            </div>
          </div>
          <div class="md-layout">
            <div class="md-layout-item md-xsmall-size-100 md-size-50">
              <span>Forma Farmacéutica*</span>
            </div>
            <div class="md-layout-item md-xsmall-size-100 md-size-50">
              <md-field>
                <label for="movie">¿Cual corresponde a forma farmacéutica?</label>
                <md-select v-model="camposImportar.FormaFarmaucetica" name="Selecciona" id="movie">
                  <md-option v-for="(item, key) in datosExcel[0]" :value="key">{{key}}</md-option>
                </md-select>
              </md-field>
            </div>
          </div>
          <div class="md-layout">
            <div class="md-layout-item md-xsmall-size-100 md-size-50">
              <span>Presentación*</span>
            </div>
            <div class="md-layout-item md-xsmall-size-100 md-size-50">
              <md-field>
                <label for="movie">¿Cual corresponde a forma presentacion?</label>
                <md-select v-model="camposImportar.Presentacion" name="Selecciona" id="movie">
                  <md-option v-for="(item, key) in datosExcel[0]" :value="key">{{key}}</md-option>
                </md-select>
              </md-field>
            </div>
          </div>
          <div class="md-layout">
            <div class="md-layout-item md-xsmall-size-100 md-size-50">
              <span>Contenido*</span>
            </div>
            <div class="md-layout-item md-xsmall-size-100 md-size-50">
              <md-field>
                <label for="movie">¿Cual corresponde a forma contenido?</label>
                <md-select v-model="camposImportar.Contenido" name="Selecciona" id="movie">
                  <md-option v-for="(item, key) in datosExcel[0]" :value="key">{{key}}</md-option>
                </md-select>
              </md-field>
            </div>
          </div>
          <div class="md-layout">
            <div class="md-layout-item md-xsmall-size-100 md-size-50">
              <span>Comentarios</span>
            </div>
            <div class="md-layout-item md-xsmall-size-100 md-size-50">
              <md-field>
                <label for="movie">¿Cual corresponde a comentarios?</label>
                <md-select v-model="camposImportar.Comentarios" name="Selecciona" id="movie">
                  <md-option v-for="(item, key) in datosExcel[0]" :value="key">{{key}}</md-option>
                   <md-option value="null"></md-option>
                </md-select>
              </md-field>
            </div>
          </div>
          <br>
          <br>
        </div>

        <md-button @click="regresar" class="md-warning md-round" style="float:left">
            <md-icon>keyboard_arrow_left</md-icon>Volver
          </md-button>

        <md-button
          v-if="leyendo===false && iniciarImportacion && DatosExcel !== null"
          @click="importar"
          class="md-success md-round"
          style="float:right"
        >
          <i class="fas fa-upload"></i> Importar
        </md-button>
        <br>
        <br>
      </md-card-content>
    </md-card>
  </div>
</template>
<script>
import swal from "sweetalert2";
import $ from "jquery";
export default {
  data() {
    return {
      archivo: null,
      nombreArchivo: "",
      leyendo: null,
      archivoLeer: null,
      alertaError: false,
      alertaError2: false,
      iniciarImportacion: false,
      datosExcel: null,
      camposImportar: {
        CodigoDeBarras: null,
        NombreComercial: null,
        NombreGenerico: null,
        FormaFarmaucetica: null,
        Presentacion: null,
        Contenido: null,
        Comentarios: null
      },
      datosParaImportar: [],
      mensajeServidor: "",
      respuestaServidor: false
    };
  },
  methods: {
    validar(e) {
      this.archivo = e;
      if (this.archivo.target.files.length > 0) {
        var archivo = this.archivo.target.files[0];
        this.nombreArchivo = archivo.name;
        var extencion = archivo.name.split(".");
        if (extencion[1] == "xlsx") {
          this.archivoLeer = archivo;
          this.iniciarImportacion = true;
        } else {
          this.iniciarImportacion = false;
          this.alertaError = true;
          this.archivo = null;
          this.datosExcel = null;
          this.nombreArchivo = "";
          this.leyendo = false;
        }
      } else {
        this.archivo = null;
        this.nombreArchivo = "";
        this.datosExcel = null;
        this.iniciarImportacion = false;
        this.leyendo = false;
      }
    },
    leerExcel() {
      if (this.iniciarImportacion) {
        this.camposImportar = {
          CodigoDeBarras: null,
          NombreComercial: null,
          NombreGenerico: null,
          FormaFarmaucetica: null,
          Presentacion: null,
          Contenido: null,
          Comentarios: null
        };
        this.datosExcel = null;
        this.leyendo = true;
        var archivo = this.archivoLeer;
        var reader = new FileReader();
        var nombre = archivo.name;

        var ths = this;

        reader.onload = function(e) {
          var data = e.target.result;

          var result;

          try {
            var workbook = XLSX.read(data, { type: "binary" });
            var sheet_name_list = workbook.SheetNames;
            sheet_name_list.forEach(function(y) {
              var roa = XLSX.utils.sheet_to_json(workbook.Sheets[y]);
              if (roa.length > 0) {
                result = roa;
              }
            });

            ths.datosExcel = result;
          } catch (err) {
            ths.leyendo = false;
            ths.iniciarImportacion = false;
            ths.datosExcel = null;
            ths.archivo = null;
            ths.nombreArchivo = "";
            ths.archivoLeer = null;
            ths.alertaError = true;
            return;
          }
        };

        reader.readAsArrayBuffer(archivo);
      }
    },
    cambiosEnDatosExcel() {
      if (this.datosExcel !== null) {
        var ths = this;
        setTimeout(function() {
          ths.leyendo = false;
        }, 500);
      } else {
        this.leyendo = true;
      }
    },
    selectArchivo() {
      $("#file").click();
    },
    importar() {
      if (this.iniciarImportacion) {
        if (
          this.camposImportar.CodigoDeBarras !== null &&
          this.camposImportar.NombreComercial !== null &&
          this.camposImportar.NombreGenerico !== null &&
          this.camposImportar.FormaFarmaucetica !== null &&
          this.camposImportar.Presentacion !== null &&
          this.camposImportar.Contenido !== null
        ) {
          this.leyendo = true;
          var ths = this;
          this.datosParaImportar = [];
          this.datosExcel.forEach(function(element) {
            if(ths.camposImportar.Comentarios == "null"){
              var comentarios = ""
            }else{
              var comentarios = element[ths.camposImportar.Comentarios];
            }
            var data = {
              CodigoDeBarras: element[ths.camposImportar.CodigoDeBarras],
              NombreComercial: element[ths.camposImportar.NombreComercial],
              NombreGenerico: element[ths.camposImportar.NombreGenerico],
              FormaFarmaucetica: element[ths.camposImportar.FormaFarmaucetica],
              Presentacion: element[ths.camposImportar.Presentacion],
              Contenido: element[ths.camposImportar.Contenido],
              Comentarios: comentarios,
               Estado: true
            };
            ths.datosParaImportar.push(data);
          });
          this.subirServidor();
        } else {
          this.alertaError2 = true;
        }
      }
    },
    subirServidor() {
      var ths = this;
      this.$http
        .post("/store/catalogos/productos", {
          data: ths.datosParaImportar,
          type: "import"
        })
        .then(
          response => {
            var respuesta = response.data;
            if (respuesta.solicitud && respuesta.estatus) {
              ths.archivo = null;
              ths.nombreArchivo = "";
              ths.archivoLeer = null;
              ths.leyendo = false;
              ths.iniciarImportacion = false;
              swal({
                title: "Correcto",
                text: "Los datos se han importado correctamente",
                type: "success",
                confirmButtonClass: "md-button md-success",
                buttonsStyling: false
              });
              ths.datosExcel = [];
              ths.datosParaImportar = [];
              ths.$router.push("/catalogo/productos");
            } else {
              ths.archivo = null;
              ths.nombreArchivo = "";
              ths.archivoLeer = null;
              ths.leyendo = false;
              ths.iniciarImportacion = false;
              swal({
                title: "Error",
                text: "Ocurrio un error, intentalo de nuevo",
                type: "error",
                confirmButtonClass: "md-button md-success",
                buttonsStyling: false
              });
              ths.datosExcel = []
              ths.datosParaImportar = [];
            }
          },
          error => {
            ths.archivo = null;
            ths.nombreArchivo = "";
            ths.archivoLeer = null;
            ths.leyendo = false;
            ths.iniciarImportacion = false;
            swal({
              title: "Error",
              text: "Ocurrio un error, intentalo de nuevo",
              type: "error",
              confirmButtonClass: "md-button md-success",
              buttonsStyling: false
            });
            ths.datosExcel = [];
            ths.datosParaImportar = [];
          }
        );
    },
       regresar() {
    

      this.$router.push("/catalogo/productos");
    }
  },
  computed: {
    DatosExcel() {
      return this.datosExcel;
    }
  },
  watch: {
    DatosExcel() {
      this.cambiosEnDatosExcel();
    }
  }
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

.md-select-menu .md-list-item .md-list-item-button:hover {
  background-color: #ea4542 !important;
}
.md-select-menu .md-list-item .md-list-item-button:hover {
  background-color: #ea4542 !important;
}
.md-field:before {
  background-color: black !important;
}
</style>
