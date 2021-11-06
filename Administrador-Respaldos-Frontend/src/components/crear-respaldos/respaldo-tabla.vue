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
    <button @click="probar">Probar</button>
  </div>
</template>

<script>
import managerController from "../../controllers/managerController";

export default {
  data() {
    return {
      schemas: [],
      schema_elegido: "",
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
    elegirSchema: function (e) {
      this.schema_elegido = e.target.value;
    },
  },
};
</script>

<style scoped>
</style>