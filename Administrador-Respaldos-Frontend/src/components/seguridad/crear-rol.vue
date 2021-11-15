<template>
  <div>
    <label>Nombre del rol</label>
    <br /><br />
    <input
      type="text"
      id="nombre_tbotemp"
      placeholder="Digite el nombre del rol"
      v-model="texto"
    />
    <br /><br />
    <button @click="crearRol" :disabled="!opcion || sent">Crear Rol</button>
  </div>
</template>

<script>
/*        
            return await axios
      .post(global.url + "seguridad-usuarios/crear-rol/" + texto)
      .then((response) => {
        return response.status;
      })
      .catch((error) => {
        throw error.response;
      });*/
export default {
  data() {
    return {
      texto: "",
    };
  },
  methods: {
    crearRol: function () {
      console.log(this.texto);
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