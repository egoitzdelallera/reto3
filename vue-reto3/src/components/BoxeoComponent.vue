<template>
  <div class="container">
    <div class="row d-flex flex-nowrap align-items-center">
      <div class="col-md-6 col-12 titulo">
        <h1 class="px-4">ACTIVIDADES DE</h1>
        <h1>{{ categoriaNombre }}</h1>
      </div>

      <!-- Filters (Absolutely Positioned) -->
      <div class="filters">
        <div class="filtro rounded d-flex justify-content-around">
          <select id="edad">
            <option value="edad" select hidden>Edad</option>
            <option value="deporte">centro1</option>
            <option value="recreacion">centro2</option>
            <option value="comida">centro3</option>
            <option value="otros">otro4</option>
          </select>
          <select id="idioma">
            <option value="idioma" select hidden>Idioma</option>
            <option value="deporte">centro1</option>
            <option value="recreacion">centro2</option>
            <option value="comida">centro3</option>
            <option value="otros">otro4</option>
          </select>
          <select id="horario">
            <option value="horario" select hidden>Horario</option>
            <option value="deporte">centro1</option>
            <option value="recreacion">centro2</option>
            <option value="comida">centro3</option>
            <option value="otros">otros4</option>
          </select>
        </div>
      </div>

      <div class="col-md-6 mt-4 col-12 right-side-scrollable">
        <div class="right-side">
          <div v-if="loading">Cargando actividades...</div>
          <div v-else-if="error">Error al cargar actividades: {{ error }}</div>
          <div v-else>
            <div v-for="actividad in actividades" :key="actividad.id" class="activity-block">
              <div class="row">
                <div class="col-12">
                  <h2>{{ actividad.nombre }}</h2>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <p>{{ actividad.descripcion }}</p>
                </div>
              </div>
              <div class="row mt-3 d-flex justify-content-center align-items-center">
                <!-- Placeholder for schedule and center information. Replace with your actual data -->
                <div class="col-md-4">
                  <p>Horario Placeholder</p>
                  <p>Otro Horario</p>
                </div>
                <div class="col-md-4">
                  <p class="center">Centro Civico</p>
                  <p class="center bold">Ubicacion</p>
                </div>
                <div class="col-md-4">
                  <button>¡Inscríbete!</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="scroll-fade"></div>
      </div>
    </div>
  </div>
</template>

<script>
import { computed, watch, onMounted, ref } from 'vue';
import useActividades from '../composables/useActividades';
import useCategorias from '../composables/useCategorias';
import { useRoute } from 'vue-router';

export default {
  setup() {
    const route = useRoute();
    const { actividades, loading, error, categoryId, setCategory, fetchActividades } = useActividades();
    const { categorias, fetchCategorias } = useCategorias();


    const categoriaNombre = computed(() => {
      const categoria = categorias.value.find(cat => cat.id === categoryId.value);
      return categoria ? categoria.nombre.toUpperCase() : 'ACTIVIDAD';
    });

    watch(categoryId, (newCategoryId) => {
      if (newCategoryId) {
        fetchActividades();
      }
    });

    onMounted(async () => {
      await fetchCategorias();

      // Determine initial category based on the route path
      let initialCategoryId = null;
      switch (route.path) {
        case '/boxeo':
          initialCategoryId = 3; // Replace with the actual category ID for boxeo
          break;
        case '/tenis':
          initialCategoryId = 2; // Replace with the actual category ID for tenis
          break;
        case '/baloncesto':
          initialCategoryId = 1; // Replace with the actual category ID for baloncesto
          break;
        case '/futbol':
          initialCategoryId = 4;  // Replace with the actual category ID for futbol
          break;
        // Add more cases as needed
        default:
          console.warn('Unknown route:', route.path);
      }

      if (initialCategoryId) {
        setCategory(initialCategoryId);
        await fetchActividades();
      }
    });

    return {
      actividades,
      loading,
      error,
      categoriaNombre,
      categorias: computed(() => categorias.value),
    };
  }
};
</script>

<style scoped>
/* Base styles */
.container {
  display: flex;
  font-family: sans-serif;
  color: white;
  background-color: #c1272d;
  padding: 0;
  min-height: 100vh;
  max-width: 100vw;
}

.titulo {
  margin-top: 1.9em;
  margin-left: 1.1em;
}

.titulo h1 {
  font-size: 1.8em;
  font-family: Thunder;
  text-align: left;
  margin: 0;
  font-weight: 800;
  font-style: italic;
  line-height: 0.9;
}

/* Right side: Scrollable Activity Blocks */
.right-side-scrollable {
  overflow-y: auto;
  position: relative;
  /* Required for absolute positioning of fade */
  height: 100vh;
  padding: 20px 0;
  margin-top: 5% 5% 0% 0%;
}

/* Scrollbar Styling */
.right-side-scrollable::-webkit-scrollbar {
  width: 12px;
  /* Width of the scrollbar */
}

.right-side-scrollable::-webkit-scrollbar-track {
  height: 80%;
  width: 8px;
}

.right-side-scrollable::-webkit-scrollbar-thumb {
  background: #000000;
  /* Color of the scroll thumb */
  border-radius: 8px;
  /* Rounded corners of the scroll thumb */
  width: 12px !important;
}

.right-side-scrollable::-webkit-scrollbar-thumb:hover {
  background: #555;
  /* Color of the scroll thumb on hover */
}


.right-side {
  display: flex;
  flex-direction: column;
  padding: 20px;

}

/* Activity block styles */
.activity-block {
  background-color: black;
  padding: 20px;
  margin-bottom: 20px;
  border-radius: 25px;
  position: relative;
  overflow: hidden;

}

.activity-block.faded {
  opacity: 0.3;
  background-color: #d92027;
}

.activity-block h2 {
  margin: 0;
  font-size: 4em;
  font-family: Thunder;
  font-style: normal;
  font-weight: 700;
}

.activity-block p {
  margin-bottom: 0px;
  font-family: Inter;
  font-weight: 300;
  letter-spacing: -0.03em;

}

.activity-block .center {

  font-size: .85em;
  margin-top: -1.9em;
}

.activity-block .bold {
  font-weight: 700;
  font-style: normal;
  font-family: Thunder;
  margin-top: -.3em;
  font-size: 3em;
  padding-top: 0em;
  margin-bottom: -1em;
  letter-spacing: 0.00em;

}

.activity-block button {
  background-color: white;
  color: black;
  border: none;
  padding: 3px 24px 0px 20px;
  cursor: pointer;
  border-radius: 55px;
  margin-bottom: -.2em;
  margin-left: .5em;
  font-weight: 700;
  font-style: italic;
  font-size: 2.5em;
  font-family: Thunder;

}

.activity-block .schedule {
  position: absolute;
  bottom: 20px;
  left: 20px;
}

/* Scroll Fade Effect */
.scroll-fade {
  z-index: 998;
  position: sticky;
  bottom: -21px;
  /* Adjusted to move the fade a bit lower */
  left: 0;
  width: 100%;
  height: 450px;
  /* Increased the height of the fade */
  background: linear-gradient(to bottom, rgba(193, 39, 45, 0), #c1272d);
  /* Adjusted to move the fade a bit lower */
  left: 0;
  width: 100%;
  height: 450px;
  /* Increased the height of the fade */
  background: linear-gradient(to bottom, rgba(193, 39, 45, 0), #c1272d);
  /* Gradient from transparent to #c1272d */
  pointer-events: none;
  /* Ensure the fade doesn't interfere with scrolling */
}

/* Filters (Absolutely Positioned) */
.filters {
  position: absolute;
  top: 100px;
  /* Adjust as needed to position below the title */
  left: 50%;
  transform: translateX(-50%);
  z-index: 1000;
  /* Ensure filters are above other content */
  width: 100%;
  /* Ancho completo */
  padding: 0 15px;
  /* Espacio a los lados */
  box-sizing: border-box;
  /* Asegura que padding no aumente el ancho */
}

.filtro {
  background-color: black;
  color: white;
  margin: 0 auto;
  /* Centra horizontalmente */
  max-width: 500px;
  /* Ancho máximo del filtro */
}

.filtro select {
  background-color: transparent !important;
  color: white;
  border: 0px;
  padding: 10px;
  font-size: 1.5em;
  font-family: Thunder;
  /* Asegura que la tipografía se aplique a las opciones */
  font-weight: 700;
  font-style: italic;
}

.filtro option {
  background-color: #000000;
  color: white;

}

/* Responsive design (Optional) */
@media (max-width: 768px) {
  .container {
    flex-direction: column;
  }

  .row {
    flex-direction: column;
  }

  .titulo,
  .right-side-scrollable {
    width: 100%;
    box-sizing: border-box;
    /* Asegura que padding y border se incluyan en el ancho total */
  }

  .col-md-4 {
    width: 100%;
    /* Ancho completo en pantallas pequeñas */
    box-sizing: border-box;
  }

  .filters {
    position: relative;
    /* Vuelve a la posición normal en pantallas pequeñas */
    top: auto;
    left: auto;
    transform: none;
    padding: 10px;
  }

  .filtro {
    max-width: 100%;
    margin: 0;
  }
}
</style>