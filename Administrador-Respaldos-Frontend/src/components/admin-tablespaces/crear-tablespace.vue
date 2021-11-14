<template>
  <div>
    <label for="">Tipo de Tablespace a crear</label>
    <br /><br />
    <select id="seleccionar" ref="comboBoxT" @change="handleBoxChange">
      <option value="default" selected="Selected" disabled>
        --Seleccione un tipo de respaldo--
      </option>
      <option value="1">Tablespace</option>
      <option value="2">Temporary Tablespace</option>
    </select>
    <br />
    <br />
    <section v-if="opcion">
      <label for="">Nombre del tablespace</label>
      <br /><br />
      <input
        type="text"
        id="nombre_tbotemp"
        placeholder="Digite el nombre tablespace"
        v-model="tablespace"
      />
      <br /><br />
      <button @click="crearTablespace" :disabled="!opcion || sent">
        Crear tablespace
      </button>
      <p v-if="opcion === '2'">
        El nombre se verá afectado añadiendo "_TEMP" si está elegido el
        temporary tablespace
      </p>
    </section>
  </div>
</template>

<script>
import managerController from "../../controllers/managerController";

export default {
  data() {
    return {
      sent: false,
      opcion: null,
      tablespace: "",
    };
  },
  methods: {
    handleBoxChange: function (e) {
      this.opcion = e.target.value;
    },
    crearTablespace: async function () {
      this.sent = true;
      switch (this.opcion) {
        case "1":
          await managerController
            .createTablespace(this.tablespace)
            .then((response) => {
              if (response === 201) {
                this.tablespace = "";
              }
            })
            .catch((error) => console.error(error));
          break;
        case "2":
          await managerController
            .createTemporaryTablespace(this.tablespace)
            .then((response) => {
              if (response === 201) {
                this.tablespace = "";
              }
            })
            .catch((error) => console.error(error));
          break;
        default:
          break;
      }

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

button {
  cursor: pointer;
}

label,
footer {
  font-family: sans-serif;
}

label {
  font-size: 1rem;
  padding-right: 10px;
}

select {
  font-size: 0.9rem;
  padding: 2px 5px;
  cursor: pointer;
}

input {
  font-size: 0.9rem;
  padding: 2px 5px;
}

footer {
  font-size: 0.8rem;
  position: absolute;
  bottom: 30px;
  left: 30px;
}
</style>