// composables/useActividades.js
import { ref, readonly } from 'vue';
import axios from 'axios';

const API_URL = "http://localhost:8000/api";

export default function useActividades() {
  const actividades = ref([]);
  const loading = ref(false);
  const error = ref(null);
  const categoryId = ref(null); // Mantén categoryId aquí

  const setCategory = (id) => {
    categoryId.value = id;
  };

  const fetchActividades = async () => {
    loading.value = true;
    error.value = null;
    try {
      let url = `${API_URL}/actividades`; // Endpoint base
      if (categoryId.value) {
        url = `${API_URL}/actividad/${categoryId.value}`; // Endpoint con categoryId
      }
      const response = await axios.get(url);
      actividades.value = response.data;
    } catch (err) {
      error.value = err.response?.data?.message || err.message || "Error al obtener actividades";
    } finally {
      loading.value = false;
    }
  };

  return {
    actividades: readonly(actividades),
    loading: readonly(loading),
    error: readonly(error),
    categoryId: readonly(categoryId),
    setCategory,
    fetchActividades,
  };
}