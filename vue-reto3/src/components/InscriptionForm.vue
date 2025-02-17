<template>
  <div class="modal fade" id="inscriptionModal" tabindex="-1" aria-labelledby="inscriptionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog "> 
      <div class="modal-content bg-black text-white">
        <div class="modal-header">
          <h5 class="modal-title" id="inscriptionModalLabel">Inscripción a la actividad: {{ actividad ? actividad.nombre : '' }}
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Formulario de Inscripción -->
          <form @submit.prevent="submitInscription">
            <div class="row">
              <!-- Columna izquierda para los campos del formulario -->
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="nombre" class="form-label">Nombre*:</label>
                  <input type="text" class="form-control" id="nombre" v-model="inscriptionData.nombre" required>
                </div>
                <div class="mb-3">
                  <label for="apellido1" class="form-label">Apellido 1*:</label>
                  <input type="text" class="form-control" id="apellido1" v-model="inscriptionData.apellido1"
                    required>
                </div>
                <div class="mb-3">
                  <label for="apellido2" class="form-label">Apellido 2*:</label>
                  <input type="text" class="form-control" id="apellido2" v-model="inscriptionData.apellido2"
                    required>
                </div>
                <div class="mb-3">
                  <label for="dni" class="form-label">DNI / Pasaporte:</label>
                  <input type="text" class="form-control" id="dni" v-model="inscriptionData.dni">
                </div>
              </div>

              <!-- Columna derecha para los campos del formulario -->
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="sexo" class="form-label">Sexo*:</label>
                  <select class="form-select" id="sexo" v-model="inscriptionData.sexo" required>
                    <option value="">Seleccione su sexo</option>
                    <option value="hombre">Hombre</option>
                    <option value="mujer">Mujer</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="edad" class="form-label">Edad*:</label>
                  <input type="number" class="form-control" id="edad" v-model="inscriptionData.edad" required>
                </div>
                <div class="mb-3">
                  <label for="telefono" class="form-label">Teléfono principal*:</label>
                  <input type="tel" class="form-control" id="telefono" v-model="inscriptionData.telefono" required>
                </div>
                <div class="mb-3">
                  <label for="correo" class="form-label">Correo electrónico:</label>
                  <input type="email" class="form-control" id="correo" v-model="inscriptionData.correo">
                </div>
              </div>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary me-2">Confirmar Inscripción</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="emitClose">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';

export default {
  props: {
    actividad: {
      type: Object,
      required: false,
      default: null  // Default value if no actividad is passed
    }
  },
  emits: ['inscription-success', 'inscription-error', 'close'],  // Define los eventos que puede emitir el componente
  setup(props, { emit }) {
    const inscriptionData = ref({
      nombre: '',
      apellido1: '',
      apellido2: '',
      dni: '',
      sexo: '',
      edad: null,
      telefono: '',
      correo: ''
    });

    const submitInscription = async () => {
      try {
        // Verificar si actividad tiene un valor antes de acceder a sus propiedades
        if (!props.actividad || !props.actividad.id) {
          console.error('No se proporcionó una actividad válida');
          alert('Error: No se ha seleccionado una actividad válida.');
          return;
        }

        const data = {
          ...inscriptionData.value,
          id_actividad: props.actividad.id // Obtener el ID de la actividad de los props
        };
        const token = localStorage.getItem('access_token');

        //  ***CAMBIO IMPORTANTE: Reemplazar '/api/register' con el endpoint correcto para la inscripción***
        const response = await axios.post('http://localhost:8000/api/inscribir', data, { // Ajustar la ruta del backend
          headers: {
            'Authorization': `Bearer ${token}`
          }
        });

        console.log('Respuesta del backend:', response.data);
        alert(response.data.message);

        // Emite el evento 'inscription-success' para que el componente padre pueda reaccionar
        emit('inscription-success', response.data);
        emit('close'); // Emitir el evento 'close' después de una inscripción exitosa

        // Limpiar el formulario después de un registro exitoso
        inscriptionData.value = {
          nombre: '',
          apellido1: '',
          apellido2: '',
          dni: '',
          sexo: '',
          edad: null,
          telefono: '',
          correo: ''
        };

      } catch (error) {
        console.error('Error al inscribir:', error);
        if (error.response) {
          console.error('Datos del error:', error.response.data);
          alert('Error al inscribir: ' + error.response.data.message);
          emit('inscription-error', error.response.data);  // Emitir evento de error
        } else {
          alert('Error al inscribir. Verifica tu conexión o inténtalo más tarde.');
          emit('inscription-error', { message: 'Error de conexión' }); // Emitir evento de error
        }
      }
    };

    const emitClose = () => {
      emit('close');
    };

    return {
      inscriptionData,
      submitInscription,
      emitClose
    };
  }
};
</script>

<style scoped>
/* Puedes agregar estilos específicos para el formulario aquí si es necesario */
.form-label {
  color: white; /* Cambia el color de las etiquetas a blanco */
}
</style>