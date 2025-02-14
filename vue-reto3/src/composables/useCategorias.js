// useCategorias.js
import { ref } from 'vue';
import axios from 'axios';

const API_URL = 'http://localhost:8000/api'; // Make sure this is correct

export default function useCategorias() {
  const categorias = ref([]);
  const loading = ref(false);
  const error = ref(null);

  const fetchCategorias = async () => {
    loading.value = true;
    error.value = null;
    try {
      const response = await axios.get(`${API_URL}/categorias`);
      categorias.value = response.data;
    } catch (err) {
      error.value = err.response?.data?.message || err.message || 'Failed to fetch categories';
      console.error('Error fetching categories:', err);
    } finally {
      loading.value = false;
    }
  };

  return {
    categorias,
    loading,
    error,
    fetchCategorias,
  };
}