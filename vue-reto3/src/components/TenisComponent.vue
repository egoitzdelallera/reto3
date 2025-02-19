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
          <select
            id="centroCivico"
            v-model="selectedCentroCivico"
            @change="handleCentroCivicoChange"
            :class="{ 'font-weight-bold': selectedCentroCivico }"
          >
            <option value="" disabled selected hidden>Centro Cívico</option>
            <option value="all">Todos los centros</option>
            <option v-for="centro in centrosCivicos" :key="centro.id" :value="centro.id">
              {{ centro.nombre }}
            </option>
            <option value="ubicacion">Filtrar por ubicación</option>
          </select>
          <select
            id="edad"
            v-model="selectedEdad"
            @change="applyFilters"
            :class="{ 'font-weight-bold': selectedEdad }"
          >
            <option value="" disabled selected hidden>Edad</option>
            <option value="">Todas</option>
            <option value="6">+ 6 años</option>
            <option value="8">+ 8 años</option>
            <option value="10">+ 10 años</option>
            <option value="16">+ 16 años</option>
          </select>
          <select
            id="idioma"
            v-model="selectedIdioma"
            @change="applyFilters"
            :class="{ 'font-weight-bold': selectedIdioma }"
          >
            <option value="" disabled selected hidden>Idioma</option>
            <option value="">Todos</option>
            <option value="Español">Español</option>
            <option value="Euskera">Euskera</option>
          </select>
          <select
            id="horario"
            v-model="selectedHorario"
            @change="applyFilters"
            :class="{ 'font-weight-bold': selectedHorario }"
          >
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
            <div v-if="filteredAndSortedActividades.length === 0">
              <p>No hay actividades disponibles con estos criterios.</p>
            </div>
            <div
              v-else
              v-for="actividad in filteredAndSortedActividades"
              :key="actividad.id"
              class="activity-block"
            >
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
                <hr class="mb-3" />
              </div>
              <div class="row d-flex justify-content-center align-items-between">
                <div class="col-5 col-md-5">
                  <p>
                    Monitor:
                    {{ actividad.monitor ? actividad.monitor.nombre : 'N/A' }}
                    {{ actividad.monitor ? actividad.monitor.apellido : 'N/A' }}
                  </p>
                  <p>
                    Edad Mínima:
                    {{ actividad.edad_min !== null ? actividad.edad_min : 'N/A' }}
                  </p>
                  <p class="w-75">
                    Horario:
                    <span v-if="actividad.horarios && actividad.horarios.length > 0">
                      <span v-for="horario in actividad.horarios" :key="horario.id">
                        {{
                          formatDateTime(
                            horario.fecha,
                            horario.hora_inicio,
                            horario.hora_fin
                          )
                        }}
                      </span>
                    </span>
                    <span v-else>No Horarios</span>
                  </p>
                </div>
                <div class="col-3 col-md-3 px-0">
                  <p class="center" style="font-size: 1em">Centro Cívico:</p>
                  <p class="center bold">
                    {{ actividad.centro_civico ? actividad.centro_civico.nombre : 'N/A' }}
                  </p>
                  <!-- Display Distance -->
                  <p v-if="userLatitude && userLongitude && actividad.centro_civico">
                    Distancia: {{ calculateDistanceToCentroCivico(actividad.centro_civico.latitud, actividad.centro_civico.longitud) }} km
                  </p>
                  <!-- Get Directions Button -->

                </div>
                <div class="col-4 col-md-4 d-flex flex-column justify-content-center align-items-center">
                  <div class="row">
                    <button
                    v-if="actividad.centro_civico"
                    @click="handleGetDirections(actividad.centro_civico.latitud, actividad.centro_civico.longitud)"
                    class=" cssbuttons-io2">
                    <span>Cómo llegar</span> 
                  </button>
                  </div>
                  <div class="row">
                    <button class="cssbuttons-io" @click="openInscriptionModal(actividad)">
                      <span>inscríbete</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="scroll-fade"></div>
      </div>
    </div>

    <!-- Custom Modal -->
    <div v-if="showLocationModal" class="modal">
      <div class="modal-content">
        <h3>¿Permitir acceso a tu ubicación?</h3>
        <p>Necesitamos tu ubicación para mostrar las actividades más cercanas.</p>
        <div class="modal-buttons">
          <button @click="handleAllowLocation">Permitir</button>
          <button @click="handleDenyLocation">Denegar</button>
        </div>
      </div>
    </div>
    <!-- Explanation Modal -->
    <div v-if="showLocationExplanation" class="modal">
      <div class="modal-content">
        <h3>Permisos de ubicación desactivados</h3>
        <p>
          Por favor activa los permisos de ubicación en la configuración de tu
          navegador para utilizar esta función.
        </p>
        <div class="modal-buttons">
          <button @click="closeExplanation">Entendido</button>
        </div>
      </div>
    </div>

     <!-- Location Request Modal -->
    <div v-if="showLocationRequestModal" class="modal">
      <div class="modal-content">
        <h3>¿Permitir acceso a tu ubicación?</h3>
        <p>Necesitamos tu ubicación para mostrarte las indicaciones de cómo llegar.</p>
        <div class="modal-buttons">
          <button @click="handleAllowLocationRequest">Permitir</button>
          <button @click="handleDenyLocationRequest">Denegar</button>
        </div>
      </div>
    </div>

      <!-- Modal de inscripción (renderizado condicionalmente) -->
    <InscriptionForm
      v-if="showInscriptionModal"
      :actividad="selectedActividad"
      @inscription-success="handleInscriptionSuccess"
      @inscription-error="handleInscriptionError"
      @close="closeInscriptionModal"
    />
  </div>
</template>

<script>
import { computed, ref, onMounted, nextTick } from 'vue';
import useActividades from '../composables/useActividades';
import useCategorias from '../composables/useCategorias';
import InscriptionForm from './InscriptionForm.vue';  // Importa el componente
import { Modal } from 'bootstrap'; // Import Bootstrap's Modal


export default {
  components: {
    InscriptionForm // Registra el componente
  },
  setup() {
    const { actividades, loading, error, fetchActividades, categoryId, setCategory } =
      useActividades();
    const { categorias, fetchCategorias } = useCategorias();

    const categoriaNombre = computed(() => {
      const categoria = categorias.value.find((cat) => cat.id === categoryId.value);
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
      { id: 5, nombre: 'Salburua' },
    ]);

    const userLatitude = ref(null);
    const userLongitude = ref(null);

    const showLocationModal = ref(false);
    const showLocationExplanation = ref(false);

    // New modal to request location permission
    const showLocationRequestModal = ref(false);

    // Refs para el modal y la actividad seleccionada
    const inscriptionModal = ref(null);
    const selectedActividad = ref(null);
    const showInscriptionModal = ref(false); // Controla si se muestra el modal

    const filteredActividades = computed(() => {
      let filtered = [...actividades.value];

      // Apply Centro Civico filter
      if (selectedCentroCivico.value) {
        if (selectedCentroCivico.value === 'all') {
          // Do nothing, show all centers
        } else if (selectedCentroCivico.value === 'ubicacion') {
          // Handled by getLocation and sorting
        } else {
          filtered = filtered.filter((actividad) => {
            return (
              actividad.centro_civico &&
              actividad.centro_civico.id === parseInt(selectedCentroCivico.value)
            );
          });
        }
      }

      // Apply Edad filter
      if (selectedEdad.value) {
        if (selectedEdad.value !== '') {
          filtered = filtered.filter((actividad) => {
            return (
              actividad.edad_min !== null && actividad.edad_min >= parseInt(selectedEdad.value)
            );
          });
        }
      }

      // Apply Idioma filter
      if (selectedIdioma.value) {
        if (selectedIdioma.value !== '') {
          // Check if a specific language is selected
          filtered = filtered.filter((actividad) => {
            return actividad.idioma === selectedIdioma.value;
          });
        }
      }

      // Apply Horario filter
      if (selectedHorario.value) {
        if (selectedHorario.value !== '') {
          filtered = filtered.filter((actividad) => {
            if (!actividad.horarios || actividad.horarios.length === 0) {
              return false;
            }

            return actividad.horarios.some((horario) => {
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

    const filteredAndSortedActividades = computed(() => {
      let filtered = [...filteredActividades.value];
      if (
        selectedCentroCivico.value === 'ubicacion' &&
        userLatitude.value &&
        userLongitude.value
      ) {
        // Sort by distance
        filtered.sort((a, b) => {
          const distanceA = calculateDistance(
            userLatitude.value,
            userLongitude.value,
            a.centro_civico.latitud,
            a.centro_civico.longitud
          );
          const distanceB = calculateDistance(
            userLatitude.value,
            userLongitude.value,
            b.centro_civico.latitud,
            b.centro_civico.longitud
          );
          return distanceA - distanceB;
        });
      }
      return filtered;
    });

    const applyFilters = () => {
      // No need to do anything here. The `filteredActividades` computed property
      // will automatically recalculate when the filter refs change.
    };

    const handleCentroCivicoChange = () => {
      if (selectedCentroCivico.value === 'ubicacion') {
        showLocationModal.value = true;
      } else {
        applyFilters();
      }
    };

    const handleAllowLocation = () => {
      showLocationModal.value = false;
      getLocation();
    };

    const handleDenyLocation = () => {
      showLocationModal.value = false;
      selectedCentroCivico.value = '';
    };

    const getLocation = () => {
      if ('geolocation' in navigator) {
        navigator.geolocation.getCurrentPosition(
          (position) => {
            userLatitude.value = position.coords.latitude;
            userLongitude.value = position.coords.longitude;

            // Guardar en localStorage
            localStorage.setItem('userLatitude', userLatitude.value);
            localStorage.setItem('userLongitude', userLongitude.value);

            console.log(
              `Ubicación obtenida: Latitud ${userLatitude.value}, Longitud ${userLongitude.value}`
            );
          },
          (error) => {
            console.error('Error obteniendo ubicación:', error);
            // Check if the error is due to denied permission.
            if (error.code === error.PERMISSION_DENIED) {
              showLocationExplanation.value = true;
            } else {
              alert('No se pudo obtener la ubicación');
              selectedCentroCivico.value = ''; // Resetear la selección
            }
          }
        );
      } else {
        alert('Tu navegador no soporta geolocalización');
        selectedCentroCivico.value = ''; // Resetear la selección
      }
    };

    const closeExplanation = () => {
      showLocationExplanation.value = false;
      selectedCentroCivico.value = '';
    };

    const changeCategory = async () => {
      setCategory(selectedCategoryId.value);
      await fetchActividades(); // Re-fetch activities for the new category
    };

    // Helper function to calculate distance between two coordinates (Haversine formula)
    function calculateDistance(lat1, lon1, lat2, lon2) {
      const R = 6371; // Radius of the earth in km
      const dLat = deg2rad(lat2 - lat1);
      const dLon = deg2rad(lon2 - lon1);
      const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      const distance = R * c; // Distance in km
      return distance;
    }

    function deg2rad(deg) {
      return deg * (Math.PI / 180);
    }

    const applyCachedFilters = (categoryId) => {
      const cachedFilters = getCachedFilters(categoryId);
      if (cachedFilters) {
        selectedCentroCivico.value = cachedFilters.centroCivico || '';
        selectedEdad.value = cachedFilters.edad || '';
        selectedIdioma.value = cachedFilters.idioma || '';
        selectedHorario.value = cachedFilters.horario || '';
      } else {
        // Apply default filters if no filters are cached
        selectedCentroCivico.value = '';  // Changed to empty string
        selectedEdad.value = '';  // Changed to empty string
        selectedIdioma.value = '';  // Changed to empty string
        selectedHorario.value = '';  // Changed to empty string
      }
      console.log('Applied cached filters:', getCachedFilters(categoryId));
    };

    const getCachedFilters = (categoryId) => {
      const cachedFilters = localStorage.getItem(`filters_${categoryId}`);
      return cachedFilters ? JSON.parse(cachedFilters) : null;
    };

    onMounted(async () => {

        // Cargar ubicación desde localStorage al montar el componente
        const storedLatitude = localStorage.getItem('userLatitude');
        const storedLongitude = localStorage.getItem('userLongitude');

        if (storedLatitude && storedLongitude) {
          userLatitude.value = parseFloat(storedLatitude);
          userLongitude.value = parseFloat(storedLongitude);
        }


      await fetchCategorias();

      // Find the tenis category
      const tenisCategory = categorias.value.find(
        (category) => category.nombre.toLowerCase() === 'tenis'
      );

      if (tenisCategory) {
        selectedCategoryId.value = tenisCategory.id;
        setCategory(tenisCategory.id);
        applyCachedFilters(tenisCategory.id); // Apply cached filters on mount
        await fetchActividades();
      } else {
        console.warn('Tenis category not found. Loading first category instead.');

        if (categorias.value && categorias.value.length > 0) {
          selectedCategoryId.value = categorias.value[0].id;
          setCategory(categorias.value[0].id);
           applyCachedFilters(categorias.value[0].id); // Apply cached filters on mount
          await fetchActividades();
        }
      }
    });

    // Helper function to get the day of the week
    const getDayOfWeek = (dateString) => {
      const date = new Date(dateString);
      const daysOfWeek = [
        'Domingo',
        'Lunes',
        'Martes',
        'Miércoles',
        'Jueves',
        'Viernes',
        'Sábado',
      ];
      return daysOfWeek[date.getDay()];
    };

    // Helper function to format date, day of week, and time
    const formatDateTime = (dateString, startTime, endTime) => {
      const date = new Date(dateString);
      const dayOfWeek = getDayOfWeek(dateString);
      const formattedDate = date.toLocaleDateString('es-ES');
      const formattedStartTime = new Date(`1970-01-01T${startTime}`).toLocaleTimeString(
        'es-ES',
        { hour: '2-digit', minute: '2-digit' }
      );
      const formattedEndTime = new Date(`1970-01-01T${endTime}`).toLocaleTimeString(
        'es-ES',
        { hour: '2-digit', minute: '2-digit' }
      );

      return `${dayOfWeek}, ${formattedDate} - ${formattedStartTime} - ${formattedEndTime}`;
    };

    // Helper function to calculate distance to a centro civico, using the user's stored coordinates.
    const calculateDistanceToCentroCivico = (centroCivicoLat, centroCivicoLon) => {
      if (userLatitude.value !== null && userLongitude.value !== null && centroCivicoLat && centroCivicoLon) {
        const distance = calculateDistance(
          userLatitude.value,
          userLongitude.value,
          centroCivicoLat,
          centroCivicoLon
        );
        return distance.toFixed(2); // Retornar la distancia con dos decimales
      } else {
        return 'N/A'; // Retornar 'N/A' si las coordenadas no están disponibles
      }
    };

    // Function to open Google Maps with directions
    const openGoogleMaps = (latitude, longitude) => {
      let origin = '';
      if (userLatitude.value && userLongitude.value) {
        origin = `&origin=${userLatitude.value},${userLongitude.value}`;  // Use user's location
      }
      const url = `https://www.google.com/maps/dir/?api=1&destination=${latitude},${longitude}${origin}&travelmode=driving`;
      window.open(url, '_blank');
    };

    //Handles the "Get Directions" button click, checking for location permissions
    const handleGetDirections = (latitude, longitude) => {
      if (userLatitude.value && userLongitude.value) {
        // Location already available, open Google Maps directly
        openGoogleMaps(latitude, longitude);
      } else {
        // Location not available, show the location request modal
        showLocationRequestModal.value = true;
      }
    };

    //Handles allowing location from the location request modal
    const handleAllowLocationRequest = () => {
      showLocationRequestModal.value = false;
      getLocationAfterRequest(); //Get location only after user allows
    };

    //Handles denying location from the location request modal
    const handleDenyLocationRequest = () => {
      showLocationRequestModal.value = false;
      // Optionally, provide some feedback to the user.
      alert('No se puede mostrar las indicaciones sin permiso de ubicación.');
    };

    //Gets the location and then opens Google Maps. Call only after user grants permission
    const getLocationAfterRequest = () => {
      if ('geolocation' in navigator) {
        navigator.geolocation.getCurrentPosition(
          (position) => {
            userLatitude.value = position.coords.latitude;
            userLongitude.value = position.coords.longitude;

            // Guardar en localStorage
            localStorage.setItem('userLatitude', userLatitude.value);
            localStorage.setItem('userLongitude', userLongitude.value);
              //Open Google Maps after obtaining location
            openGoogleMaps(latitude, longitude);

            console.log(
              `Ubicación obtenida: Latitud ${userLatitude.value}, Longitud ${userLongitude.value}`
            );
          },
          (error) => {
            console.error('Error obteniendo ubicación:', error);
            // Check if the error is due to denied permission.
            if (error.code === error.PERMISSION_DENIED) {
              showLocationExplanation.value = true;
            } else {
              alert('No se pudo obtener la ubicación');
            }
          }
        );
      } else {
        alert('Tu navegador no soporta geolocalización');
      }
    };

     // Función para abrir el modal de inscripción
    const openInscriptionModal = (actividad) => {
      selectedActividad.value = actividad;
      showInscriptionModal.value = true; // Muestra el modal

      // Espera a que el DOM se actualice y luego inicializa el modal
      nextTick(() => {
        const inscriptionModalEl = document.getElementById('inscriptionModal');
        if (inscriptionModalEl) {
          inscriptionModal.value = new Modal(inscriptionModalEl);
          inscriptionModal.value.show();
        } else {
          console.error('El elemento con ID "inscriptionModal" no se encontró en el DOM.');
        }
      });
    };

    // Función para manejar el éxito de la inscripción
    const handleInscriptionSuccess = (data) => {
      console.log("Inscripción exitosa en el componente padre:", data);
      closeInscriptionModal();
    };

    // Función para manejar el error de la inscripción
    const handleInscriptionError = (error) => {
      // Realizar acciones de manejo de errores
    };

    // Función para cerrar el modal
    const closeInscriptionModal = () => {
       if (inscriptionModal.value) {
        inscriptionModal.value.hide(); // Cierra el modal de Bootstrap
      }
      showInscriptionModal.value = false; // Oculta el componente InscriptionForm
      selectedActividad.value = null; // Limpia la actividad seleccionada
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
      filteredAndSortedActividades,
      applyFilters,
      categories: computed(() => categorias.value),
      selectedCategoryId,
      changeCategory,

      handleCentroCivicoChange,
      handleAllowLocation,
      handleDenyLocation,
      showLocationModal,
      showLocationExplanation,

      userLatitude,
      userLongitude,
      applyCachedFilters,
      getCachedFilters,

      calculateDistanceToCentroCivico,
      openGoogleMaps,

      handleGetDirections,
      showLocationRequestModal,
      handleAllowLocationRequest,
      handleDenyLocationRequest,

      openInscriptionModal,
      selectedActividad,
      handleInscriptionSuccess,
      handleInscriptionError,
      showInscriptionModal,
      closeInscriptionModal
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
  font-size: 0.85em;
}

.activity-block .bold {
  font-weight: 300;
  font-style: normal;
  font-family: Inter;
  font-size: 3em;
  margin-top: -0.2em;
  padding: 0;
  letter-spacing: -0.06em;
}

.cssbuttons-io {
  border-radius: 55px;
  margin-bottom: -0.2em;
  margin-left: 0.5em;
  border: none;
  background: linear-gradient(to right, #f0f0f0c8, #f0f0f0);
  /* Degradado */
  color: #313a0a;
  /* Letras negras por defecto */
  overflow: hidden;
  transition: all 0.4s;
  /* Transición para todas las properties */
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
  content: '';
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
  /* Ocultar el degradado initially */
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

.cssbuttons-io2 {
  border-radius: 55px;
  margin-bottom: 1em;
  margin-left: 0.5em;
  border: none;
  background: linear-gradient(to right, #f0f0f0c8, #f0f0f0);
  /* Degradado */
  color: #313a0a;
  /* Letras negras por defecto */
  overflow: hidden;
  transition: all 0.4s;
  /* Transición para todas las properties */
  position: relative;
  z-index: 10;
  display: inline-flex;
  align-items: center;
}

.cssbuttons-io2 span {
  font-weight: 700;
  font-style: italic;
  font-size: 1.2em;
  font-family: Heaven, sans-serif;
  padding: 3px 24px 0px 20px;
  cursor: pointer;
}

.cssbuttons-io2::before {
  content: '';
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
  /* Ocultar el degradado initially */
  transition: transform 0.4s cubic-bezier(0.3, 1, 0.8, 1);
  /* Transición para la animación */
}

.cssbuttons-io2:hover {
  color: #f0f0f0;
  /* Letras negras al hacer hover */
}

.cssbuttons-io2:hover::before {
  transform: translateX(0);
  /* Mostrar el degradado al hacer hover */
}

.cssbuttons-io2 span:active {
  transform: scale(0.95);
}


.activity-block .schedule {
  position: absolute;
  bottom: 20px;
  left: 20px;
}


/* Styles for the Get Directions button */
.get-directions-button {
  border-radius: 55px;
  margin-bottom: -0.2em;
  margin-left: 0.5em;
  border: none;
  background: linear-gradient(to right, #f0f0f0c8, #f0f0f0);
  /* Degradado */
  color: #313a0a;
  transition: 0.5s;
  margin-bottom: 10px;
  font-style: italic;
}
.get-directions-button:hover {
  background: linear-gradient(to right, #0f0f0fc8, #3a3a3a);
  color:white; /* Darker green on hover */
}

.get-directions-button i {
  margin-right: 5px; /* Space between icon and text */
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
  max-width: 600px;

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

@media (max-width: 1024px) {
.container {
flex-direction: column;
align-items: stretch;
background: none;
background-color: #313a0a;
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
padding: 0; /* Añadido: Elimina padding interno */
}

.activity-block {
width: 100%; /* Ocupa todo el ancho disponible /
margin-right: 0; / Elimina margen derecho /
margin-bottom: 20px; / Restaura el margen inferior /
padding: 20px; / Reduce el padding para que quepa en pantallas más pequeñas */
}

.activity-block h2 {
font-size: 3em;
}

.activity-block p {
font-size: 1em;
}

.cssbuttons-io {
width: 100%; /* Boton ocupar todo el ancho*/
display: flex;
justify-content: center;
}

.cssbuttons-io span {
font-size: 1.4em; /* Bajar tamaño de fuente del boton*/
}

@media (max-width: 576px) {
.titulo h1 {
font-size: 2em; 
}
.activity-block .bold {
  font-size: 2.5em;
}
}
}



.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999; /* Ensure it's on top of everything */
}

.modal-content {
    background-color: rgb(20, 20, 20);
    padding: 20px;
    border-radius: 5px;
    text-align: center;
}
.modal-content h3,
.modal-content p {
  color:rgb(225, 225, 225);
font-family: Inter;
font-weight: 300;
letter-spacing: -0.05em;
}
.modal-content h3 {

font-weight: 700;
}
.modal-buttons {
    margin-top: 20px;
}

.modal-buttons button {
    padding: 5px 15px;
    border: none;
    background-color: #313a0a;
    color: rgb(255, 255, 255);
    border-radius: 4px;
    cursor: pointer;
    margin:0em 1em;
}

.modal-buttons button:hover {
    background-color: #3d480c;
}
</style>