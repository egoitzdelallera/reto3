<template>
    <div class="container">
      <main class="main-content">
        <div class="main-left">
          <h1 class="title">ACTIVIDADES</h1>
          <h2 class="subtitle">DE BOXEO</h2>
        </div>
        <div class="right-side-container">
          <div class="right-side-scrollable">
            <div class="activity-card">
              <h3 class="activity-title">BOXEO PARA PRINCIPIANTES</h3>
              <p class="activity-description">
                Ejercicio y diversión para adultos que quieren estar activos
                practicando basket en un ambiente relajado.
              </p>
              <div class="activity-location">
                Centro Cívico
                <span class="location-name">IBAIONDO</span>
              </div>
              <button class="register-button">INSCRÍBETE</button>
            </div>
            <div class="activity-card">
              <h3 class="activity-title">BOXEO PARA PRINCIPIANTES</h3>
              <p class="activity-description">
                Ejercicio y diversión para adultos que quieren estar activos
                practicando basket en un ambiente relajado.
              </p>
              <div class="activity-location">
                Centro Cívico
                <span class="location-name">IBAIONDO</span>
              </div>
              <button class="register-button">INSCRÍBETE</button>
            </div>
            <div class="activity-card">
              <h3 class="activity-title">BOXEO PARA PRINCIPIANTES</h3>
              <p class="activity-description">
                Ejercicio y diversión para adultos que quieren estar activos
                practicando basket en un ambiente relajado.
              </p>
              <div class="activity-location">
                Centro Cívico
                <span class="location-name">IBAIONDO</span>
              </div>
              <button class="register-button">INSCRÍBETE</button>
            </div>
            <div class="activity-card">
              <h3 class="activity-title">BOXEO PARA PRINCIPIANTES</h3>
              <p class="activity-description">
                Ejercicio y diversión para adultos que quieren estar activos
                practicando basket en un ambiente relajado.
              </p>
              <div class="activity-location">
                Centro Cívico
                <span class="location-name">IBAIONDO</span>
              </div>
              <button class="register-button">INSCRÍBETE</button>
            </div>
  
            <div class="activity-card">
              <h3 class="activity-title">BOXEO PARA PRINCIPIANTES</h3>
              <p class="activity-description">
                Ejercicio y diversión para adultos que quieren estar activos
                practicando basket en un ambiente relajado.
              </p>
              <div class="activity-location">
                Centro Cívico
                <span class="location-name">IBAIONDO</span>
              </div>
              <button class="register-button">INSCRÍBETE</button>
            </div>
  
            <div class="activity-card-placeholder">
              <h3 class="activity-title">BOXEO PARA PRINCIPIANTES</h3>
              <p class="activity-description">
                Ejercicio y diversión para adultos que quieren estar activos
                practicando basket en un ambiente relajado.
              </p>
              <div class="activity-location">
                Centro Cívico
                <span class="location-name">IBAIONDO</span>
              </div>
              <button class="register-button">INSCRÍBETE</button>
            </div>
          </div>
        </div>
      </main>
    </div>
  </template>
  
  <script>
  export default {
    name: "BoxingActivities",
  };
  </script>
  
  <style scoped>
  /* General styles */
  .container {
    background-color: black;
    color: white;
    font-family: sans-serif;
    height: 90vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    max-width: 100vw;
    background-image: url(../assets/img/fondoBoxeo.jpg);
  background-repeat: no-repeat;
  background-size: 108%;
  }
  
  /* Header styles */
 
  
  .logo {
    display: flex;
    align-items: center;
  }
  
  .logo img {
    width: 40px;
    margin-right: 10px;
  }
  
  .navigation {
    display: flex;
    align-items: center;
  }
  
  .nav-button,
  .login {
    background-color: transparent;
    color: white;
    border: 1px solid white;
    padding: 5px 15px;
    margin-left: 10px;
    cursor: pointer;
    border-radius: 5px;
  }
  
  .nav-button.active {
    background-color: white;
    color: black;
  }
  
  /* Main Content styles */
  .main-content {
    display: flex;
    height: calc(100% - 60px);
    padding: 0px 40px;
  }
  
  .main-left {
    width: 55%; /* Fixed width for the left side */
    flex-shrink: 0; /* Prevent shrinking */
    padding: 20px;
    position: sticky; /* Make it stick */
    top: 0;
    height: 100vh; /* Occupy full viewport height */
    display: flex;
    flex-direction: column;
    justify-content: center; /* Align items to the top */
    align-items: flex-start; /* Align items to the left */
    text-align: left;
    font-weight: 900;
    color: white;
    letter-spacing: 0.1em;
    font-size: 1.7em;
    font-style: italic;
  }
  
  .title {
    font-size: 5rem;
    font-weight: bold;
    color: #ffff00;
    margin-bottom: 5px;
    font-family: Arial, sans-serif;
  }
  
  .subtitle {
    font-size: 3rem;
    font-style: italic;
    color: #ffff00;
    margin-bottom: 20px;
    font-family: Arial, sans-serif;
  }
  
  /* Right side: Scrollable Activity Blocks */
  .right-side-container {
    width: 50%;
    height: 100vh; /* Set the height of the container */
    overflow: hidden;  /*  Prevent the container from overflowing */
    padding: 30px 20px;
  }
  
  .right-side-scrollable {
    width: 100%;
    height: 100%; /* Set the height of the scrollable area */
    overflow-y: auto;  /* Enable vertical scroll */
    scrollbar-width: thin; /*  thin  auto  none */
    scrollbar-color: #ffffff transparent;
    padding-right: 10px; /* Space for the scrollbar */
  }
  
  /* Scrollbar Styling */
  .right-side-scrollable::-webkit-scrollbar {
    width: 12px; /* Width of the scrollbar */
  }
  
  .right-side-scrollable::-webkit-scrollbar-track {
    background: transparent; /* Color of the track */
    border-radius: 10px; /* Rounded corners of the track */
  }
  
  .right-side-scrollable::-webkit-scrollbar-thumb {
    background: #ffffff; /* Color of the scroll thumb */
    border-radius: 10px; /* Rounded corners of the scroll thumb */
  }
  
  .right-side-scrollable::-webkit-scrollbar-thumb:hover {
    background: #555; /* Color of the scroll thumb on hover */
  }
  
  .activity-card {
    border: 1px solid white;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 10px;
    position: relative;
    z-index: 1;
  }
  
  .activity-card-placeholder {
    border: 1px solid white;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 10px;
    position: relative;
    z-index: 1;
  }
  
  .activity-title {
    font-size: 2rem;
    font-style: italic;
    color: #ffff00;
    margin-bottom: 10px;
    font-family: Arial, sans-serif;
  }
  
  .activity-description {
    font-size: 0.9rem;
    margin-bottom: 15px;
  }
  
  .activity-location {
    font-size: 0.8rem;
    margin-bottom: 15px;
  }
  
  .location-name {
    font-weight: bold;
    font-style: normal;
  }
  
  .register-button {
    background-color: #ffff00;
    color: black;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    font-weight: bold;
  }
  </style>