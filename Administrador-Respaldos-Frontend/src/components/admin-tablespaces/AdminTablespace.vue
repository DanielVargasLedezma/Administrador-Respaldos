<template>
  <div class="select-box">
    <label class="label select-box1"
      ><span class="label-desc">Elija un tipo de acción de tablespace</span>
    </label>
    <br /><br />
    <select @change="cambiarEleccion" name="respaldos" id="select-box1">
      <option value="default" selected="Selected" disabled>
        --Seleccione un tipo de acción--
      </option>
      <option value="3">Crear tablespace</option>
      <option value="2">Editar tamaño tablespace</option>
      <option value="1">Eliminar tablespace</option>
    </select>
    <br />
    <br />
    <button @click="elegir" :disabled="sent || !opcion">Elegir acción</button>
    <br />
    <br />
    <router-view v-if="sent"></router-view>
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
        case "1":
          this.$router.push("/admin-tablespaces/eliminar");
          break;
        case "2":
          this.$router.push("/admin-tablespaces/editar");
          break;
        case "3":
          this.$router.push("/admin-tablespaces/crear");
          break;

        default:
          break;
      }
    },
    cambiarEleccion: function (e) {
      this.opcion = e.target.value;
      this.sent = false;
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