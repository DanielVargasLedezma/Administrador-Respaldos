<template>
  <div>
    <select @change="elegirTablespace">
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
    <button @click="eliminarTablespace" :disabled="sent || !tablespace_elegido">
      Eliminar tablespace
    </button>
  </div>
</template>

<script>
import managerController from "../../controllers/managerController";

export default {
  data() {
    return {
      tamaño: 0,
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
    elegirTablespace: function (e) {
      this.tablespace_elegido = e.target.value;
    },
    eliminarTablespace: async function () {
      await managerController
        .deleteTablespace(this.tablespace_elegido)
        .then((status) => {
          if (status) {
            this.$router.push("/");
          }
        });
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