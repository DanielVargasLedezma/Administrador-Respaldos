<template>
  <div>
    <select @change="elegirSchema">
      <option value="default" selected="Selected" disabled>
        --Seleccione un schema--
      </option>
      <option
        v-for="(schema, index) in schemas"
        :key="index"
        :value="schema.schema_name"
      >
        {{ schema.schema_name }}
      </option>
    </select>
    <br /><br />
    <select @change="elegirTabla">
      <option value="default" selected="Selected" disabled>
        --Seleccione un tablespace--
      </option>
      <option
        v-for="(tabla, index) in tablas"
        :key="index"
        :value="tabla.table_name"
      >
        {{ tabla.table_name }}
      </option>
    </select>
    <br /><br />
    <select @change="elegirColumnas">
      <option value="default" selected="Selected" disabled>
        --Seleccione una Columna--
      </option>
      <option
        v-for="(col, index) in columnas"
        :key="index"
        :value="col.column_name"
      >
        {{ col.column_name }}
      </option>
      <br /><br />
    </select>
    <label
      v-for="(item, index) in columnas_elegidas"
      :key="index"
      :value="item"
      >{{ item }}</label
    >
    <button @click="hacerIndice" :disabled="sent || !schema_elegido">
      Realizar Indice
    </button>
  </div>
</template>

<script>
import managerController from "../../controllers/managerController";

export default {
  data() {
    return {
      sent: false,
      schemas: [],
      schema_elegido: null,
      tablas: [],
      tabla_elegida: null,
      columnas: [],
      columnas_elegidas: [],
      repeated: [],
    };
  },
  async mounted() {
    await this.cargarSchemas();
  },

  methods: {
    hacerIndice: async function () {
      await managerController
        .createIndexOnTable(
          this.schema_elegido,
          this.tabla_elegida,
          this.columnas_elegidas
        )
        .then((res) => {
          console.log(res);
        })
        .catch((error) => {
          console.error(error);
        });
    },
    cargarSchemas: async function () {
      await managerController
        .getSchemas()
        .then((res) => {
          this.schemas = res;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    elegirSchema: async function (e) {
      this.schema_elegido = e.target.value;
      await this.cargarTablas();
    },
    cargarTablas: async function () {
      await managerController
        .getTablesFromSchema(this.schema_elegido)
        .then((res) => {
          this.tablas = res;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    elegirTabla: async function (e) {
      this.tabla_elegida = e.target.value;

      await managerController
        .getColumnTables(this.schema_elegido, this.tabla_elegida)
        .then((response) => {
          this.columnas = response;
        })
        .catch((error) => console.error(error));
    },
    elegirColumnas: function (e) {
      /*this.columnas_elegidas.forEach((column) => {
        if (e.target.value === column) {
          return;
        }
      });*/
      if (!this.repeated.includes(e.target.value)) {
        this.columnas_elegidas = [...this.columnas_elegidas, e.target.value];
        this.repeated.push(e.target.value);
      } else {
        this.columnas_elegidas = this.columnas_elegidas.filter(
          (item) => item !== e.target.value
        );
        this.repeated = this.repeated.filter((item) => item !== e.target.value);
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