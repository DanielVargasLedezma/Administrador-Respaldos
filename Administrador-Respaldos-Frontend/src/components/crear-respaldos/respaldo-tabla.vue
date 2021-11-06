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
    <button @click="elegirSchema">Cargar Tablas</button>

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
      <button @click="probar">Respaldar Tabla</button>
    </section>
  </div>
</template>

<script>
import managerController from "../../controllers/managerController";

export default {
  data() {
    return {
      schemas: [],
      schema_elegido: "",
      eleccion_schema: false,
      tablas: [],
      tabla_elegida: "",
    };
  },
  async mounted() {
    await this.probar();
  },
  methods: {
    probar: async function () {
      await managerController
        .getSchemas()
        .then((res) => {
          this.schemas = res;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    hacerRespaldo: async function () {},
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
  },
};
</script>

<style scoped>
</style>