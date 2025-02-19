<script setup>
import { ref, computed, onMounted } from "vue";
import api from "@/plugins/axios";
import * as bootstrap from 'bootstrap';

// Estados reactivos
const centrosCivicos = ref([]);
const actividades = ref([]);
const monitores = ref([]);
const tiposActividades = ref([]);
const inscripciones = ref([]); // Nueva lista para las inscripciones

const centrosCivicosLoading = ref(false);
const actividadesLoading = ref(false);
const centrosCivicosError = ref(null);
const actividadesError = ref(null);
const errorMessage = ref(null);

const showAllCentrosCivicos = ref(false);
const showAllActividades = ref(false);
const searchQuery = ref("");
const searchQueryTipos = ref("");

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
const newItemIdioma = ref(""); // Ahora es string
const newItemEdadMin = ref("");
const newItemEdadMax = ref("");
const newItemFecha = ref("");
const newItemHoraInicio = ref("");
const newItemHoraFin = ref("");

const newItemUbicacion = ref("");
const newItemLatitud = ref("");
const newItemLongitud = ref("");
const newItemUrl = ref("");
const newItemTelefono = ref("");
const newItemCorreo = ref("");

const showAllTiposActividades = ref(false);
const tiposActividadesLoading = ref(false);
const tiposActividadesError = ref(null);

const showInscripcionesModal = ref(false);
const selectedActividadId = ref(null);
const inscripcionesLoading = ref(false);

// Referencias a modales
const modifyModal = ref(null);
const addItemModal = ref(null);

// Computed properties
const displayedTiposActividades = computed(() => {
    let filtered = tiposActividades.value;
    if (searchQueryTipos.value) {
        filtered = filtered.filter(tipo =>
            tipo.nombre.toLowerCase().includes(searchQueryTipos.value.toLowerCase())
        );
    }
    return showAllTiposActividades.value ? filtered : filtered.slice(0, 6);
});

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
    tiposActividadesLoading.value = true;
    try {
        const response = await api.get("/tipos_actividades");
        tiposActividades.value = response.data;
    } catch (error) {
        tiposActividadesError.value = error.message || "Error al cargar los Tipos de Actividades";
    } finally {
        tiposActividadesLoading.value = false;
    }
};

import { nextTick } from 'vue';

const fetchInscripciones = async (idActividad) => {
    inscripcionesLoading.value = true;
    selectedActividadId.value = idActividad;
    console.log(`Fetching inscripciones para actividad ID: ${idActividad}`);

    try {
        const response = await api.get(`/actividades/${idActividad}/usuarios`, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`
            }
        });

        console.log("Respuesta de la API:", response);
        console.log("Datos de inscripciones:", response.data);

        if (Array.isArray(response.data)) {
            inscripciones.value = response.data;
        } else {
            inscripciones.value = [];
            errorMessage.value = "No hay usuarios inscritos.";
            inscripciones.value = [];
        }

        showInscripcionesModal.value = true;

        // Inicializar el modal usando JavaScript
        const modalElement = document.getElementById('inscripcionesModal');
        const modal = new bootstrap.Modal(modalElement);
        modal.show();

        // Forzar la actualización de Vue después de asignar los datos
        await nextTick();

    } catch (error) {
        console.error("Error al cargar las inscripciones:", error);
        errorMessage.value = "Error al cargar las inscripciones.";
        inscripciones.value = [];

    } finally {
        inscripcionesLoading.value = false;
    }
};

const closeInscripcionesModal = () => {
    const modalElement = document.getElementById('inscripcionesModal');
    const modal = bootstrap.Modal.getInstance(modalElement);
    modal.hide();

    showInscripcionesModal.value = false;
    inscripciones.value = [];
    selectedActividadId.value = null;
    errorMessage.value = null;
};

// Mostrar modales
const showAddItemPopup = (section) => {
    currentSection.value = section;
    newItemName.value = "";
    newItemDescription.value = "";
    selectedTipoActividad.value = "";
    selectedCentroCivico.value = "";
    selectedMonitor.value = "";
    newItemIdioma.value = "";
    errorMessage.value = null;

    const modalElement = addItemModal.value;
    const modalInstance = new bootstrap.Modal(modalElement);
    modalInstance.show();
};

const showModifyPopup = (item, section) => {
    modifyingItem.value = { ...item }; // Deep copy para no modificar directamente el original
    currentSection.value = section;
    errorMessage.value = null;

     // Inicializar el modal usando JavaScript
     const modalElement = document.getElementById('modifyModal');
     const modal = new bootstrap.Modal(modalElement);
     modal.show();
};

// Alternar visibilidad de listas
const toggleShowAllCentrosCivicos = () => {
    showAllCentrosCivicos.value = !showAllCentrosCivicos.value;
};

const toggleShowAllActividades = () => {
    showAllActividades.value = !showAllActividades.value;
};

const toggleShowAllTiposActividades = () => {
    showAllTiposActividades.value = !showAllTiposActividades.value;
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

        if (currentSection.value === "centro_civico") {
            fetchCentrosCivicos();
        } else if (currentSection.value === "actividades") {
            fetchActividades();
        } else if (currentSection.value === "tipos_actividades") {
            fetchTiposActividades();
        }

        const modalElement = document.getElementById('modifyModal');
        const modal = bootstrap.Modal.getInstance(modalElement);
        modal.hide();

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
            idioma: newItemIdioma.value || null, //  ""
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
            multimedia: "src/assets/img/default.png",
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
            fetchTiposActividades();
        }
    } catch (error) {
        errorMessage.value = error.message || "Error al añadir el nuevo ítem.";
    } finally {
        const modalElement = addItemModal.value;
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
            modalInstance.hide();
        }
    }

    newItemName.value = "";
    newItemDescription.value = "";
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
                        <h2 class="card-title mb-0 text-white me-auto dirtyline-font">cenTros cívicOs</h2>
                        <button @click="showAddItemPopup('centro_civico')" class="cssbuttons-io2">
                            <span>Añadir</span>
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
                                <span class="text-white inter-font">{{ centro.nombre }}</span>
                                <div>
                                    <button @click="showModifyPopup(centro, 'centro_civico')"
                                            class="btn btn-sm btn-outline-secondary">
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
                        <h2 class="card-title mb-0 text-white me-auto dirtyline-font">actiVidades</h2>
                        <button @click="showAddItemPopup('actividades')" class="cssbuttons-io2">
                            <span>Añadir</span>
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
                                <span class="text-white inter-font">{{ actividad.nombre }}</span>
                                <div>
                                    <button @click="showModifyPopup(actividad, 'actividades')"
                                            class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <!-- Botón para mostrar las inscripciones -->
                                    <button @click="fetchInscripciones(actividad.id)" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-people"></i>
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
                    <h2 class="card-title mb-0 text-white me-auto dirtyline-font">tipoS de actividAdes</h2>
                    <button @click="showAddItemPopup('tipos_actividades')" class="cssbuttons-io2">
                        <span>Añadir</span>
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
                            v-for="tipo in displayedTiposActividades"
                            :key="tipo.id"
                            class="list-group-item d-flex justify-content-between align-items-center custom-list-item"
                        >
                            <span class="text-white inter-font">{{ tipo.nombre }}</span>
                            <div>
                                <button @click="showModifyPopup(tipo, 'tipos_actividades')"
                                        class="btn btn-sm btn-outline-secondary">
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

        <!-- Modal para mostrar las inscripciones -->
        <div
        class="modal fade"
        id="inscripcionesModal"
        tabindex="-1"
        aria-labelledby="inscripcionesModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content custom-modal">
                <div class="modal-header custom-modal-header">
                    <h5 class="modal-title text-white" id="inscripcionesModalLabel">
                        Inscripciones para la Actividad {{ selectedActividadId }}
                    </h5>
                    <button type="button" class="btn-close" @click="closeInscripcionesModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div v-if="inscripcionesLoading" class="text-center">
                        <div class="spinner-border text-secondary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                    <div v-else-if="errorMessage" class="alert alert-danger">
                        {{ errorMessage }}
                    </div>
                    <div v-else>
                        <ul class="list-group" v-if="inscripciones.length > 0">
                            <li v-for="inscripcion in inscripciones" :key="inscripcion.id"
                                class="list-group-item custom-list-item text-white">
                                {{ inscripcion.nombre }} (DNI: {{ inscripcion.dni }})
                            </li>
                        </ul>
                        <div v-else class="alert alert-warning">
                            No hay inscripciones para esta actividad.
                        </div>
                    </div>
                </div>
                <div class="modal-footer custom-modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeInscripcionesModal">Cerrar</button>
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
                        <h5 class="modal-title text-white" id="modifyModalLabel">
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
                            style="color: white;"
                        />

                        <!-- Modificar Actividades -->
                        <template v-if="currentSection === 'actividades'">
                            <input
                                v-if="modifyingItem"
                                v-model="modifyingItem.nombre"
                                class="form-control custom-input mb-3"
                                placeholder="Nombre de la actividad"
                                style="color: white;"
                            />
                            <textarea
                                v-model="modifyingItem.descripcion"
                                class="form-control custom-input mb-3"
                                placeholder="Descripción de la actividad"
                                rows="3"
                                style="color: white;"
                            ></textarea>
                              <!-- El select ahora usa newItemIdioma como modelo -->
                              <select
                                v-model="modifyingItem.idioma"
                                class="form-select custom-input mb-3"
                              >
                                <option value="" disabled>Seleccionar Idioma</option>
                                <option value="Euskera">Euskera</option>
                                <option value="Español">Español</option>
                              </select>
                            <input
                                v-model="modifyingItem.edad_min"
                                type="number"
                                class="form-control custom-input mb-3"
                                placeholder="Edad mínima"
                                style="color: white;"
                            />
                            <input
                                v-model="modifyingItem.edad_max"
                                type="number"
                                class="form-control custom-input mb-3"
                                placeholder="Edad máxima"
                                style="color: white;"
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
                                style="color: white;"
                            />
                            <input
                                v-model="modifyingItem.ubicacion"
                                class="form-control custom-input mb-3"
                                placeholder="Ubicación"
                                style="color: white;"
                            />
                            <input
                                v-model="modifyingItem.latitud"
                                type="number"
                                step="any"
                                class="form-control custom-input mb-3"
                                placeholder="Latitud"
                                style="color: white;"
                            />
                            <input
                                v-model="modifyingItem.longitud"
                                type="number"
                                step="any"
                                class="form-control custom-input mb-3"
                                placeholder="Longitud"
                                style="color: white;"
                            />
                            <input
                                v-model="modifyingItem.url"
                                type="url"
                                class="form-control custom-input mb-3"
                                placeholder="URL"
                                style="color: white;"
                            />
                            <input
                                v-model="modifyingItem.telefono"
                                type="text"
                                class="form-control custom-input mb-3"
                                placeholder="Teléfono"
                                style="color: white;"
                            />
                            <input
                                v-model="modifyingItem.correo"
                                type="email"
                                class="form-control custom-input mb-3"
                                placeholder="Correo electrónico"
                                style="color: white;"
                            />
                        </template>

                        <!-- Modificar Tipos de Actividades -->
                        <template v-if="currentSection === 'tipos_actividades'">
                            <input
                                v-if="modifyingItem"
                                v-model="modifyingItem.nombre"
                                class="form-control custom-input mb-3"
                                placeholder="Nombre del tipo de actividad"
                                style="color: white;"
                            />
                            <textarea
                                v-model="modifyingItem.descripcion"
                                class="form-control custom-input mb-3"
                                placeholder="Descripción del tipo de actividad"
                                rows="3"
                                style="color: white;"
                            ></textarea>
                            <input
                                v-model="modifyingItem.multimedia"
                                class="form-control custom-input mb-3"
                                placeholder="URL del archivo multimedia"
                                style="color: white;"
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
                        <h5 class="modal-title text-white" id="addItemModalLabel">Añadir {{ currentSection }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Input general para el nombre del item -->
                        <input
                            v-model="newItemName"
                            class="form-control custom-input mb-3"
                            placeholder="Nombre del nuevo item"
                            required
                            style="color: white;"
                        />

                        <!-- Inputs específicos para Centro Cívico -->
                        <template v-if="currentSection === 'centro_civico'">
                            <input
                                v-model="newItemUbicacion"
                                class="form-control custom-input mb-3"
                                placeholder="Ubicación"
                                required
                                style="color: white;"
                            />
                            <input
                                v-model="newItemLatitud"
                                type="number"
                                step="any"
                                class="form-control custom-input mb-3"
                                placeholder="Latitud"
                                required
                                style="color: white;"
                            />
                            <input
                                v-model="newItemLongitud"
                                type="number"
                                step="any"
                                class="form-control custom-input mb-3"
                                placeholder="Longitud"
                                required
                                style="color: white;"
                            />
                            <input
                                v-model="newItemUrl"
                                class="form-control custom-input mb-3"
                                placeholder="URL"
                                style="color: white;"
                            />
                            <input
                                v-model="newItemTelefono"
                                class="form-control custom-input mb-3"
                                placeholder="Teléfono"
                                style="color: white;"
                            />
                            <input
                                v-model="newItemCorreo"
                                type="email"
                                class="form-control custom-input mb-3"
                                placeholder="Correo Electrónico"
                                style="color: white;"
                            />
                        </template>

                        <!-- Inputs para Actividades -->
                        <template v-if="currentSection === 'actividades'">
                            <textarea
                                v-model="newItemDescription"
                                class="form-control custom-input mb-3"
                                placeholder="Descripción de la actividad"
                                rows="3"
                                style="color: white;"
                            ></textarea>
                             <!-- El select ahora usa newItemIdioma como modelo -->
                             <select
                                v-model="newItemIdioma"
                                class="form-select custom-input mb-3"
                              >
                                <option value="" disabled selected>Seleccionar Idioma</option>
                                <option value="Euskera">Euskera</option>
                                <option value="Español">Español</option>
                              </select>
                            <input
                                v-model="newItemEdadMin"
                                type="number"
                                class="form-control custom-input mb-3"
                                placeholder="Edad mínima"
                                style="color: white;"
                            />
                            <input
                                v-model="newItemEdadMax"
                                type="number"
                                class="form-control custom-input mb-3"
                                placeholder="Edad máxima"
                                style="color: white;"
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
                                style="color: white;"
                            />
                            <input
                                v-model="newItemHoraInicio"
                                type="time"
                                class="form-control custom-input mb-3"
                                placeholder="Hora de inicio"
                                required
                                style="color: white;"
                            />
                            <input
                                v-model="newItemHoraFin"
                                type="time"
                                class="form-control custom-input mb-3"
                                placeholder="Hora de fin"
                                required
                                style="color: white;"
                            />
                        </template>

                        <!-- Inputs para Tipos de Actividades -->
                        <template v-if="currentSection === 'tipos_actividades'">
                            <textarea
                                v-model="newItemDescription"
                                class="form-control custom-input mb-3"
                                placeholder="Descripción del tipo de actividad"
                                rows="3"
                                style="color: white;"
                            ></textarea>
                        </template>

                        <div v-if="errorMessage" class="alert alert-danger mt-3">
                            {{ errorMessage }}
                        </div>
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

<style scoped>
/* Import fonts */
@font-face {
    font-family: 'Dirtyline';
    src: url('../assets/fonts/Dirtyline.ttf') format('truetype');
}

.dirtyline-font {
    font-family: 'Dirtyline', sans-serif;
}

.inter-font {
    font-family: 'Inter', sans-serif;
    letter-spacing: -0.05em;
}

/* Base styles */
.container-fluid {
color: white;
}

.card {
background-color: black;
color: white;
}

.card-header {
background-color: #212529; /* Dark header color /
border-bottom: 1px solid #495057; / Dark border */
}

.card-title {
color: white;
}

.list-group-item {
background-color: black;
color: white;
border: none;
}

.list-group-item:hover {
background-color: #343a40; /* Slightly lighter on hover */
}

/* Buttons */
.btn-secondary {
color: #fff;
background-color: #6c757d;
border-color: #6c757d;
}

.btn-secondary:hover {
background-color: #5a6268;
border-color: #545b62;
}

/* Custom input styles */
.form-control {
background-color: #343a40;
border: 1px solid #495057;
color: white;
}

.form-control::placeholder { /* Add this /
color: white;
opacity: 0.7; / Optional: make the placeholder a bit more subtle */
}

.form-control:focus {
background-color: #343a40;
border-color: #80bdff;
color: white;
box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Custom modal styles */
.modal-content {
background-color: #212529;
color: white;
}

.modal-header {
background-color: #343a40;
border-bottom: 1px solid #495057;
}

.modal-title {
color: white;
}

.modal-footer {
border-top: 1px solid #495057;
}

.custom-show-more-btn {
color: #6c757d !important; /* Keep the show more button color */
}

/* Estilos para el modal de inscripciones */
#inscripcionesModal .modal-content {
background-color: #343a40;
color: white;
}

#inscripcionesModal .modal-header {
background-color: #495057;
border-bottom: 1px solid #6c757d;
}

#inscripcionesModal .modal-title {
color: white;
}

#inscripcionesModal .modal-footer {
border-top: 1px solid #6c757d;
}

.cssbuttons-io2 {
border-radius: 5px;
border: none;
background: linear-gradient(to right, #ffffffc8, #cbcbcb);
color: #252525;
overflow: hidden;
transition: all 0.4s;
position: relative;
z-index: 10;
display: inline-flex;
align-items: center;

}

.cssbuttons-io2 span {
font-weight: 500;
font-style: italic;
font-size: 1.3em;
letter-spacing: 0.03em;
font-family: Dirtyline;
padding: 5px 20px 0px 20px;
cursor: pointer;
}

.cssbuttons-io2::before {
content: "";
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
background-color: white;

z-index: -1;

transform: translateX(-100%);

transition: transform 0.4s cubic-bezier(0.3, 1, 0.8, 1);

}

.cssbuttons-io2:hover {
color: black;
/* Letras negras al hacer hover */
}

.cssbuttons-io2:hover::before {
transform: translateX(0);
/* Mostrar el degradado al hacer hover */
}

.cssbuttons-io2 span:active {
transform: scale(0.95);
}

</style>