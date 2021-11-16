<template>
  <div>
    <select id="seleccionar" ref="comboBoxT" @change="cambiarTipoAccionRol">
      <option value="default" selected="Selected" disabled>
        -Seleccione un tipo de acción--
      </option>
      <option value="1">Asignar Roles</option>
      <option value="2">Desasignar Roles</option>
    </select>
    <br /><br />
    <div v-if="opcion_accion_rol">
      <div class="label select-box1">
        <section v-if="opcion_accion_rol === '1'">
          <span class="label-desc">Escoja el usuario a asignar</span>
          <select @change="cambiarEleccion" name="respaldos" id="select-box1">
            <option value="default" selected="Selected" disabled>
              --Escoja el usuario--
            </option>
            <option
              v-for="(owner, index) in owners"
              :key="index"
              :value="owner"
            >
              {{ owner.schema_name }}
            </option>
          </select>
          <span class="label-desc">Escoja el rol asignar</span>
          <select @change="desasignarRoll" name="respaldos" id="select-box1">
            <option value="default" selected="Selected" disabled>
              --Escoja el rol--
            </option>
            <option v-for="(rol, index) in roles" :key="index" :value="rol">
              {{ rol }}
            </option>
          </select>
          <button @click="asignar" :disabled="sent || !opcion">
            Asignar Rol
          </button>
        </section>
        <section v-else>
          <span class="label-desc">Escoja el usuario a desasignar</span>
          <select @change="cambiarEleccion" name="respaldos" id="select-box1">
            <option value="default" selected="Selected" disabled>
              --Escoja el usuario--
            </option>
            <option
              v-for="(owner, index) in owners"
              :key="index"
              :value="owner"
            >
              {{ owner.schema_name }}
            </option>
          </select>
          <span class="label-desc">Escoja el rol desasignar</span>
          <select @change="desasignarRoll" name="respaldos" id="select-box1">
            <option value="default" selected="Selected" disabled>
              --Escoja el rol--
            </option>
            <option v-for="(rol, index) in roles" :key="index" :value="rol">
              {{ rol }}
            </option>
          </select>
          <button @click="desasignar" :disabled="sent || !opcion">
            Desasignar Rol
          </button>
        </section>
      </div>
    </div>
  </div>
</template>
<script>
import managerController from "../../controllers/managerController";

export default {
  data() {
    return {
      texto: null,
      roles: [],
      owners: [],
      repeated: [],
      opcion_accion_rol: null,
      opcion: null,
      sent: false,
      tipoAccion: null,
      mostararBotones: false,
    };
  },
  async mounted() {
    return await managerController
      .getSchemas()
      .then((response) => {
        this.owners = response;
      })
      .catch((error) => console.error(error));
  },
  methods: {
    desasignarRol: async function () {
      return await managerController
        .desasignarRolAUsuario("rol", "usuario")
        .then((response) => {
          this.roles = response;
        })
        .catch((error) => console.error(error));
    },
    asignarRol: async function () {
      return await managerController
        .asignarRolAUsuario("rol", "usuario")
        .then((response) => {
          this.roles = response;
        })
        .catch((error) => console.error(error));
    },
    desasignar() {
      this.tipoAccion = false;
    },
    asignar() {
      this.tipoAccion = true;
    },
    cambiarEleccion: function (e) {
      this.opcion = e.target.value;
      this.sent = false;
    },
    elegirOwner: async function (e) {
      console.log(e.target.value);
      this.mostararBotones = true;
      return await managerController
        .getRol(e.target.value)
        .then((response) => {
          this.roles = response;
        })
        .catch((error) => console.error(error));
    },
    cambiarTipoAccionRol: function (e) {
      this.opcion_accion_rol = e.target.value;
      this.sent = false;
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