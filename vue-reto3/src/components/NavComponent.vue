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
        <div class="inicio_sesion" v-if="!isAuthenticated">
          <div class="inicio_borde">
            <button @click="goToLogin">Iniciar Sesión</button>
          </div>
        </div>
        <div class="inicio_sesion" v-else>
          <div class="inicio_borde">
            <button @click="goToIntranet">Acceder Intranet</button>
            <button @click="logout">Cerrar sesión</button>
          </div>
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
    transition:ease-in-out 0.2s;
    text-decoration: none;  
  }

  .inicio_borde:hover{
    padding: 4px 8px 4px 8px;
    border: .1px solid black;
    position:absolute;
  }

  .inicio_borde{
    display: flex;
    gap: 10px ;
    align-items: center;
    border: 2px solid white;
    padding: 2px 2px 2px 2px;
    border-radius: 10px;
    transition: ease-in-out 0.2s;
  }

  .inicio_sesion button{
    color: rgb(0, 0, 0);
    background-color: aliceblue;
    padding: 3px 15px 3px 15px;
    border-radius: 6px;
  }
  .categorias{
    width: 20%;
    display: flex;
    justify-content: center;
    align-items: center;
    transition:ease-in-out 0.2s;
    text-decoration: none;
  }
  
  .cat_borde:hover{
    padding: 4px 8px 4px 8px;
    border: .1px solid black;
    position:absolute;
  }
  .cat_borde{
    border: 2px solid white;
    padding: 2px 2px 2px 2px;
    border-radius: 10px;
    transition: ease-in-out 0.2s;

  }
  .categorias a{
    color: rgb(0, 0, 0);
    background-color: aliceblue;
    padding: 3px 15px 3px 15px;
    border-radius: 6px;
  }

  .logout-btn {
    background-color: #ff4d4d;
    color: white;
    border: none;
    padding: 8px 12px;
    margin-left: 10px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s;
  }

  .logout-btn:hover {
    background-color: #cc0000;
  }
</style>

<script>
export default {
  computed: 
  {
    isAuthenticated() {
      return localStorage.getItem('jwt_token') !== null;
    }
  },
  methods: {
    goToLogin() {
      this.$router.push('/login'); // Asegúrate de tener definida la ruta '/login' en tu Vue Router
    },
    goToIntranet() {
      this.$router.push('/intranet');
    },
    logout() {
      localStorage.removeItem('jwt_token'); // Eliminar token
      localStorage.removeItem('user_data'); // Opcional: Eliminar datos del usuario
      this.$router.push('/'); // Redirigir a la página principal
    }
  }
};
</script>