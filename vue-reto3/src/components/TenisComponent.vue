<template>
  <div class="component">
    <div class="tennis-poster">
      <!-- Left Section: Title -->
      <div class="left-section">
        <h1 class="title">ACTIVIDADES <br>DE {{ categoriaNombre }}</h1>

      </div>

      <!-- Right Section: Activity Details -->
      <div class="right-section">
        <div class="scrollable-content">
          <div v-if="loading">Cargando actividades...</div>
          <div v-else-if="error">Error al cargar actividades: {{ error }}</div>
          <div v-else>
            <div v-for="actividad in actividades" :key="actividad.id" class="activity-box">
              <h2 class="activity-title">{{ actividad.nombre }}</h2>
              <p class="activity-description">{{ actividad.descripcion }}</p>
              <div class="datos">
                <div class="location">
                  Centro Cívico<br>
                  Ibaiondo
                </div>
                <div class="schedule">
                  Martes: 18:00 - 19:30<br>
                  Jueves: 18:00 - 19:30
                </div>
              </div>
              <div class="enroll">INSCRÍBETE!</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.component {
  min-width: 100vw;
  min-height: 100vh;
  background-image: url(../assets/img/fondoTenis.jpg);
  background-repeat: no-repeat;
  background-size: 100%;
}

/* General Styles */
.tennis-poster {
  display: flex;
  font-family: 'Playfair Display SC', serif;
  color: #f0f0f0;

  padding: 20px;

}

/* Left Section Styles */
.left-section {
  flex: 1;
  padding: 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: flex-start;
  position: sticky;
  top: 0;
  height: 100vh;
}

.title {
  font-size: 4.5em;
  margin: 0;
  font-weight: bold;
  line-height: 0.9;
}

.court-lines {
  position: relative;
  width: 250px;
  height: 250px;
  margin-left: 20px;
}

.vertical-line,
.horizontal-line {
  position: absolute;
  background-color: #33691e;
}

.vertical-line {
  width: 4px;
  height: 100%;
  left: 50%;
  transform: translateX(-50%);
}

.horizontal-line {
  height: 4px;
  width: 100%;
  top: 50%;
  transform: translateY(-50%);
}

.court-grid {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100px;
  height: 100px;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  grid-template-rows: repeat(2, 1fr);
  gap: 4px;
}

.court-grid>div {
  background-color: #33691e;
}

/* Right Section Styles */
.right-section {
  flex: 1;
  padding: 40px;
  display: flex;
  flex-direction: column;
  align-items: center;
  height: 100vh;
}

.scrollable-content {
  overflow-y: auto;
  width: 70%;
  padding: 0px;
  scrollbar-width: thin;
  /* Firefox */
  scrollbar-color: #f0f0f0 #313a0a;
  /* Firefox */
}

.scrollable-content::-webkit-scrollbar {
  width: 12px;
  /* Width of the entire scrollbar */
}

.scrollable-content::-webkit-scrollbar-track {
  background: #313a0a;
  /* Color of the tracking area */
}

.scrollable-content::-webkit-scrollbar-thumb {
  background-color: #f0f0f0;
  /* Color of the scroll thumb */
  width: 100px;
  border-radius: 4px;
  /* Roundness of the scroll thumb */
  border: 1px solid #313a0a;
  /* Creates padding around the scroll thumb */
}

.activity-box {
  position: relative;
  border: 4px solid #f0f0f0;
  padding: 30px;
  margin-bottom: 20px;
  max-width: 100%;
  margin-right: 2%;
  box-sizing: border-box;
  display: flex;
  border-radius: 20px;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  background-color: #313a0a;
}

.activity-title {
  font-size: 3.5em;
  font-family: 'Playfair Display SC', serif;
  white-space: pre-line;
  margin-bottom: 15px;
}

.activity-description {
  font-size: 1.2em;
  line-height: 1.5;
  margin-bottom: 20px;
}

.location {
  font-size: 1.2em;
  margin-bottom: 12px;
  white-space: pre-line;
}

.schedule {
  font-size: 1.2em;
  margin-bottom: 20px;
  white-space: pre-line;
}

.enroll {
  border: 4px solid #f0f0f0;
  padding: 8px 16px;
  border-radius: 8px;
  text-align: center;
  font-weight: bold;
  cursor: pointer;
  font-size: 1.1em;
  transition: background-color 0.3s, color 0.3s;
}

.enroll:hover {
  background-color: #f0f0f0;
  color: #33691e;
}

.datos {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
  width: 100%;
  border-top: 2px solid white;
  padding-top: 5%;
}
</style>

<script>
import { computed, watch, onMounted } from 'vue';
import useActividades from '../composables/useActividades';
import useCategorias from '../composables/useCategorias';

export default {
  setup() {
    const { actividades, loading, error, categoryId, setCategory, fetchActividades } = useActividades();
    const { categorias, fetchCategorias } = useCategorias();

    const categoriaNombre = computed(() => {
      const categoria = categorias.value.find(cat => cat.id === categoryId.value);
      return categoria ? categoria.nombre.toUpperCase() : 'ACTIVIDAD';
    });

    watch(categoryId, (newCategoryId) => {
      if (newCategoryId) {
        fetchActividades();
      }
    });

    onMounted(async () => {
      await fetchCategorias();
      // Aquí deberías obtener el ID de la categoría de alguna manera, por ejemplo:
      // const categoryIdFromRoute = route.params.id;
      // setCategory(categoryIdFromRoute);
      // Por ahora, vamos a usar un ID de ejemplo:
      setCategory(1);
      fetchActividades();
    });

    return {
      actividades,
      loading,
      error,
      categoriaNombre
    };
  }
};
</script>