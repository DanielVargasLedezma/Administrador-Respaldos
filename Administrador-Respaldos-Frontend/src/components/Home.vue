<template>
  <div id="maincontainer">
    <Nav />
    <div class="childcontainer" :class="{ active: isActive }">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import Nav from "./NavBar.vue";

export default {
  components: {
    Nav,
  },
};
</script>

<style scoped>
#maincontainer {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 100vh;
  width: 100%;
}

.childcontainer .active {
  width: 85%;
  display: flex;
  flex-direction: column;
  justify-content: top;
}

.childcontainer {
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: top;
}

.title {
  margin-left: 50;
  text-align: center;
}
/* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 600px) {
  #maincontainer {
    flex-direction: column-reverse;
  }
  #childcontainer {
    width: 100%;
  }
}
/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 600px) {
  #maincontainer {
    flex-direction: column-reverse;
  }
  #childcontainer {
    width: 100%;
  }
}
/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {
}
/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
}
/* Extra large devices (large laptops and desktops, 1200px and up) */
@media only screen and (min-width: 1200px) {
  #maincontainer {
    width: 100%;
    height: 100vh;
    display: flex;
    flex-direction: row;
    justify-content: left;
  }
  #childcontainer {
    width: 85%;
    display: flex;
    flex-direction: column;
    justify-content: top;
  }
}
</style>