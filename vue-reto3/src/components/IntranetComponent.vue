<script setup>
import { ref, computed, onMounted } from "vue";
import api from "@/plugins/axios"; // Importamos nuestra configuración de Axios
import * as bootstrap from 'bootstrap';

// Estados reactivos
const centrosCivicos = ref([]);
const actividades = ref([]);
const monitores = ref([]);
const tiposActividades = ref([]);

const centrosCivicosLoading = ref(false);
const actividadesLoading = ref(false);
const centrosCivicosError = ref(null);
const actividadesError = ref(null);
const errorMessage = ref(null);

const showAllCentrosCivicos = ref(false);
const showAllActividades = ref(false);
const searchQuery = ref("");

const currentSection = ref("");
const modifyingItem = ref({
  nombre: "",
  descripcion: "",
  id_tipo_actividad: "",
  id_centro_civico: "",
  id_monitor: ""
});
const newItemName = ref("");
const newItemDescription = ref("");
const selectedTipoActividad = ref("");
const selectedCentroCivico = ref("");
const selectedMonitor = ref("");
const newItemIdioma = ref("");
const newItemEdadMin = ref("");
const newItemEdadMax = ref("");
const newItemFecha = ref("");
const newItemHoraInicio = ref("");
const newItemHoraFin = ref("");
const newItemMultimedia = ref("");

const newItemUbicacion = ref("");
const newItemLatitud = ref("");
const newItemLongitud = ref("");
const newItemUrl = ref("");
const newItemTelefono = ref("");
const newItemCorreo = ref("");

// Referencias a modales
const modifyModal = ref(null);
const addItemModal = ref(null);

// Computed para mostrar solo ciertos elementos en la lista
const displayedCentrosCivicos = computed(() =>
  showAllCentrosCivicos.value ? centrosCivicos.value : centrosCivicos.value.slice(0, 6)
);

const displayedActividades = computed(() => {
  let filtered = actividades.value;
  if (searchQuery.value) {
    filtered = filtered.filter((actividad) =>
      actividad.nombre.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  }
  return showAllActividades.value ? filtered : filtered.slice(0, 6);
});

// Cargar datos desde la API
const fetchCentrosCivicos = async () => {
  centrosCivicosLoading.value = true;
  try {
    const response = await api.get("/centro_civico");
    centrosCivicos.value = response.data;
  } catch (error) {
    centrosCivicosError.value = error.message || "Error al cargar los Centros Cívicos";
  } finally {
    centrosCivicosLoading.value = false;
  }
};

const fetchActividades = async () => {
  actividadesLoading.value = true;
  try {
    const response = await api.get("/actividades");
    actividades.value = response.data;
  } catch (error) {
    actividadesError.value = error.message || "Error al cargar las Actividades";
  } finally {
    actividadesLoading.value = false;
  }
};

const fetchMonitores = async () => {
  try {
    const response = await api.get("/monitores");
    monitores.value = response.data;
  } catch (error) {
    console.error("Error al cargar monitores:", error);
  }
};

const fetchTiposActividades = async () => {
  try {
    const response = await api.get("/tipos_actividades");
    tiposActividades.value = response.data;
  } catch (error) {
    console.error("Error al cargar tipos de actividades:", error);
  }
};

// Mostrar modales
const showAddItemPopup = (section) => {
  currentSection.value = section;
  newItemName.value = "";
  newItemDescription.value = "";
  selectedTipoActividad.value = "";
  selectedCentroCivico.value = "";
  selectedMonitor.value = "";
  errorMessage.value = null;

  const modalElement = addItemModal.value;

  const modalInstance = new bootstrap.Modal(modalElement);

  modalInstance.show();
};

const showModifyPopup = (item, section) => {
  // Ensure modifyingItem is initialized, especially if the section is "actividades"
  modifyingItem.value = item || {};  // Fallback to empty object if item is null or undefined
  currentSection.value = section;
  errorMessage.value = null;

  // Now safely access 'descripcion' and other properties
  const modalElement = modifyModal.value;
  const modalInstance = new bootstrap.Modal(modalElement);
  modalInstance.show();
};


// Alternar visibilidad de listas
const toggleShowAllCentrosCivicos = () => {
  showAllCentrosCivicos.value = !showAllCentrosCivicos.value;
};

const toggleShowAllActividades = () => {
  showAllActividades.value = !showAllActividades.value;
};

// Guardar modificaciones
const saveModification = async () => {
  if (!modifyingItem.value || !modifyingItem.value.nombre) {
    errorMessage.value = "El nombre no puede estar vacío.";
    return;
  }

  try {
    await api.put(`/${currentSection.value}/${modifyingItem.value.id}`, modifyingItem.value);
    console.log("Modificación guardada:", modifyingItem.value);
    console.log("Sección actual:", currentSection.value);

    // Actualizar la lista según la sección
    if (currentSection.value === "centro_civico") {
      fetchCentrosCivicos();
    } else if (currentSection.value === "actividades") {
      fetchActividades();
    } else if (currentSection.value === "tipos_actividades") {
      fetchTiposActividades(); // Asegúrate de tener esta función en tu código
    }

    // Cerrar el modal después de guardar los cambios
    const modal = bootstrap.Modal.getInstance(document.getElementById("modifyModal"));
    if (modal) modal.hide();
    
  } catch (error) {
    errorMessage.value = error.message || "Error al guardar los cambios.";
  }
};


// Añadir nuevo item
const confirmAddItem = async () => {
  if (!newItemName.value.trim()) {
    errorMessage.value = "El nombre no puede estar vacío.";
    return;
  }

  let newItem;

  if (currentSection.value === "actividades") {
    newItem = {
      nombre: newItemName.value,
      descripcion: newItemDescription.value || "",
      idioma: newItemIdioma.value || "",
      edad_min: newItemEdadMin.value || null,
      edad_max: newItemEdadMax.value || null,
      id_centro_civico: selectedCentroCivico.value,
      id_tipo_actividad: selectedTipoActividad.value,
      id_monitor: selectedMonitor.value,
      fecha: newItemFecha.value || "",
      hora_inicio: newItemHoraInicio.value || "",
      hora_fin: newItemHoraFin.value || "",
    };
  } else if (currentSection.value === "centro_civico") {
    newItem = {
      nombre: newItemName.value,
      ubicacion: newItemUbicacion.value || "",
      latitud: newItemLatitud.value || null,
      longitud: newItemLongitud.value || null,
      url: newItemUrl.value || "",
      telefono: newItemTelefono.value || "",
      correo: newItemCorreo.value || "",
    };
  } else if (currentSection.value === "tipos_actividades") {
    newItem = {
      nombre: newItemName.value,
      descripcion: newItemDescription.value || "",
      multimedia: newItemMultimedia.value || "", // URL o enlace del recurso multimedia
    };
  } else {
    errorMessage.value = "Sección no válida.";
    return;
  }

  console.log("Datos enviados con newItem:", newItem);

  try {
    await api.post(`/${currentSection.value}`, newItem);

    if (currentSection.value === "centro_civico") {
      fetchCentrosCivicos();
    } else if (currentSection.value === "actividades") {
      fetchActividades();
    } else if (currentSection.value === "tipos_actividades") {
      fetchTiposActividades(); // Agregamos la función para refrescar la lista
    }
  } catch (error) {
    errorMessage.value = error.message || "Error al añadir el nuevo ítem.";
  }
};


// Cargar datos al montar el componente
onMounted(() => {
  fetchCentrosCivicos();
  fetchActividades();
  fetchMonitores();
  fetchTiposActividades();
});
</script>

<template>
    <div class="container-fluid mt-4">
      <div class="row row-cols-1 row-cols-md-2 g-4">
        <!-- Centros Cívicos Section -->
        <div class="col">
          <div class="card custom-card h-100">
            <div class="card-header custom-card-header d-flex align-items-center">
              <h5 class="card-title mb-0 text-dark me-auto">Centros Cívicos</h5>
              <button @click="showAddItemPopup('centro_civico')" class="btn btn-sm btn-secondary bg-info w-25">
                <i class="bi bi-plus-lg"></i> Añadir
              </button>
            </div>
            <div class="card-body">
              <div v-if="centrosCivicosLoading" class="text-center">
                <div class="spinner-border text-secondary" role="status">
                  <span class="visually-hidden">Cargando...</span>
                </div>
              </div>
              <div v-else-if="centrosCivicosError" class="alert alert-danger">{{ centrosCivicosError }}</div>
              <ul v-else class="list-group list-group-flush">
                <li
                  v-for="centro in displayedCentrosCivicos"
                  :key="centro.id"
                  class="list-group-item d-flex justify-content-between align-items-center custom-list-item"
                >
                  <span class="text-dark">{{ centro.nombre }}</span>
                  <div>
                    <button @click="showModifyPopup(centro, 'centro_civico')" class="btn btn-sm btn-outline-secondary">
                      <i class="bi bi-pencil"></i>
                    </button>
                  </div>
                </li>
              </ul>
              <div v-if="centrosCivicos.length > 6" class="d-flex justify-content-center">
                <button
                  @click="toggleShowAllCentrosCivicos"
                  class="btn btn-link btn-sm mt-2 text-secondary custom-show-more-btn"
                >
                  {{ showAllCentrosCivicos ? 'Mostrar menos' : 'Mostrar más' }}
                </button>
              </div>
            </div>
          </div>
        </div>
  
        <!-- Actividades Section -->
        <div class="col">
          <div class="card custom-card h-100">
            <div class="card-header custom-card-header d-flex align-items-center">
              <h5 class="card-title mb-0 text-dark me-auto">Actividades</h5>
              <button @click="showAddItemPopup('actividades')" class="btn btn-sm btn-secondary bg-info w-25">
                <i class="bi bi-plus-lg"></i> Añadir
              </button>
            </div>
            <div class="card-body">
              <input
                v-model="searchQuery"
                type="text"
                class="form-control mb-3 custom-input"
                placeholder="Buscar actividad por nombre"
              />
              <div v-if="actividadesLoading" class="text-center">
                <div class="spinner-border text-secondary" role="status">
                  <span class="visually-hidden">Cargando...</span>
                </div>
              </div>
              <div v-else-if="actividadesError" class="alert alert-danger">{{ actividadesError }}</div>
              <ul v-else class="list-group list-group-flush">
                <li
                  v-for="actividad in displayedActividades"
                  :key="actividad.id"
                  class="list-group-item d-flex justify-content-between align-items-center custom-list-item"
                >
                  <span class="text-dark">{{ actividad.nombre }}</span>
                  <div>
                    <button @click="showModifyPopup(actividad, 'actividades')" class="btn btn-sm btn-outline-secondary">
                      <i class="bi bi-pencil"></i>
                    </button>
                  </div>
                </li>
              </ul>
              <div v-if="actividades.length > 6" class="d-flex justify-content-center">
                <button
                  @click="toggleShowAllActividades"
                  class="btn btn-link btn-sm mt-2 text-secondary custom-show-more-btn"
                >
                  {{ showAllActividades ? 'Mostrar menos' : 'Mostrar más' }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tipos de Actividades Section -->
      <div class="col my-2">
        <div class="card custom-card h-100">
          <div class="card-header custom-card-header d-flex align-items-center">
            <h5 class="card-title mb-0 text-dark me-auto">Tipos de Actividades</h5>
            <button @click="showAddItemPopup('tipos_actividades')" class="btn btn-sm btn-secondary bg-info w-25">
              <i class="bi bi-plus-lg"></i> Añadir
            </button>
          </div>
          <div class="card-body">
            <input
              v-model="searchQueryTipos"
              type="text"
              class="form-control mb-3 custom-input"
              placeholder="Buscar tipo de actividad por nombre"
            />
            <div v-if="tiposActividadesLoading" class="text-center">
              <div class="spinner-border text-secondary" role="status">
                <span class="visually-hidden">Cargando...</span>
              </div>
            </div>
            <div v-else-if="tiposActividadesError" class="alert alert-danger">{{ tiposActividadesError }}</div>
            <ul v-else class="list-group list-group-flush">
              <li
                v-for="tipo in tiposActividades"
                :key="tipo.id"
                class="list-group-item d-flex justify-content-between align-items-center custom-list-item"
              >
                <span class="text-dark">{{ tipo.nombre }}</span>
                <div>
                  <button @click="showModifyPopup(tipo, 'tipos_actividades')" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-pencil"></i>
                  </button>
                </div>
              </li>
            </ul>
            <div v-if="tiposActividades.length > 6" class="d-flex justify-content-center">
              <button
                @click="toggleShowAllTiposActividades"
                class="btn btn-link btn-sm mt-2 text-secondary custom-show-more-btn"
              >
                {{ showAllTiposActividades ? 'Mostrar menos' : 'Mostrar más' }}
              </button>
            </div>
          </div>
        </div>
      </div>

  
      <!-- Modify Modal -->
      <div
        class="modal fade"
        id="modifyModal"
        tabindex="-1"
        aria-labelledby="modifyModalLabel"
        aria-hidden="true"
        ref="modifyModal"
      >
        <div class="modal-dialog">
          <div class="modal-content custom-modal">
            <div class="modal-header custom-modal-header">
              <h5 class="modal-title text-dark" id="modifyModalLabel">
                Modificar {{ currentSection }}
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <!-- Para cualquier sección excepto 'actividades', 'centro_civico' y 'tipos_actividades' -->
              <input
                v-if="currentSection !== 'actividades' && currentSection !== 'centro_civico' && currentSection !== 'tipos_actividades' && modifyingItem"
                v-model="modifyingItem.nombre"
                class="form-control custom-input"
                placeholder="Nombre del ítem"
              />

              <!-- Modificar Actividades -->
              <template v-if="currentSection === 'actividades'">
                <input
                  v-if="modifyingItem"
                  v-model="modifyingItem.nombre"
                  class="form-control custom-input mb-3"
                  placeholder="Nombre de la actividad"
                />
                <textarea
                  v-model="modifyingItem.descripcion"
                  class="form-control custom-input mb-3"
                  placeholder="Descripción de la actividad"
                  rows="3"
                ></textarea>
                <input
                  v-model="modifyingItem.idioma"
                  class="form-control custom-input mb-3"
                  placeholder="Idioma"
                />
                <input
                  v-model="modifyingItem.edad_min"
                  type="number"
                  class="form-control custom-input mb-3"
                  placeholder="Edad mínima"
                />
                <input
                  v-model="modifyingItem.edad_max"
                  type="number"
                  class="form-control custom-input mb-3"
                  placeholder="Edad máxima"
                />
                <select v-model="selectedTipoActividad" class="form-select custom-input mb-3">
                  <option value="" disabled selected>Seleccionar Tipo de Actividad</option>
                  <option v-for="tipo in tiposActividades" :key="tipo.id" :value="tipo.id">
                    {{ tipo.nombre }}
                  </option>
                </select>
                <select v-model="selectedCentroCivico" class="form-select custom-input mb-3">
                  <option value="" disabled selected>Seleccionar Centro Cívico</option>
                  <option v-for="centro in centrosCivicos" :key="centro.id" :value="centro.id">
                    {{ centro.nombre }}
                  </option>
                </select>
                <select v-model="selectedMonitor" class="form-select custom-input mb-3">
                  <option value="" disabled selected>Seleccionar Monitor</option>
                  <option v-for="monitor in monitores" :key="monitor.id" :value="monitor.id">
                    {{ monitor.nombre }}
                  </option>
                </select>
              </template>

              <!-- Modificar Centro Cívico -->
              <template v-if="currentSection === 'centro_civico'">
                <input
                  v-if="modifyingItem"
                  v-model="modifyingItem.nombre"
                  class="form-control custom-input mb-3"
                  placeholder="Nombre del Centro Cívico"
                />
                <input
                  v-model="modifyingItem.ubicacion"
                  class="form-control custom-input mb-3"
                  placeholder="Ubicación"
                />
                <input
                  v-model="modifyingItem.latitud"
                  type="number"
                  step="any"
                  class="form-control custom-input mb-3"
                  placeholder="Latitud"
                />
                <input
                  v-model="modifyingItem.longitud"
                  type="number"
                  step="any"
                  class="form-control custom-input mb-3"
                  placeholder="Longitud"
                />
                <input
                  v-model="modifyingItem.url"
                  type="url"
                  class="form-control custom-input mb-3"
                  placeholder="URL"
                />
                <input
                  v-model="modifyingItem.telefono"
                  type="text"
                  class="form-control custom-input mb-3"
                  placeholder="Teléfono"
                />
                <input
                  v-model="modifyingItem.correo"
                  type="email"
                  class="form-control custom-input mb-3"
                  placeholder="Correo electrónico"
                />
              </template>

              <!-- Modificar Tipos de Actividades -->
              <template v-if="currentSection === 'tipos_actividades'">
                <input
                  v-if="modifyingItem"
                  v-model="modifyingItem.nombre"
                  class="form-control custom-input mb-3"
                  placeholder="Nombre del tipo de actividad"
                />
                <textarea
                  v-model="modifyingItem.descripcion"
                  class="form-control custom-input mb-3"
                  placeholder="Descripción del tipo de actividad"
                  rows="3"
                ></textarea>
                <input
                  v-model="modifyingItem.multimedia"
                  class="form-control custom-input mb-3"
                  placeholder="URL del archivo multimedia"
                />
              </template>

              <!-- Mostrar mensajes de error -->
              <div v-if="errorMessage" class="alert alert-danger mt-3">
                {{ errorMessage }}
              </div>
            </div>
            <div class="modal-footer custom-modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Cancelar
              </button>
              <button type="button" class="btn btn-primary" @click="saveModification">
                Guardar
              </button>
            </div>
          </div>
        </div>
      </div>



  
      <!-- Add Item Modal -->
      <div
        class="modal fade"
        id="addItemModal"
        tabindex="-1"
        aria-labelledby="addItemModalLabel"
        aria-hidden="true"
        ref="addItemModal"
      >
        <div class="modal-dialog">
          <div class="modal-content custom-modal">
            <div class="modal-header custom-modal-header">
              <h5 class="modal-title text-dark" id="addItemModalLabel">Añadir {{ currentSection }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <!-- Input general para el nombre del item -->
              <input
                v-model="newItemName"
                class="form-control custom-input mb-3"
                placeholder="Nombre del nuevo item"
                required
              />

              <!-- Inputs específicos para Centro Cívico -->
              <template v-if="currentSection === 'centro_civico'">
                <input
                  v-model="newItemUbicacion"
                  class="form-control custom-input mb-3"
                  placeholder="Ubicación"
                  required
                />
                <input
                  v-model="newItemLatitud"
                  type="number"
                  step="any"
                  class="form-control custom-input mb-3"
                  placeholder="Latitud"
                  required
                />
                <input
                  v-model="newItemLongitud"
                  type="number"
                  step="any"
                  class="form-control custom-input mb-3"
                  placeholder="Longitud"
                  required
                />
                <input
                  v-model="newItemUrl"
                  class="form-control custom-input mb-3"
                  placeholder="URL"
                />
                <input
                  v-model="newItemTelefono"
                  class="form-control custom-input mb-3"
                  placeholder="Teléfono"
                />
                <input
                  v-model="newItemCorreo"
                  type="email"
                  class="form-control custom-input mb-3"
                  placeholder="Correo Electrónico"
                />
              </template>

              <!-- Inputs para Actividades -->
              <template v-if="currentSection === 'actividades'">
                <textarea
                  v-model="newItemDescription"
                  class="form-control custom-input mb-3"
                  placeholder="Descripción de la actividad"
                  rows="3"
                ></textarea>
                <input
                  v-model="newItemIdioma"
                  class="form-control custom-input mb-3"
                  placeholder="Idioma"
                />
                <input
                  v-model="newItemEdadMin"
                  type="number"
                  class="form-control custom-input mb-3"
                  placeholder="Edad mínima"
                />
                <input
                  v-model="newItemEdadMax"
                  type="number"
                  class="form-control custom-input mb-3"
                  placeholder="Edad máxima"
                />
                <select
                  v-model="selectedTipoActividad"
                  class="form-select custom-input mb-3"
                >
                  <option value="" disabled selected>Seleccionar Tipo de Actividad</option>
                  <option
                    v-for="tipo in tiposActividades"
                    :key="tipo.id"
                    :value="tipo.id"
                  >
                    {{ tipo.nombre }}
                  </option>
                </select>
                <select
                  v-model="selectedCentroCivico"
                  class="form-select custom-input mb-3"
                >
                  <option value="" disabled selected>Seleccionar Centro Cívico</option>
                  <option
                    v-for="centro in centrosCivicos"
                    :key="centro.id"
                    :value="centro.id"
                  >
                    {{ centro.nombre }}
                  </option>
                </select>
                <select
                  v-model="selectedMonitor"
                  class="form-select custom-input mb-3"
                >
                  <option value="" disabled selected>Seleccionar Monitor</option>
                  <option
                    v-for="monitor in monitores"
                    :key="monitor.id"
                    :value="monitor.id"
                  >
                    {{ monitor.nombre }}
                  </option>
                </select>

                <!-- Nuevos campos de fecha, hora inicio y hora fin -->
                <input
                  v-model="newItemFecha"
                  type="date"
                  class="form-control custom-input mb-3"
                  placeholder="Fecha de la actividad"
                  required
                />
                <input
                  v-model="newItemHoraInicio"
                  type="time"
                  class="form-control custom-input mb-3"
                  placeholder="Hora de inicio"
                  required
                />
                <input
                  v-model="newItemHoraFin"
                  type="time"
                  class="form-control custom-input mb-3"
                  placeholder="Hora de fin"
                  required
                />
              </template>

              <!-- Inputs para Tipos de Actividades -->
              <template v-if="currentSection === 'tipos_actividades'">
                <textarea
                  v-model="newItemDescription"
                  class="form-control custom-input mb-3"
                  placeholder="Descripción del tipo de actividad"
                  rows="3"
                ></textarea>
                <input
                  v-model="newItemMultimedia"
                  class="form-control custom-input mb-3"
                  placeholder="URL del archivo multimedia"
                />
              </template>

              <div v-if="errorMessage" class="alert alert-danger mt-3">{{ errorMessage }}</div>
            </div>
            <div class="modal-footer custom-modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" @click="confirmAddItem">Añadir</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>