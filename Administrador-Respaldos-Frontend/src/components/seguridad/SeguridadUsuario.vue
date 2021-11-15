<template>
  <div>
    <div class="select-box">
      <select id="seleccionar" ref="comboBoxT" @change="cambiarEleccion">
        <option value="default" selected="Selected" disabled>
          -Seleccione un tipo de acción--
        </option>
        <option value="1">Asignar Designar Roles</option>
        <option value="2">Consultar Roles</option>
        <option value="3">Crear Rol</option>
      </select>
      <button @click="elegir" :disabled="sent || !opcion">
        Elegir Opcion de Seguridad
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      opcion: null,
      sent: false,
    };
  },
  methods: {
    elegir: function () {
      this.sent = true;

      switch (this.opcion) {
        case 1:
          this.$router.push("/seguridad-usuario/asignacion-rol");
          break;
        case 2:
          this.$router.push("/seguridad-usuario/consultar-rol");
          break;
        case 3:
          this.$router.push("/seguridad-usuario/crear-rol");
          break;

        default:
          break;
      }
    },
    cambiarEleccion: function (e) {
      this.opcion = e.target.value;
      this.sent = false;
      console.log(this.opcion);
    },
  },
};
</script>

<style scoped>
@import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro);

body {
  background: #ffffff;
  color: #414141;
  font: 400 17px/2em "Source Sans Pro", sans-serif;
}

.select-box {
  position: relative;
  max-width: 20em;
  margin: 5em auto;
  width: 100%;
}

input,
select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

button {
  width: 100%;
  background-color: #4caf50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #45a049;
}
label,
footer {
  font-family: sans-serif;
}

label {
  font-size: 1rem;
  padding-right: 10px;
}

footer {
  font-size: 0.8rem;
  position: absolute;
  bottom: 30px;
  left: 30px;
}
</style>