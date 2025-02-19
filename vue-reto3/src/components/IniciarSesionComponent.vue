<template>
    <div class="login-container">
      <div class="login-box">
        <h2>Iniciar Sesión</h2>
        <form @submit.prevent="handleLogin">
          <div class="input-group">
            <label for="correo">Correo Electrónico</label>
            <input type="email" id="correo" v-model="correo" required />
          </div>
          <div class="input-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" v-model="password" required />
          </div>
          <button type="submit" class="login-btn">Ingresar</button>
        </form>
      </div>
    </div>
  </template>
  
  <style>
  .login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #222;
  }
  
  .login-box {
    background-color: #333;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    text-align: center;
    width: 350px;
  }
  
  .login-box h2 {
    color: white;
    margin-bottom: 20px;
  }
  
  .input-group {
    display: flex;
    flex-direction: column;
    text-align: left;
    margin-bottom: 15px;
  }
  
  .input-group label {
    color: white;
    margin-bottom: 5px;
  }
  
  .input-group input {
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
  }
  
  .login-btn {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px;
    width: 100%;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
  }
  
  .login-btn:hover {
    background-color: #0056b3;
  }
  </style>
  
  <script>
    import axios from 'axios';
    import { decodificarToken } from '../utils/decodificarToken';

    export default {
        data() {
        return {
            correo: '',
            password: ''
        };
        },
        methods: {
            async handleLogin() {
        try {
            const API_URL = 'http://localhost:8000/api';  


            const response = await axios.post(`${API_URL}/login`, {
              correo: this.correo,
              password: this.password, // Debe coincidir con el campo de Laravel 'password'
            });

            const token = response.data.access_token;

            // Guardar el token JWT en el almacenamiento local
            localStorage.setItem('jwt_token', token);

            const userData = decodificarToken(token);

            if (userData) {
                console.log('Datos del usuario:', userData);

                const userToStore = {
                    id: userData.id, // Usando el id del payload
                    correo: userData.correo,  // Usando el correo del payload
                    tipo: userData.tipo, // Usando el rol del payload
                };

                // Guardar los datos del usuario
                localStorage.setItem('user_data', JSON.stringify(userToStore));
            } else {
                console.error('Error al decodificar los datos del usuario');
            }

            // Establecer el token en las cabeceras de axios para futuras solicitudes
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

            // Redirigir al usuario a la página de incidencias
            this.$router.push('/');
        } catch (error) {
            console.error('Error en el inicio de sesión:', error);
            alert('Correo o contraseña incorrectos');
        }
        },

        checkAuth() {
        const token = localStorage.getItem('jwt_token');
        if (token) {
            const userData = decodificarToken(token);
            if (userData) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            this.$router.push('/');
            } else {
            console.error('Token no válido');
            localStorage.removeItem('jwt_token');
            this.$router.push('/');
            }
        }
        }
    },
    created() {
        this.checkAuth();
    }
    };
  </script>
  