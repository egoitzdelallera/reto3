<script setup>
import NavView from './views/NavView.vue'
import FooterView from './views/FooterView.vue'
</script>

<template>
  <div id="app">
    <div class="nav">
      <NavView />
    </div>
    <div class="content">
      <router-view></router-view>
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

.nav {
  width: 100%;
  height: 10%;
}

.content {
  width: 100%;
  flex-grow: 1;
}

.footer {
  width: 100%;
  height: 10%;
}
</style>