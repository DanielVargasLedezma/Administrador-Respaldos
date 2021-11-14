<template>
  <div>
    <label class="label select-box1"
      ><span class="label-desc">Elija que hacer xd</span>
    </label>
    <br /><br />
    <select @change="cambiarEleccion" name="respaldos" id="select-box1">
      <option value="default" selected="Selected" disabled>
        --Seleccione un tipo de estadistica--
      </option>
      <option value="1">Schema</option>
      <option value="2">Tabla</option>
    </select>
    <br /><br />
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
    <select v-if="!ellanomequiere" @change="elegirTabla">
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
  </div>
</template>

<script>
import managerController from "../../controllers/managerController";

export default {
  data() {
    return {
      schemas: [],
      schema_elegido: null,
      tablas: [],
      tabla_elegida: null,
      ellanomequiere: false,
    };
  },
  async mounted() {
    await this.cargarSchemas();
  },
  methods: {
    cambiarEleccion: async function (e) {
      if (e.target.value === "1") {
        this.ellanomequiere = true;
      } else {
        this.ellanomequiere = false;
      }
      await this.cargarSchemas();
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
  },
};
</script>

<style>
</style>