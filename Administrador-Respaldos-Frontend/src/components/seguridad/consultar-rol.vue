<template>
  <div>
    <p>Roles de la base de datos:</p>
    <select @change="elegirOwner" name="respaldos" id="select-box1">
      <option value="default" selected="Selected" disabled>
        --Seleccione un Owner--
      </option>
      <option
        v-for="(owner, index) in owners"
        :key="index"
        :value="owner.schema_name"
      >
        {{ owner.schema_name }}
      </option>
    </select>
    <select @change="elegirRolCreado" name="respaldos" id="select-box1">
      <option value="default" selected="Selected" disabled>
        --Seleccione un rol guardado--
      </option>
      <option v-for="(rol, index) in roles" :key="index" :value="rol">
        {{ rol.granted_role }}
      </option>
    </select>
    <button @click="crearRol" :disabled="!texto">Consultar Permisos</button>
    <br />
    <select @change="elegirPrivilegios" name="respaldos" id="select-box1">
      <option value="default" selected="Selected" disabled>
        --Permisos del rol--
      </option>
      <option
        v-for="(privilege, index) in privilegios"
        :key="index"
        :value="privilege.privilege"
      >
        {{ privilege.privilege }}
      </option>
    </select>
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
      opcion: false,
      sent: false,
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
    cambiarEleccion: function (e) {
      this.opcion = e.target.value;
      this.sent = false;
    },
    elegirOwner: async function (e) {
      console.log(e.target.value);
      return await managerController
        .getRol(e.target.value)
        .then((response) => {
          this.roles = response;
        })
        .catch((error) => console.error(error));
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