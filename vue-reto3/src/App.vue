<script setup>
import NavView from './views/NavView.vue'
import FooterView from './views/FooterView.vue'
import InicioView from './views/InicioView.vue'
</script>

<template>
  
  <div id="app">
    <div class="nav">
      <NavView />
    </div>
    <div class="inicio">
      <InicioView />
    </div>
    <div class="footer">
      <FooterView />
    </div>
  </div>
</template>

<style>
#app {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

main {
  
  width: 100%;
  height: 10%;
}

.nav{
  width: 100%;
  height: 10%;
}

.inicio{
  width: 100%;
  height: 80%;
}
.footer{
  width: 100%;
  height: 10%;
}
</style>