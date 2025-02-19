<template>
  <nav>
    <div class="nav">
      <div class="logo">
        <img src="../assets/img/logoAyuntmaiento.png" alt="Logo" />
      </div>

      <!-- Botón Hamburguesa -->
      <button class="hamburger-button" @click="toggleMenu">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
      </button>

      <!-- Contenedor de enlaces (Categorías e Iniciar Sesión) -->
      <div class="nav-links" :class="{ 'active': isMenuOpen }">
        <div class="categorias">
          <div class="cat_borde">
            <a href="http://localhost:5173/">Inicio</a>
          </div>
        </div>
        <div class="categorias" v-if="!isAuthenticated">
          <div class="cat_borde">
            <button @click="goToLogin">Iniciar Sesión</button>
          </div>
        </div>
        <!-- Mostrar solo si el usuario está autenticado y su tipo es 'admin' -->
        <div class="categorias" v-else-if="userType === 'admin'">
          <div class="cat_borde">
            <button @click="goToIntranet">Acceder Intranet</button>
            <button @click="logout">Cerrar sesión</button>
          </div>
        </div>

        <!-- Mostrar solo si el usuario está autenticado y su tipo es 'ciudadano' -->
        <div class="categorias" v-else-if="userType === 'ciudadano'">
          <div class="cat_borde">
            <button @click="logout">Cerrar sesión</button>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  computed: {
    isAuthenticated() {
      return localStorage.getItem('jwt_token') !== null;
    }
  },
  data() {
    return {
      isMenuOpen: false, // Estado del menú (abierto/cerrado)
      userType: this.getUserType()
    };
  },
  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen; // Cambia el estado del menú
    },
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
    },
    getUserType() {
      const user_data = JSON.parse(localStorage.getItem('user_data'));
      if (user_data && user_data.tipo) {
        return user_data.tipo;  // Retorna 'admin' o 'ciudadano' dependiendo de los datos
      }
      return null;  // Si no hay usuario o no tiene tipo, retornamos null
    }
  }
};
</script>

<style scoped>
nav {
  background-color: #000000;
  padding: 10px 0;
  width: 100%; /* Usar 100% en lugar de 100vw */
}

.nav {
  display: flex;
  justify-content: space-between;
  align-items: center; /* Centrar verticalmente */
  padding: 0 1rem; /* Espacio a los lados */
}

.logo img {
  height: 70px;
  width: auto;
}

.logo {
  width: auto; /* Ajuste automático */
  margin-left: 0; /* Eliminar margen innecesario */
}

/* Estilos para el botón hamburguesa */
.hamburger-button {
  display: none; /* Oculto por defecto */
  flex-direction: column;
  justify-content: space-between;
  width: 30px;
  height: 22px;
  background: transparent;
  border: none;
  cursor: pointer;
  padding: 0;
}

.bar {
  height: 3px;
  width: 100%;
  background-color: white;
  border-radius: 2px;
  transition: all 0.3s ease;
}

/* Estilos para los enlaces de navegación */
.nav-links {
  display: flex;
  justify-content: center;
  align-items: center;
  transition: ease-in-out 0.2s;
  text-decoration: none;
}

.categorias {
  width: auto; /* Ajuste automático */
  display: flex;
  justify-content: center;
  align-items: center;
  transition: ease-in-out 0.2s;
  text-decoration: none;
  margin: 0 0.5rem; /* Espacio entre los elementos */
}

.cat_borde:hover {
  padding: 8px 8px 8px 8px;
  border: 0.1px solid black;
}

.cat_borde {
  border: 2px solid white;
  padding: 2px 2px 2px 2px;
  border-radius: 10px;
  transition: ease-in-out 0.2s;
}

.categorias a {
  color: rgb(0, 0, 0);
  background-color: aliceblue;
  padding: 3px 15px 3px 15px;
  border-radius: 6px;
  text-decoration: none; /* Quitar subrayado */
}

.categorias button {
  color: rgb(0, 0, 0);
  background-color: aliceblue;
  padding: 3px 15px 3px 15px;
  border-radius: 6px;
  text-decoration: none; /* Quitar subrayado */
}

/* Media Query para pantallas pequeñas */
@media (max-width: 768px) {
  .nav {
    flex-wrap: wrap; /* Permite que los elementos se envuelvan */
  }

  .logo {
    width: 100%; /* Ocupa todo el ancho */
    text-align: center;
    margin-bottom: 10px;
  }

  .nav-links {
    display: none; /* Oculta los enlaces por defecto */
    width: 100%;
    flex-direction: column; /* Apila los enlaces verticalmente */
    text-align: center;
  }

  .nav-links.active {
    display: flex; /* Muestra los enlaces cuando el menú está activo */
  }

  .categorias {
    width: 100%; /* Ocupa todo el ancho */
    margin: 0.5rem 0; /* Espacio arriba y abajo */
  }

  .hamburger-button {
    display: flex; /* Muestra el botón hamburguesa */
    position: absolute; /* Posición absoluta */
    top: 10px; /* Ajustar posición */
    right: 10px; /* Ajustar posición */
  }
}
</style>
