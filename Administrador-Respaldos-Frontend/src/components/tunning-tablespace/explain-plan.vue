<template>
  <div>
    <label class="label select-box1"
      ><span class="label-desc">Elija el esquema</span>
    </label>
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
    <button type="submit">Hacer ExplainPlan</button>
  </div>
</template>

<script>
import managerController from "../../controllers/managerController";

export default {
  data() {
    return {
      schemas: [],
      schema_elegido: null,
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
    elegirSchema: async function (e) {
      this.schema_elegido = e.target.value;
      await this.cargarTablas();
    },
  },
};
</script>

<style>
</style>