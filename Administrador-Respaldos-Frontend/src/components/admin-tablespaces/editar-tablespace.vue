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
    <br /><br />
    <button @click="elegirTipo">Elegir Tipo</button>

    <br /><br />
    <section v-if="opcion && !chosenAgain">
      <label for="">Tablespace</label>
      <br /><br />
      <select @change="elegirSchema">
        <option value="default" selected="Selected" disabled>
          --Seleccione un tablespace--
        </option>
        <option
          v-for="(tablespace, index) in tablespaces"
          :key="index"
          :value="tablespace.tablespace_name"
        >
          {{ tablespace.tablespace_name }}
        </option>
      </select>

      <br /><br />
      <label for="">Tamaño del tablespace</label>
      <br /><br />
      <input
        type="number"
        id="nombre_tbotemp"
        placeholder="Digite el tamaño"
        v-model="tamaño"
        @change="handleTextChange"
      />
      <br /><br />
      <button @click="cambiarTamaño;">Editar tamaño</button>
    </section>
  </div>
</template>

<script>
import managerController from "../../controllers/managerController";

export default {
  data() {
    return {
      tamaño: 0,
      opcion: null,
      chosenAgain: false,
      tablespaces: [],
      tablespace_elegido: null,
      sent: false,
    };
  },
  async mounted() {
    await managerController
      .getTablespaces()
      .then((response) => {
        this.tablespaces = response;
      })
      .catch((error) => console.error(error));
  },
  methods: {
    handleBoxChange: function (e) {
      this.opcion = e.target.value;
      this.chosenAgain = true;
    },
    elegirTipo: function () {
      this.chosenAgain = false;
    },
    cambiarTamaño: async function () {
      switch (this.opcion) {
        case "1":
          await managerController
            .resizeTablespace(this.tablespace_elegido, this.tamaño)
            .then((response) => console.log(response))
            .catch((error) => console.error(error));
          break;
        case "2":
          await managerController.resizeTemporaryTablespace(
            this.tablespace_elegido,
            this.tamaño
          );
          break;

        default:
          break;
      }
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