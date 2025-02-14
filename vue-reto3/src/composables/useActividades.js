import { ref, readonly } from "vue"
import axios from "axios"

const API_URL = "http://localhost:8000/api"
const categoryId = ref(null)

export default function useActividades() {
  const actividades = ref([])
  const loading = ref(false)
  const error = ref(null)

  const setCategory = (id) => {
    console.log("Setting category ID to:", id)
    categoryId.value = Number.parseInt(id, 10)
  }

  const fetchActividades = async () => {
    if (!categoryId.value) {
      console.log("No se ha establecido una categoría")
      return
    }

    console.log("Obteniendo actividades para la categoría:", categoryId.value)
    loading.value = true
    error.value = null
    try {
      const response = await axios.get(`${API_URL}/actividad/${categoryId.value}`)
      console.log("Actividades obtenidas:", response.data)
      actividades.value = response.data
    } catch (err) {
      console.error("Error al obtener actividades:", err)
      error.value = err.response?.data?.message || err.message || "Error al obtener actividades"
      actividades.value = [] // Asegúrate de limpiar las actividades en caso de error
    } finally {
      loading.value = false
    }
  }

  return {
    actividades: readonly(actividades),
    loading: readonly(loading),
    error: readonly(error),
    categoryId: readonly(categoryId),
    setCategory,
    fetchActividades,
  }
}

