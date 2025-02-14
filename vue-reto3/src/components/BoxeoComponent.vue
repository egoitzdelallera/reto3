<template>
  <div class="container">
    <main class="main-content">
      <div class="main-left">
        <h1 class="title">ACTIVIDADES</h1>
        <h2 class="subtitle">{{ categoriaNombre }}</h2>
        <div class="filters">
          <div class="filtro rounded d-flex justify-content-around">
            <select id="edad" v-model="edadFilter">
              <option value="" disabled selected hidden>Edad</option>
              <option value="centro1">centro1</option>
              <option value="centro2">centro2</option>
              <option value="centro3">centro3</option>
              <option value="otro4">otro4</option>
            </select>
            <select id="idioma" v-model="idiomaFilter">
              <option value="" disabled selected hidden>Idioma</option>
              <option value="centro1">centro1</option>
              <option value="centro2">centro2</option>
              <option value="centro3">centro3</option>
              <option value="otro4">otro4</option>
            </select>
            <select id="horario" v-model="horarioFilter">
              <option value="" disabled selected hidden>Horario</option>
              <option value="centro1">centro1</option>
              <option value="centro2">centro2</option>
              <option value="comida">centro3</option>
              <option value="otros">otro4</option>
            </select>
          </div>
        </div>
      </div>
      <div class="right-side-container">
        <div class="right-side-scrollable">
          <div v-if="loading">Cargando actividades...</div>
          <div v-else-if="error">Error al cargar actividades: {{ error }}</div>
          <div v-else>
            <div v-for="actividad in actividadesFiltradas" :key="actividad.id" class="activity-card">
              <h3 class="activity-title">{{ actividad.nombre }}</h3>
              <p class="activity-description">{{ actividad.descripcion }}</p>

              <div class="activity-details">
                  <p>Centro Civico: {{ actividad.centro_civico ? actividad.centro_civico.nombre : 'N/A' }}</p>
                  <p>Monitor: {{ actividad.monitor ? actividad.monitor.nombre : 'N/A' }} {{ actividad.monitor ? actividad.monitor.apellido : 'N/A' }}</p>
                  <p>Tipo Actividad: {{ actividad.tipo_actividad ? actividad.tipo_actividad.nombre : 'N/A' }}</p>
                  <p>Edad Minima: {{ actividad.tipo_actividad ? actividad.tipo_actividad.edad_min : 'N/A' }}</p>
                  <p>
                    Horarios:
                    <span v-if="actividad.horarios && actividad.horarios.length > 0">
                      <span v-for="horario in actividad.horarios" :key="horario.id">
                        {{ formatDateTime(horario.fecha, horario.hora_inicio, horario.hora_fin) }}
                        <br>
                      </span>
                    </span>
                    <span v-else>No Horarios</span>
                  </p>
              </div>

              <div class="activity-location">
                Centro Cívico
                <span class="location-name">IBAIONDO</span>
              </div>
              <button class="register-button">INSCRÍBETE</button>
            </div>
            <div v-if="actividadesFiltradas.length === 0">
              <p>No se encontraron actividades con los filtros seleccionados.</p>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import { computed, watch, onMounted, ref } from 'vue';
import useActividades from '../composables/useActividades'; // Ajusta la ruta si es necesario
import useCategorias from '../composables/useCategorias';   // Ajusta la ruta si es necesario
import { useRoute } from 'vue-router';

export default {
  name: "BoxingActivities",
  setup() {
    const route = useRoute();
    const { actividades, loading, error, categoryId, setCategory, fetchActividades } = useActividades();
    const { categorias, fetchCategorias } = useCategorias();

    const edadFilter = ref('');
    const idiomaFilter = ref('');
    const horarioFilter = ref('');

    const categoriaNombre = computed(() => {
      const categoria = categorias.value.find(cat => cat.id === categoryId.value);
      return categoria ? categoria.nombre.toUpperCase() : 'ACTIVIDAD';
    });

    const actividadesFiltradas = computed(() => {
      return actividades.value.filter(actividad => {
        // Aquí debes ajustar la lógica de filtrado según tus necesidades
        // Este es un ejemplo, debes adaptar los nombres de las propiedades a tu objeto 'actividad'
        const edadCoincide = !edadFilter.value || actividad.edad === edadFilter.value;
        const idiomaCoincide = !idiomaFilter.value || actividad.idioma === idiomaFilter.value;
        const horarioCoincide = !horarioFilter.value || actividad.horario === horarioFilter.value;

        return edadCoincide && idiomaCoincide && horarioCoincide;
      });
    });


    watch(categoryId, (newCategoryId) => {
      if (newCategoryId) {
        fetchActividades();
      }
    });

    onMounted(async () => {
      await fetchCategorias();
      // Asignar el ID correcto para la categoría de boxeo
      const boxeoCategoria = categorias.value.find(cat => cat.nombre.toLowerCase() === 'boxeo');
      if (boxeoCategoria) {
        setCategory(boxeoCategoria.id);
        await fetchActividades();
      } else {
        console.error('No se encontró la categoría de boxeo');
      }
    });

    // Helper function to get the day of the week
    const getDayOfWeek = (dateString) => {
      const date = new Date(dateString);
      const daysOfWeek = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
      return daysOfWeek[date.getDay()];
    };

    // Helper function to format date, day of week, and time
    const formatDateTime = (dateString, startTime, endTime) => {
      const date = new Date(dateString);
      const dayOfWeek = getDayOfWeek(dateString);
      const formattedDate = date.toLocaleDateString('es-ES');
      const formattedStartTime = new Date(`1970-01-01T${startTime}`).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
      const formattedEndTime = new Date(`1970-01-01T${endTime}`).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });

      return `${dayOfWeek}, ${formattedDate} - ${formattedStartTime} - ${formattedEndTime}`;
    };



    return {
      actividades,
      loading,
      error,
      categoriaNombre,
      actividadesFiltradas,
      edadFilter,
      idiomaFilter,
      horarioFilter,
      categorias: computed(() => categorias.value),
      formatDateTime,
    };
  }
};
</script>

<style scoped>
/* General styles */
.container {
  background-color: black;
  color: white;
  font-family: sans-serif;
  height: 90vh;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  max-width: 100vw;
  background-image: url(../assets/img/fondoBoxeo.jpg);
  background-repeat: no-repeat;
  background-size: 108%;
}

/* Header styles */


.logo {
  display: flex;
  align-items: center;
}

.logo img {
  width: 40px;
  margin-right: 10px;
}

.navigation {
  display: flex;
  align-items: center;
}

.nav-button,
.login {
  background-color: transparent;
  color: white;
  border: 1px solid white;
  padding: 5px 15px;
  margin-left: 10px;
  cursor: pointer;
  border-radius: 5px;
}

.nav-button.active {
  background-color: white;
  color: black;
}

/* Main Content styles */
.main-content {
  display: flex;
  height: calc(100% - 60px);
  padding: 0px 40px;
}

.main-left {
  width: 55%; /* Fixed width for the left side */
  flex-shrink: 0; /* Prevent shrinking */
  padding: 20px;
  position: sticky; /* Make it stick */
  top: 0;
  height: 100vh; /* Occupy full viewport height */
  display: flex;
  flex-direction: column;
  justify-content: flex-start; /* Align items to the top */
  align-items: flex-start; /* Align items to the left */
  text-align: left;
  font-weight: 900;
  color: white;
  letter-spacing: 0.1em;
  font-size: 1.7em;
  font-style: italic;
}

.title {
  font-size: 5rem;
  font-weight: bold;
  color: #ffff00;
  margin-bottom: 5px;
  font-family: Arial, sans-serif;
}

.subtitle {
  font-size: 3rem;
  font-style: italic;
  color: #ffff00;
  margin-bottom: 20px;
  font-family: Arial, sans-serif;
}

/* Filters */
.filters {
  margin-top: 20px;
}

.filtro {
  background-color: rgba(0, 0, 0, 0.5);
  padding: 10px;
}

.filtro select {
  background-color: transparent;
  color: white;
  border: 1px solid white;
  padding: 5px 10px;
  border-radius: 5px;
  margin-right: 10px;
}

/* Right side: Scrollable Activity Blocks */
.right-side-container {
  width: 50%;
  height: 100vh; /* Set the height of the container */
  overflow: hidden;
  /*  Prevent the container from overflowing */
  padding: 30px 20px;
}

.right-side-scrollable {
  width: 100%;
  height: 100%; /* Set the height of the scrollable area */
  overflow-y: auto;
  /* Enable vertical scroll */
  scrollbar-width: thin;
  /*  thin  auto  none */
  scrollbar-color: #ffffff transparent;
  padding-right: 10px; /* Space for the scrollbar */
}

/* Scrollbar Styling */
.right-side-scrollable::-webkit-scrollbar {
  width: 12px; /* Width of the scrollbar */
}

.right-side-scrollable::-webkit-scrollbar-track {
  background: transparent; /* Color of the track */
  border-radius: 10px; /* Rounded corners of the track */
}

.right-side-scrollable::-webkit-scrollbar-thumb {
  background: #ffffff; /* Color of the scroll thumb */
  border-radius: 10px; /* Rounded corners of the scroll thumb */
}

.right-side-scrollable::-webkit-scrollbar-thumb:hover {
  background: #555; /* Color of the scroll thumb on hover */
}

.activity-card {
  border: 1px solid white;
  padding: 20px;
  margin-bottom: 20px;
  border-radius: 10px;
  position: relative;
  z-index: 1;
}

.activity-card-placeholder {
  border: 1px solid white;
  padding: 20px;
  margin-bottom: 20px;
  border-radius: 10px;
  position: relative;
  z-index: 1;
}

.activity-title {
  font-size: 2rem;
  font-style: italic;
  color: #ffff00;
  margin-bottom: 10px;
  font-family: Arial, sans-serif;
}

.activity-description {
  font-size: 0.9rem;
  margin-bottom: 15px;
}

.activity-location {
  font-size: 0.8rem;
  margin-bottom: 15px;
}

.location-name {
  font-weight: bold;
  font-style: normal;
}

.register-button {
  background-color: #ffff00;
  color: black;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  border-radius: 5px;
  font-weight: bold;
}

.activity-details {
    font-size: 0.9rem;
    margin-bottom: 15px;
}
</style>