<template>
  <div class="container">
    <div class="row d-flex align-items-center justify-content-around">
      <div class="col-12 col-md-4 titulo">
        <h1 class="ps-4">Actividades</h1>
        <h1>de {{ categoriaNombre.toLowerCase() }}</h1>
      </div>
      <!-- Filters -->
      <div class="col-md-4 filters">
        <div class="filtro rounded d-flex flex-column flex-md-row justify-content-around">
          <select id="centroCivico" v-model="selectedCentroCivico" @change="applyFilters"
            :class="{ 'font-weight-bold': selectedCentroCivico }">
            <option value="" disabled selected hidden>Centro Cívico</option>
            <option value="all">Todos los centros</option>
            <option v-for="centro in centrosCivicos" :key="centro.id" :value="centro.id">
              {{ centro.nombre }}
            </option>
          </select>
          <select id="edad" v-model="selectedEdad" @change="applyFilters" :class="{ 'font-weight-bold': selectedEdad }">
            <option value="" disabled selected hidden>Edad</option>
            <option value="">Todas</option>
            <option value="6">+ 6 años</option>
            <option value="8">+ 8 años</option>
            <option value="10">+ 10 años</option>
            <option value="16">+ 16 años</option>
          </select>
          <select id="idioma" v-model="selectedIdioma" @change="applyFilters"
            :class="{ 'font-weight-bold': selectedIdioma }">
            <option value="" disabled selected hidden>Idioma</option>
            <option value="">Todos</option>
            <option value="Español">Español</option>
            <option value="Euskera">Euskera</option>
          </select>
          <select id="horario" v-model="selectedHorario" @change="applyFilters"
            :class="{ 'font-weight-bold': selectedHorario }">
            <option value="" disabled selected hidden>Horario</option>
            <option value="">Todos</option>
            <option value="manana">Mañana</option>
            <option value="tarde">Tarde</option>
            <option value="noche">Noche</option>
          </select>
        </div>
      </div>

      <div class="col-12 col-md-7 mt-4 right-side-scrollable">
        <div class="right-side">
          <div v-if="loading">Cargando actividades...</div>
          <div v-else-if="error">Error al cargar actividades: {{ error }}</div>
          <div v-else>
            <div v-if="filteredActividades.length === 0">
              <p>No hay actividades disponibles con estos criterios.</p>
            </div>
            <div v-else v-for="actividad in filteredActividades" :key="actividad.id" class="activity-block">
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
              <div>
                <hr class="mb-3">
              </div>
              <div class="row d-flex justify-content-center align-items-between">
                <div class="col-5 col-md-5">
                  <p>
                    Monitor: {{ actividad.monitor ? actividad.monitor.nombre : 'N/A' }} {{ actividad.monitor ? actividad.monitor.apellido : 'N/A' }}
                  </p>
                  <p>Edad Mínima: {{ actividad.edad_min !== null ? actividad.edad_min : 'N/A' }}</p>
                  <p class="w-75">
                    Horario:
                    <span v-if="actividad.horarios && actividad.horarios.length > 0">
                      <span v-for="horario in actividad.horarios" :key="horario.id">
                        {{ formatDateTime(horario.fecha, horario.hora_inicio, horario.hora_fin) }}
                      </span>
                    </span>
                    <span v-else>No Horarios</span>
                  </p>

                </div>
                <div class="col-3 col-md-3 px-0">

                  <p class="center" style="font-size: 1em;">Centro Cívico:</p>
                  <p class="center bold"> {{ actividad.centro_civico ? actividad.centro_civico.nombre : 'N/A' }}</p>
                </div>
                <div class="col-4 col-md-4 d-flex justify-content-center align-items-center">
                  <button class="cssbuttons-io">
                    <span>inscríbete</span>
                  </button>
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
import { computed, ref, onMounted, watch } from 'vue';
import useActividades from '../composables/useActividades';
import useCategorias from "../composables/useCategorias"

export default {
  setup() {
    const { actividades, loading, error, fetchActividades, categoryId, setCategory } = useActividades();
    const { categorias, fetchCategorias } = useCategorias()

    const categoriaNombre = computed(() => {
      const categoria = categorias.value.find(cat => cat.id === categoryId.value);
      return categoria ? categoria.nombre.toUpperCase() : 'TENIS';
    });

    // Local refs for filter selections
    const selectedCentroCivico = ref('');
    const selectedEdad = ref('');
    const selectedIdioma = ref('');
    const selectedHorario = ref('');

    // Local ref for the selected category
    const selectedCategoryId = ref(null);

    // Fetch centros civicos (replace with your actual data fetching)
    const centrosCivicos = ref([
      { id: 1, nombre: 'Ibaiondo' },
      { id: 2, nombre: 'Aldabe' },
      { id: 3, nombre: 'El Pilar' },
      { id: 4, nombre: 'Arriaga' },
      { id: 5, nombre: 'Salburua' }
    ]);

    const filteredActividades = computed(() => {
      let filtered = [...actividades.value];

      // Apply Centro Civico filter
      if (selectedCentroCivico.value) {
        if (selectedCentroCivico.value === 'all') {
          // Do nothing, show all centers
        } else {
          filtered = filtered.filter(actividad => {
            return actividad.centro_civico && actividad.centro_civico.id === parseInt(selectedCentroCivico.value);
          });
        }
      }

      // Apply Edad filter
      if (selectedEdad.value) {
        filtered = filtered.filter(actividad => {
          return actividad.edad_min !== null && actividad.edad_min >= parseInt(selectedEdad.value);
        });
      }

      // Apply Idioma filter
      if (selectedIdioma.value) {
        if (selectedIdioma.value !== '') { // Check if a specific language is selected
          filtered = filtered.filter(actividad => {
            return actividad.idioma === selectedIdioma.value;
          });
        }
      }

      // Apply Horario filter
      if (selectedHorario.value) {
        if (selectedHorario.value !== '') {
          filtered = filtered.filter(actividad => {
            if (!actividad.horarios || actividad.horarios.length === 0) {
              return false;
            }

            return actividad.horarios.some(horario => {
              const horaInicio = parseInt(horario.hora_inicio.substring(0, 2));
              switch (selectedHorario.value) {
                case 'manana':
                  return horaInicio >= 6 && horaInicio < 12;
                case 'tarde':
                  return horaInicio >= 12 && horaInicio < 18;
                case 'noche':
                  return horaInicio >= 18 || horaInicio < 6;
                default:
                  return true;
              }
            });
          });
        }
      }

      return filtered;
    });

    const applyFilters = () => {
      // No need to do anything here.  The `filteredActividades` computed property
      // will automatically recalculate when the filter refs change.
    };

    const changeCategory = async () => {
      setCategory(selectedCategoryId.value);
      await fetchActividades(); // Re-fetch activities for the new category
    };

    onMounted(async () => {
      await fetchCategorias();

      // Find the tenis category
      const tenisCategory = categorias.value.find(category => category.nombre.toLowerCase() === 'tenis');

      if (tenisCategory) {
        selectedCategoryId.value = tenisCategory.id;
        setCategory(tenisCategory.id);
        await fetchActividades();
      } else {
        console.warn("Tenis category not found. Loading first category instead.");

        if (categorias.value && categorias.value.length > 0) {
          selectedCategoryId.value = categorias.value[0].id;
          setCategory(categorias.value[0].id);
          await fetchActividades();
        }
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
      formatDateTime,
      centrosCivicos,
      categoriaNombre,
      selectedCentroCivico,
      selectedEdad,
      selectedIdioma,
      selectedHorario,
      filteredActividades,
      applyFilters,
      categories: computed(() => categorias.value),
      selectedCategoryId,
      changeCategory
    };
  }
};
</script>

<style scoped>
/* Styles - No change needed unless you want to adapt the new content */
/* Base styles */
.container {
  display: flex;
  font-family: sans-serif;
  color: white;
  background-color: #313a0a;
  padding: 0;
  min-height: 100vh;
  max-width: 100%;
  background-image: url(../assets/img/fondoTenis.png);
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
}

.titulo {
  margin-top: -1em;
  margin-left: 1.1em;
}

.titulo h1 {
  font-size: 1.4em;
  font-family: Heaven, sans-serif; /* Usar Heaven */
  text-align: left;
  margin: 0;
  font-weight: 800;
  font-style: italic;
  line-height: 0.8;
  color: #f0f0f0;

}

/* Right side: Scrollable Activity Blocks */
.right-side-scrollable {
  overflow-y: auto;
  position: relative;
  /* Required for absolute positioning of fade */
  height: 100vh;
  padding: 20px 0px 20px 100px;
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
  background-color: #f0f0f0;
  /* Color of the scroll thumb */
  border-radius: 8px;
  /* Rounded corners of the scroll thumb */
  width: 12px !important;

}

.right-side-scrollable::-webkit-scrollbar-thumb:hover {
  background-color: white;
  /* Color of the scroll thumb on hover */
}


.right-side {
  display: flex;
  flex-direction: column;
  padding: 20px;

}

/* Activity block styles */
.activity-block {
  background-color: #313a0a; /* Usar #313a0a */
  border: 1px solid #f0f0f05a;
  padding: 20px 20px 10px 20px;
  margin-bottom: 20px;
  border-radius: 5px;
  position: relative;
  overflow: hidden;
  width: 700px;
  margin-right: 6em;
  color: #f0f0f0;
}

hr {
  height: 1px;
  background-color: #f0f0f0;
  opacity: 1;
}

.activity-block.faded {
  opacity: 0.3;
  background-color: #313a0a;
}

.activity-block h2 {
  margin: 0px 0px 10px 0px;
  font-size: 3em;
  font-family: Heaven, sans-serif; /* Usar Heaven */
  font-style: normal;
  font-weight: 700;
  word-spacing: 0.2em; /* Añadir espacio entre palabras */
}

.activity-block p {
  margin-bottom: 0px;
  font-family: Inter;
  font-weight: 300;
  letter-spacing: -0.03em;
}

.activity-block .center {

  font-size: .85em;
}

.activity-block .bold {
  font-weight: 300;
  font-style: normal;
  font-family: Inter;
  font-size: 3em;
  margin-top: -.2em;
  padding: 0;
  letter-spacing: -0.06em;

}

.cssbuttons-io {
  border-radius: 55px;
  margin-bottom: -.2em;
  margin-left: .5em;
  border: none;
  background: linear-gradient(to right, #f0f0f0c8, #f0f0f0);
  /* Degradado */
  color: #313a0a;
  /* Letras negras por defecto */
  overflow: hidden;
  transition: all 0.4s;
  /* Transición para todas las propiedades */
  position: relative;
  z-index: 10;
  display: inline-flex;
  align-items: center;
}

.cssbuttons-io span {
  font-weight: 700;
  font-style: italic;
  font-size: 2.2em;
  font-family: Heaven, sans-serif;
  padding: 3px 24px 0px 20px;
  cursor: pointer;
}

.cssbuttons-io::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: #000000;
  /* Fondo blanco por defecto */
  z-index: -1;
  /* Poner el degradado detrás del texto */
  transform: translateX(-100%);
  /* Ocultar el degradado inicialmente */
  transition: transform 0.4s cubic-bezier(0.3, 1, 0.8, 1);
  /* Transición para la animación */
}

.cssbuttons-io:hover {
  color: #f0f0f0;
  /* Letras negras al hacer hover */
}

.cssbuttons-io:hover::before {
  transform: translateX(0);
  /* Mostrar el degradado al hacer hover */
}

.cssbuttons-io span:active {
  transform: scale(0.95);
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
  height: 200px;
  /* Increased the height of the fade */
  background: linear-gradient(to bottom, rgba(49, 58, 10, 0), #313a0ad6, #313a0a);
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
  background-color: #000000;
  color: #f0f0f0;

  margin: 0 auto;
  /* Centra horizontalmente */
  max-width: 600px;
  /* Ancho máximo del filtro */
}

.filtro select {
  background-color: transparent !important;
  color: #f0f0f0;
  border: 0px;
  padding: 10px;
  font-family: Inter;
  font-weight: 300;
  letter-spacing: -0.03em;
}

.filtro option {
  background-color: #000000;
  color: #f0f0f0;
}

.font-weight-bold {
  font-weight: bold;
}

/* Responsive design */
@media (max-width: 1024px) {
  .container {
    flex-direction: column;
    align-items: stretch;
    background: none;
    background-color: #313a0a; /* Asegura que el color de fondo se mantenga */
  }

  .titulo {
    margin: 2em 0em;
    margin-left: 0;
    text-align: center;
  }

  .titulo h1 {
    font-size: 2em;
    text-align: center;
  }

  .filters {
    position: relative;
    top: auto;
    left: auto;
    transform: none;
    padding: 10px;
    width: 90%;
    box-sizing: border-box;
  }

  .filtro {
    max-width: 100%;
    flex-direction: column;
  }

  .filtro select {
    margin-bottom: 0.5em;
    width: 95%;
    box-sizing: border-box;
  }

  .right-side-scrollable {
    width: 100%;
    margin-top: 1em;
    margin-left: 0;
    height: auto;
    box-sizing: border-box;
    padding: 20px; /* Añadido: Espaciado para el contenido */
  }

  .right-side {
    padding: 0; /* Añadido:  Elimina padding interno */
  }

  .activity-block {
    width: 100%;  /* Ocupa todo el ancho disponible */
    margin-right: 0; /* Elimina margen derecho */
    margin-bottom: 20px; /* Restaura el margen inferior */
    padding: 20px; /* Reduce el padding para que quepa en pantallas más pequeñas */
  }

  .activity-block h2 {
    font-size: 3em;
  }

  .activity-block p {
    font-size: 1em;
  }

  .cssbuttons-io {
    width: 100%; /*Boton ocupar todo el ancho*/
    display: flex;
    justify-content: center;
  }

  .cssbuttons-io span {
    font-size: 1.4em; /*Bajar tamaño de fuente del boton*/
  }

  /* Ajustes para pantallas aún más pequeñas (móviles) */
  @media (max-width: 576px) {
    .titulo h1 {
      font-size: 2em; /* Aún más pequeño en móviles */
    }


    .activity-block .bold {
      font-size: 2.5em;
    }
  }
}
</style>