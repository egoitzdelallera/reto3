<template>
    <div class="container">
      <div class="row d-flex flex-nowrap align-items-center">
        <div class="col-md-6 titulo">
          <h1 class="px-4">ACTIVIDADES DE</h1>
          <h1>BALONCESTO</h1>
        </div>
        <div class="col-md-6 right-side-scrollable">
          <div class="right-side">
            <!-- Beginner Basketball -->
            <div class="activity-block">
              <div class="row">
                <div class="col-12">
                  <h2>Baloncesto para principiantes</h2>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <p>Ejercicio y diversión para adultos que quieren estar activos practicando basket en un ambiente relajado.</p>
                </div>
              </div>
              <div class="row mt-3 d-flex justify-content-center align-items-center">
                <div class="col-md-4 ">
                  <p>Martes: 18:00 - 19:30</p>
                  <p>Jueves: 18:00 - 19:30</p>
                </div>
                <div class="col-md-4">
                  <p class="center">Centro Cívico</p>
                  <p class="center bold">Ibaiondo</p>
                </div>
                <div class="col-md-4">
                  <button>¡Inscríbete!</button>
                </div>
              </div>
            </div>
  
            <!-- Advanced Basketball (Hegoalde) -->
            <div class="activity-block">
              <div class="row">
                <div class="col-12">
                  <h2>Baloncesto nivel avanzado</h2>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <p>Clases diseñadas para niños que quieren aprender las bases del baloncesto mientras se divierten.</p>
                </div>
              </div>
              <div class="row mt-3 d-flex justify-content-center align-items-center">
                <div class="col-md-4 ">
                  <p>Lunes: 17:00 - 18:30</p>
                  <p>Miércoles: 17:00 - 18:30</p>
                </div>
                <div class="col-md-4">
                  <p class="center">Centro Cívico</p>
                  <p class="center bold">Hegoalde</p>
                </div>
                <div class="col-md-4">
                  <button>¡Inscríbete!</button>
                </div>
              </div>
            </div>
  
            <!-- More activity blocks -->
            <div class="activity-block">
              <div class="row">
                <div class="col-12">
                  <h2>Baloncesto Otro Nivel</h2>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <p>Descripción de la actividad.</p>
                </div>
              </div>
              <div class="row mt-3 d-flex justify-content-center align-items-center">
                <div class="col-md-4 ">
                  <p>Viernes: 16:00 - 17:30</p>
                </div>
                <div class="col-md-4">
                  <p class="center">Centro Cívico</p>
                  <p class="center bold">Otro Centro</p>
                </div>
                <div class="col-md-4">
                  <button>¡Inscríbete!</button>
                </div>
              </div>
            </div>
            <div class="activity-block">
              <div class="row">
                <div class="col-12">
                  <h2>Baloncesto Otro Nivel</h2>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <p>Descripción de la actividad.</p>
                </div>
              </div>
              <div class="row mt-3 d-flex justify-content-center align-items-center">
                <div class="col-md-4 ">
                  <p>Viernes: 16:00 - 17:30</p>
                </div>
                <div class="col-md-4">
                  <p class="center">Centro Cívico</p>
                  <p class="center bold">Otro Centro</p>
                </div>
                <div class="col-md-4">
                  <button>¡Inscríbete!</button>
                </div>
              </div>
            </div>
            <div class="activity-block">
              <div class="row">
                <div class="col-12">
                  <h2>Baloncesto Otro Nivel</h2>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <p>Descripción de la actividad.</p>
                </div>
              </div>
              <div class="row mt-3 d-flex justify-content-center align-items-center">
                <div class="col-md-4 ">
                  <p>Viernes: 16:00 - 17:30</p>
                </div>
                <div class="col-md-4">
                  <p class="center">Centro Cívico</p>
                  <p class="center bold">Otro Centro</p>
                </div>
                <div class="col-md-4">
                  <button>¡Inscríbete!</button>
                </div>
              </div>
            </div>
            <div class="activity-block">
              <div class="row">
                <div class="col-12">
                  <h2>Baloncesto Principiantes 2</h2>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <p>Más diversión para adultos.</p>
                </div>
              </div>
              <div class="row mt-3 d-flex justify-content-center align-items-center">
                <div class="col-md-4 ">
                  <p>Sábado: 10:00 - 11:30</p>
                </div>
                <div class="col-md-4">
                  <p class="center">Centro Cívico</p>
                  <p class="center bold">Ibaiondo 2</p>
                </div>
                <div class="col-md-4">
                  <button>¡Inscríbete!</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <style scoped>
  /* Base styles */
  .container {
    display: flex;
    font-family: sans-serif;
    color: white;
    background-color: #c1272d;
    padding: 0;
    min-height: 100vh;
    max-width: 100vw;
    background-image: url(../assets/img/fondoCompletoBasket.png);
    background-repeat: no-repeat;
    background-size: 67%;
  }
  
  .titulo {
    margin-top: 1.9em;
    margin-left: 1.1em;
  }
  
  .titulo h1 {
    font-size: 1.8em;
    font-family: Thunder;
    text-align: left;
    margin: 0;
    font-weight: 800;
    font-style: italic;
    line-height: 0.9;
  }
  
  .additional-blocks-top,
  .additional-blocks-bottom {
    margin-top: 20px;
    /* Add space above/below the blocks */
    width: 100%;
  }
  
  .additional-block-left {
    background-color: black;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    text-align: center;
    width: 90%;
  }
  
  /* Right side: Scrollable Activity Blocks */
  .right-side-scrollable {
    overflow-y: auto;
    /* Enable vertical scroll */
    height: 100vh;
    /* Fill the viewport height */
    padding: 20px 0;
    /* Add padding to the top and bottom */
    margin-right: 5%;
  }
  
  /* Scrollbar Styling */
  .right-side-scrollable::-webkit-scrollbar {
    width: 12px;
    /* Width of the scrollbar */
  }
  
  .right-side-scrollable::-webkit-scrollbar-track {
    height: 80%;
    width: 8px;
  }
  
  .right-side-scrollable::-webkit-scrollbar-thumb {
    background: #000000;
    /* Color of the scroll thumb */
    border-radius: 8px;
    /* Rounded corners of the scroll thumb */
    width: 12px !important;
  }
  
  .right-side-scrollable::-webkit-scrollbar-thumb:hover {
    background: #555;
    /* Color of the scroll thumb on hover */
  }
  
  
  .right-side {
    display: flex;
    flex-direction: column;
    padding: 20px;
  
  }
  
  /* Activity block styles */
  .activity-block {
    background-color: black;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 25px;
    position: relative;
    overflow: hidden;
  }
  
  .activity-block.faded {
    opacity: 0.3;
    background-color: #d92027;
  }
  
  .activity-block h2 {
    margin: 0;
    font-size: 4em;
    font-family: Thunder;
    font-style: normal;
    font-weight: 700;
  }
  
  .activity-block p {
    margin-bottom: 0px;
    font-family: Inter;
    font-weight: 300;
    letter-spacing: -0.03em;

  }
  
  .activity-block .center {
    
    font-size: .85em;
    margin-top: -1.9em;
  }
  
  .activity-block .bold {
    font-weight: 700;
    font-style: normal;
    font-family: Thunder;
    margin-top: -.3em;
    font-size: 3em;
    padding-top: 0em;
    margin-bottom: -1em;
    letter-spacing: 0.00em;

  }
  
  .activity-block button {
    background-color: white;
    color: black;
    border: none;
    padding: 1px 24px 0px 20px;
    cursor: pointer;
    border-radius: 15px;
    margin-right: -5em;
    font-weight: 700;
    font-style: italic;
    font-size: 2.5em;
    font-family: Thunder;
    
  }
  
  .activity-block .schedule {
    position: absolute;
    bottom: 20px;
    left: 20px;
  }
  
  /* Red bars in the background (left side) */
  
  
  /* Responsive design (Optional) */
  @media (max-width: 768px) {
    .container {
      flex-direction: column;
    }
  
    .left-side {
      position: static;
      height: auto;
      width: 100%;
    }
  
    .right-side-scrollable {
      height: auto;
    }
  }
  
  
  
  
  /*esto es el scroll*/
  
  </style>