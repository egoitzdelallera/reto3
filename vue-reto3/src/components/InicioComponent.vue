<template>
  <div class="container-fluid bg-black">
    <div class="row justify-content-center">
      <div class="col-10 col-sm-5">
        <div class="titulo w-100">eXplora y apúNtate en actividadEs</div>
      </div>
    </div>
    
    <div class="actividades">
      <div class="custom-cursor"></div>
      <div class="slider-container">
        <div class="slider"></div>
      </div>
      <div v-if="loading">Loading...</div>
      <div v-if="error">{{ error }}</div>
    </div>
  </div>
</template>

<script>
import { useRouter, useRoute } from 'vue-router';
import useCategorias from '../composables/useCategorias';
import useSlider from '../composables/useSlider';
import { ref, watch } from 'vue';

export default {
  setup() {
    const router = useRouter();
    const route = useRoute(); // Use the route object
    const { categorias, loading, error, fetchCategorias } = useCategorias();
    const { init: initSlideFunction } = useSlider();
    const selectedCategoria = ref('');

    const init = async () => {
      await fetchCategorias();
      initSlideFunction();
      // Call loadActivities based on route when component is first loaded
      loadActivities();
    };

    const loadActivities = async () => {
      // Get the route name from the URL (e.g., 'basket', 'boxeo')
      const routeName = route.name;
      if (routeName) {
        const categoria = categorias.value.find(cat => cat.nombre.toLowerCase() === routeName);

        if (categoria) {
            selectedCategoria.value = categoria.id;
            // Fetch activities based on the category, *replace with your actual data fetching logic*
            console.log(`Fetching activities for category: ${categoria.nombre}`);
            // await fetchActivities(categoria.id); // Example: Assuming a fetchActivities function in your composable
        } else {
            selectedCategoria.value = null;
            console.log("route not found, resetting selectedCategory");
        }
      }
    };

    const onCategoriaChange = () => {
      if (selectedCategoria.value) {
        const categoria = categorias.value.find(cat => cat.id === parseInt(selectedCategoria.value));
        if (categoria) {
          router.push({ name: categoria.nombre.toLowerCase(), params: { id: categoria.id } });
        }
      }
    };

    // Watch for route changes
    watch(
      () => route.name,
      (newRouteName) => {
        console.log(`Route changed to: ${newRouteName}`);
        loadActivities(); // Load activities when the route changes
      }
    );

    return {
      categorias,
      loading,
      error,
      selectedCategoria,
      onCategoriaChange,
      init
    };
  },
  mounted() {
    this.init();
  }
};
</script>

<style>
.titulo {
  text-align: center;
  font-size: 4em;
  font-family: Dirtyline;
  color: white;
  line-height: 1;
}

#actividades,
#edad,
#idioma,
#horario {
  background-color: transparent !important;
  color: white;
  border: 0px;
  padding: 10px;
}

#actividades option,
#edad option,
#idioma option,
#horario option {
  background-color: #000000;
  color: white;
  padding: 10px;
  border: none;
  cursor: pointer;
}

.slider-container {
  width: 100%;
  position: relative;
  overflow: hidden;
  padding-bottom: 3%;
  margin-top: 3%;
}

.slider {
  display: flex;
  position: relative;
}

option {
  background-color: #000000;
  color: white;
  border: none;
}

.slide {
  min-width: 400px;
  height: 450px;
  margin: 0 10px;
  position: relative;
  transform: scale(0.95);
  opacity: 0.5;
  transition: all 0.3s ease-in-out;
  border-radius: 10px;
  overflow: hidden;
  flex-shrink: 0;
  cursor: pointer;
}

.slide.active {
  transform: scale(1);
  opacity: 1;
  cursor: pointer;
}

.slide img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.slide .info {
  position: absolute;
  bottom: -55px;
  left: 10px;
  color: rgb(0, 0, 0);
  font-size: 4em;
  font-family: Inter;
  font-weight: 700;
  padding: 10px;
  letter-spacing: -0.05em;
  border-radius: .5px;
  width: 97%;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.slide .info a {
  color: white;
  text-decoration: none;
  margin-left: 30%;
  font-size: 1.5em;
  cursor: pointer;
  color: black;
  margin-bottom: .2em;
}

.custom-cursor {
  width: 50px;
  height: 50px;
  background: rgba(255, 255, 255, 0.2);
  border: 2px solid white;
  border-radius: 50%;
  position: fixed;
  pointer-events: none;
  display: flex;
  justify-content: center;
  align-items: center;
  color: white;
  font-size: 20px;
  opacity: 0;
  transition: opacity 0.3s ease, transform 0.1s ease;
  backdrop-filter: blur(4px);
  z-index: 1000;
}

.custom-cursor.left::before {
  content: "←";
}

.custom-cursor.right::before {
  content: "→";
}

.custom-cursor.active {
  transform: scale(1.5);
}

.no-cursor .custom-cursor {
  display: none;
}

.no-cursor .custom-cursor.left::before,
.no-cursor .custom-cursor.right::before {
  content: "";
}
@media (max-width: 768px) {
  .titulo {
    font-size: 2.5em;
  }

  .filtro {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .filtro select {
    width: 90%;
    margin-bottom: 0.5em;
  }

  .slider-container {
    width: 100%;
    overflow: visible; /* Permite que los slides se desborden verticalmente */
  }

  .slider {
    display: flex;
    flex-direction: column; /* Apila los slides verticalmente */
    align-items: center; /* Centra los slides horizontalmente */
    position: static; /* Elimina el posicionamiento absoluto/relativo para que se apilen */
    transform: none !important; /* Elimina cualquier transformación translateX */
  }

  .slide {
    min-width: 90%; /* Ocupa casi todo el ancho */
    height: auto; /* Altura automática para adaptarse al contenido */
    margin: 1em 1em; /* Margen vertical entre los slides */
    transform: none; /* Elimina la escala */
    opacity: 1; /* Asegura que todos los slides sean visibles */
  }

  /* Restringe a un máximo de 4 slides */
  .slider > *:nth-child(n+6) {
    display: none;
  }

  .slide.active {
    transform: none; /* Elimina la escala del slide activo */
  }

  .slide img {
    width: 100%; /* La imagen ocupa todo el ancho del slide */
    height: auto; /* Altura automática */
  }

  .custom-cursor {
    display: none; /* Oculta el cursor personalizado */
  }
}

</style>