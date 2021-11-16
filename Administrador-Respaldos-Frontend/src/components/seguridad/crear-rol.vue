<template>
  <div>
    <p>Nombre del rol:</p>
    <input
      type="text"
      id="nombre_tbotemp"
      placeholder="Escriba el nombre del rol"
      v-model="texto"
    />
    <br />
    <p>Privilegios del Rol:</p>
    <select @change="elegirPrivilegios" name="respaldos" id="select-box1">
      <option value="default" selected="Selected" disabled>
        -Seleccione un tipo de privilegio--
      </option>
      <option
        v-for="(privilege, index) in privilegios"
        :key="index"
        :value="privilege.privilege"
      >
        {{ privilege.privilege }}
      </option>
    </select>
    <button @click="crearRol" :disabled="!texto">Crear Rol</button>
    <br />
    <section v-if="privilegios_elegidos.length != 0">
      <p>Privilegios elegidos para el rol:</p>
      <ul>
        <li
          v-for="(privilegio, index) in privilegios_elegidos"
          :key="index"
          :value="privilegio"
        >
          {{ privilegio }}
        </li>
        <br /><br />
      </ul>
    </section>
  </div>
</template>

<script>
import managerController from "../../controllers/managerController";

export default {
  data() {
    return {
      texto: null,
      privilegios: [],
      privilegios_elegidos: [],
      repeated: [],
      opcion: false,
      sent: false,
    };
  },
  async mounted() {
    return await managerController
      .loadPriv(this.texto)
      .then((response) => {
        this.privilegios = response.data;
      })
      .catch((error) => console.error(error));
  },
  methods: {
    crearRol: async function () {
      console.log(this.texto);
      return await managerController
        .createRol(this.texto, this.privilegios_elegidos)
        .then((response) => {
          console.log(response);
        })
        .catch((error) => console.error(error));
    },
    cambiarEleccion: function (e) {
      this.opcion = e.target.value;
      this.sent = false;
    },
    elegirPrivilegios: function (e) {
      if (!this.repeated.includes(e.target.value)) {
        this.privilegios_elegidos = [
          ...this.privilegios_elegidos,
          e.target.value,
        ];
        this.repeated.push(e.target.value);
      } else {
        this.privilegios_elegidos = this.privilegios_elegidos.filter(
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