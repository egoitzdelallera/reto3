import { ref, onMounted } from 'vue';

const useActivityFilters = () => {
  // Local refs for filter selections
  const selectedCentroCivico = ref('');
  const selectedEdad = ref('');
  const selectedIdioma = ref('');
  const selectedHorario = ref('');

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


  const applyFilters = () => {
    // No need to do anything here. The components will react to the changes in selected filters.
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
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    userLatitude.value = position.coords.latitude;
                    userLongitude.value = position.coords.longitude;

                    // Guardar en localStorage
                    localStorage.setItem('userLatitude', userLatitude.value);
                    localStorage.setItem('userLongitude', userLongitude.value);

                    console.log(`Ubicación obtenida: Latitud ${userLatitude.value}, Longitud ${userLongitude.value}`);
                },
                (error) => {
                    console.error("Error obteniendo ubicación:", error);
                    // Check if the error is due to denied permission.
                    if (error.code === error.PERMISSION_DENIED) {
                        showLocationExplanation.value = true;
                    } else {
                        alert("No se pudo obtener la ubicación");
                        selectedCentroCivico.value = ''; // Resetear la selección
                    }
                }
            );
        } else {
            alert("Tu navegador no soporta geolocalización");
            selectedCentroCivico.value = ''; // Resetear la selección
        }
    };

    const closeExplanation = () => {
        showLocationExplanation.value = false;
        selectedCentroCivico.value = '';
    };


  const applyCachedFilters = (categoryId) => {
    const cachedFilters = getCachedFilters();
    if (cachedFilters) {
      selectedCentroCivico.value = cachedFilters.centroCivico || '';
      selectedEdad.value = cachedFilters.edad || '';
      selectedIdioma.value = cachedFilters.idioma || '';
      selectedHorario.value = cachedFilters.horario || '';
    } else {
      // Apply default filters if no filters are cached
      selectedCentroCivico.value = ''; // Changed to empty string
      selectedEdad.value = ''; // Changed to empty string
      selectedIdioma.value = ''; // Changed to empty string
      selectedHorario.value = ''; // Changed to empty string
    }
    console.log('Applied cached filters:', getCachedFilters());
  };

  const cacheFilters = () => {
    const filters = {
      centroCivico: selectedCentroCivico.value,
      edad: selectedEdad.value,
      idioma: selectedIdioma.value,
      horario: selectedHorario.value,
    };
    localStorage.setItem('globalFilters', JSON.stringify(filters)); //Use globalFilters to always use same filters across all pages
  };

  const getCachedFilters = () => {
    const cachedFilters = localStorage.getItem('globalFilters');
    return cachedFilters ? JSON.parse(cachedFilters) : null;
  };

  onMounted(() => {
    applyCachedFilters();  // Apply on mount, not just category-specific.
      //Try to get the location from localStorage on component mount
      const storedLat = localStorage.getItem('userLatitude');
      const storedLng = localStorage.getItem('userLongitude');

      if (storedLat && storedLng) {
        userLatitude.value = parseFloat(storedLat);
        userLongitude.value = parseFloat(storedLng);
      }
  });

  return {
    selectedCentroCivico,
    selectedEdad,
    selectedIdioma,
    selectedHorario,
    centrosCivicos,
    userLatitude,
    userLongitude,
    showLocationModal,
    showLocationExplanation,
    handleCentroCivicoChange,
    handleAllowLocation,
    handleDenyLocation,
    closeExplanation,
    getLocation,
    applyFilters,
    applyCachedFilters,
    cacheFilters,
    getCachedFilters
  };
};

export default useActivityFilters;