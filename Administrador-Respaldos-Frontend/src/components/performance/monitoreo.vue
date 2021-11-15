<template>
  <div>
    <div class="select-box">
      <select @change="elegirTipoMonitoreo">
        <option value="default" selected="Selected" disabled>
          --Seleccione un tipo de acción--
        </option>
        <option value="E">Estado de la base de datos</option>
        <option value="P">Parámetros generales</option>
        <option value="C">Conexiones actuales</option>
      </select>

      <button @click="hacerMonitoreo" :disabled="!tipoSeleccionado">
        Hacer Monitoreo
      </button>
      <br /><br />

      <section class="select-box" v-if="tipoSeleccionado === 'E'">
        <select @change="elegirValorMonitoreo">
          <option value="default" selected="Selected" disabled>
            --Seleccione un tipo de acción--
          </option>
          <option
            v-for="(schema, index) in llaves"
            :key="index"
            :value="schema"
          >
            {{ schema }}
          </option>
        </select>
        <p>Resultado: {{ variableSetsi }}</p>
      </section>
    </div>
    <section v-if="tipoSeleccionado === 'P'">
      <table>
        <thead>
          <th>NAME</th>
          <th>VALUE</th>
          <th>DESCRIPTION</th>
        </thead>
        <tbody>
          <tr v-for="(item, index) in monitoreo" :key="index">
            <td>{{ item["name"] }}</td>
            <td>{{ item["value"] }}</td>
            <td>{{ item["description"] }}</td>
          </tr>
        </tbody>
      </table>
    </section>

    <section v-else-if="tipoSeleccionado === 'C'">
      <table>
        <thead>
          <th>USER</th>
          <th>SCHEMA</th>
          <th>MÁQUINA</th>
          <th>PROGRAMA</th>
        </thead>
        <tbody>
          <tr v-for="(item, index) in monitoreo" :key="index">
            <td>{{ item["osuser"] }}</td>
            <td>{{ item["username"] }}</td>
            <td>{{ item["machine"] }}</td>
            <td>{{ item["program"] }}</td>
          </tr>
        </tbody>
      </table>
    </section>
  </div>
</template>

<script>
import managerController from "../../controllers/managerController";

export default {
  data() {
    return {
      monitoreo: [],
      llaves: [],
      tipoSeleccionado: null,
      variableSetsi: null,
    };
  },
  methods: {
    elegirValorMonitoreo: async function (e) {
      //console.log(e.target.value);
      this.variableSetsi = this.monitoreo[e.target.value];
    },
    elegirTipoMonitoreo: function (e) {
      this.tipoSeleccionado = e.target.value;
    },
    hacerMonitoreo: async function () {
      switch (this.tipoSeleccionado) {
        case "E":
          await managerController
            .doMonitoreo()
            .then((res) => {
              this.monitoreo = res[0];
              this.llaves = Object.keys(res[0]);
            })
            .catch((error) => {
              console.error(error);
            });
          break;
        case "P":
          await managerController
            .doMonitoreo2()
            .then((res) => {
              this.monitoreo = res;
              //this.llaves = Object.keys(res[0]);
            })
            .catch((error) => {
              console.error(error);
            });
          break;
        case "C":
          await managerController
            .doMonitoreo3()
            .then((res) => {
              this.monitoreo = res;
              //this.llaves = Object.keys(res[0]);
            })
            .catch((error) => {
              console.error(error);
            });
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
.table {
  margin: 0;
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
table {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

table td,
table th {
  border: 1px solid #ddd;
  padding: 8px;
  width: 80%;
}

table tr:nth-child(even) {
  background-color: #f2f2f2;
}

table tr:hover {
  background-color: #ddd;
}

table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04aa6d;
  color: white;
}
</style>