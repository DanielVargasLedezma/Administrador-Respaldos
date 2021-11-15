<template>
  <div>
    <select name="schemas" @change="handleChange">
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
    <button @click="elegirSchema" :disabled="!schema_elegido">
      Cargar Tablas
    </button>

    <br /><br />

    <section v-if="eleccion_schema">
      <select name="tablas" @change="handleChange">
        <option value="default" selected="Selected" disabled>
          --Seleccione una tabla--
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
      <button @click="hacerRespaldo" :disabled="sent || !tabla_elegida">
        Respaldar Tabla
      </button>
    </section>
  </div>
</template>

<script>
import managerController from "../../controllers/managerController";

export default {
  data() {
    return {
      schemas: [],
      schema_elegido: null,
      eleccion_schema: false,
      tablas: [],
      tabla_elegida: null,
      sent: false,
    };
  },
  async mounted() {
    await this.cargarSchemas();
  },
  methods: {
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
    hacerRespaldo: async function () {
      this.sent = true;

      await managerController
        .doATableSchemaBackUp(this.schema_elegido, this.tabla_elegida)
        .then((res) => {
          this.downloadFile(res, "BACKUP");
          this.sent = false;

          managerController.deleteATableSchemaBackUp(
            this.schema_elegido,
            this.tabla_elegida
          );
        })
        .catch((error) => {
          console.error(error);
        });
    },
    handleChange: function (e) {
      switch (e.target.name) {
        case "schemas":
          this.schema_elegido = e.target.value;
          this.eleccion_schema = false;
          break;
        case "tablas":
          this.tabla_elegida = e.target.value;
          break;
        default:
          break;
      }
    },
    elegirSchema: async function () {
      await managerController
        .getTablesFromSchema(this.schema_elegido)
        .then((response) => {
          this.tablas = response;
          this.eleccion_schema = true;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    downloadFile(response, filename) {
      // It is necessary to create a new blob object with mime-type explicitly set
      // otherwise only Chrome works like it should
      var newBlob = new Blob([response.data]);

      // IE doesn't allow using a blob object directly as link href
      // instead it is necessary to use msSaveOrOpenBlob
      if (window.navigator && window.navigator.msSaveOrOpenBlob) {
        window.navigator.msSaveOrOpenBlob(newBlob);
        return;
      }

      // For other browsers:
      // Create a link pointing to the ObjectURL containing the blob.
      const data = window.URL.createObjectURL(newBlob);
      var link = document.createElement("a");
      link.href = data;
      link.download = filename + ".DMP";
      link.click();
      setTimeout(function () {
        // For Firefox it is necessary to delay revoking the ObjectURL
        window.URL.revokeObjectURL(data);
      }, 100);
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

input[type="text"],
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