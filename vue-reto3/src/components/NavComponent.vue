<template>
    <nav>
      <div class="nav">
        <div class="logo">
          <img src="../assets/img/logoAyuntmaiento.png" alt="Logo" />
        </div>
        <div class="categorias">
          <div class="cat_borde">
            <a href="">
            Categorias
          </a>
          </div>
        </div>
        <div class="inicio_sesion">
          <button @click="goToLogin">Iniciar Sesión</button>
        </div>
      </div>
    </nav>
  </template>
  
  <style>
  nav{
    background-color: #000000;
    padding: 10px 0;
    width: 100vw;
   
  }
  .nav{
    display: flex;
    justify-content: space-between;
  }
  .logo img{
    height: 70px;
    width: auto;
  }
  .logo{
    width: 10%;
    margin-left: 2%;
  }
  .inicio_sesion{
    width: 10%;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .inicio_sesion a{
    color: white;
  }
  .categorias{
    width: 20%;
    display: flex;
    justify-content: center;
    align-items: center;
    
    text-decoration: none;
  }
  .cat_borde{
    border: 1px solid white;
    padding: 2px 1px 2px 1px;
    border-radius: 8px;
  }
  .categorias a{
    color: rgb(0, 0, 0);
    background-color: aliceblue;
    padding: 3px 15px 3px 15px;
    border-radius: 6px;
    
    
  }
</style>

<script>
export default {
  methods: {
    goToLogin() {
      this.$router.push('/login'); // Asegúrate de tener definida la ruta '/login' en tu Vue Router
    }
  }
};
</script>