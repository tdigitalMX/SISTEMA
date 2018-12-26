<template>
  <div class="md-layout">
    <div class="md-layout-item">
      <md-card>
        <md-card-header header-color="blue" class="md-card-header-text md-card-header-warning">
          <div class="card-text">
            <h4 class="title">
              <md-icon>add</md-icon>Agregar grupo
            </h4>
          </div>
        </md-card-header>
        <md-card-content>
          <h6>Llena los siguientes campos (Campos con * son obligatorios)</h6>

          <md-field :class="[{'md-error':FormAgregarGrupo.Nombre.isValid===false}]">
            <label>Nombre*</label>
            <md-input v-model="FormAgregarGrupo.Nombre.val" number="true"></md-input>
            <span class="md-helper-text"></span>
          </md-field>
          <br>
          <md-field>
            <label>Nombre comun</label>
            <md-input v-model="FormAgregarGrupo.NombreComun.val"></md-input>
            <span class="md-helper-text"></span>
          </md-field>
          <br>
          <md-field :class="[{'md-error':FormAgregarGrupo.Receta.isValid===false}]">
            <label>Receta*</label>
            <md-input v-model="FormAgregarGrupo.Receta.val"></md-input>
            <span class="md-helper-text"></span>
          </md-field>
                    <br>
          <center>
            <md-button class="md-warning md-round" @click="AgregarGrupo">
              <i class="fas fa-save"></i> Guardar grupo
            </md-button>
          </center>
        </md-card-content>
      </md-card>
      <md-button :to="'/catalogo/clasificacion'" class="md-warning md-round">
        <md-icon>keyboard_arrow_left</md-icon>Volver
      </md-button>
    </div>
  </div>
</template>

<script>
import Notifications from "../../../../components/NotificationPlugin";

export default {
  data() {
    return {
      FormAgregarGrupo: {
        Nombre: {
          val: "",
          isValid: null
        },
        NombreComun: {
          val: "",
          isValid: null
        },
        Receta: {
          val: "",
          isValid: null
        },
        
      }
    };
  },
  methods: {
    AgregarGrupo() {
      if (this.ValidarFormulario()) {
      }
    },
    ValidarFormulario() {
      var itemsTotal = 2;
      var itemsVal = 0;
      if (
        this.FormAgregarGrupo.Nombre.val != "" ) {
        this.FormAgregarGrupo.Nombre.isValid = true;
        itemsVal++;
      } else {
        this.FormAgregarGrupo.Nombre.isValid = false;
      }
     

      if (this.FormAgregarGrupo.Receta.val != "") {
        this.FormAgregarGrupo.Receta.isValid = true;
        itemsVal++;
      } else {
        this.FormAgregarGrupo.Receta.isValid = false;
      }

      
      if (itemsTotal == itemsVal) {
        return true;
      } else {
        return false;
      }
    }
  }
};
</script>

<style>
.md-field:before {
  background-color: black !important;
}
</style>
