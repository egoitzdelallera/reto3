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
      console.log('API Response:', response); // Log the entire response
      console.log('API Data:', response.data); // Log the data specifically

      if (Array.isArray(response.data)) {
        categorias.value = response.data;
      } else {
        console.warn('API did not return an array. Adjusting.');
        categorias.value = Array.isArray(response.data.data) ? response.data.data : [];  // Try response.data.data
      }
      console.log('Categorias after fetch:', categorias.value); // Log categories after fetch
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