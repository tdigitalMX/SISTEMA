<template>
  <div class="content">{{ cargar() }}</div>
</template>

<script>
export default {
  methods: {
    cargar() {
      var ex = [];

      for (var i = 0; i <= 100; i++) {
        var h = {
          CodigoDeBarras: i,
          NombreComercial: parseInt(Math.random()*10),
          NombreGenerico: parseInt(Math.random()*10),
          FormaFarmaucetica: parseInt(Math.random()*10),
          Presentacion: parseInt(Math.random()*10),
          Contenido: parseInt(Math.random()*10),
          Estado: true
        };

        ex.push(h);

      }

      return ex;
    }
  }
};
</script>

<style>
</style>
