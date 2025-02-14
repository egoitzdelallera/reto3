<template>
    <div class="container">
      <div class="row ancho">
        <div class="col-md-6 col-12 titulo">
          <h1 class="px-4">ACTIVIDADES DE</h1>
          <h1>BALONCESTO</h1>
        </div>
  
        <!-- Filters (Absolutely Positioned) -->
        <div class="filters">
          <div class="filtro rounded d-flex justify-content-around">
            <select id="actividades">
              <option value="actividades" select hidden>Categorias</option>
              <option value="deporte">Deporte</option>
              <option value="recreacion">Recreación</option>
              <option value="comida">Comida</option>
              <option value="otros">Otros</option>
            </select>
            <select id="edad">
              <option value="edad" select hidden>Edad</option>
              <option value="deporte">centro1</option>
              <option value="recreacion">centro2</option>
              <option value="comida">centro3</option>
              <option value="otros">otro4</option>
            </select>
            <select id="idioma">
              <option value="idioma" select hidden>Idioma</option>
              <option value="deporte">centro1</option>
              <option value="recreacion">centro2</option>
              <option value="comida">centro3</option>
              <option value="otros">otro4</option>
            </select>
            <select id="horario">
              <option value="horario" select hidden>Horario</option>
              <option value="deporte">centro1</option>
              <option value="recreacion">centro2</option>
              <option value="comida">centro3</option>
              <option value="otros">otros4</option>
            </select>
          </div>
        </div>
  
        <div class="col-md-6 mt-4 col-12 right-side-scrollable">
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
                <div class="col-md-4">
                  <p>Martes: 18:00 - 19:30</p>
                  <p>Jueves: 18:00 - 19:30</p>
                </div>
                <div class="col-md-4">
                  <p class="center">Centro Cívico</p>
                  <p class="center bold">Ibaiondo</p>
                </div>
                <div class="col-md-4">
                  <button class="cssbuttons-io">
                    <span>¡Inscríbete!</span></button>
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
                <div class="col-md-4">
                  <p>Lunes: 17:00 - 18:30</p>
                  <p>Miércoles: 17:00 - 18:30</p>
                </div>
                <div class="col-md-4">
                  <p class="center">Centro Cívico</p>
                  <p class="center bold">Hegoalde</p>
                </div>
                <div class="col-md-4">
                  <button class="cssbuttons-io">
                    <span>¡Inscríbete!</span></button>
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
                <div class="col-md-4">
                  <p>Lunes: 17:00 - 18:30</p>
                  <p>Miércoles: 17:00 - 18:30</p>
                </div>
                <div class="col-md-4">
                  <p class="center">Centro Cívico</p>
                  <p class="center bold">Otro Centro</p>
                </div>
                <div class="col-md-4">
                  <button class="cssbuttons-io">
                    <span>¡Inscríbete!</span></button>
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
                <div class="col-md-4">
                  <p>Lunes: 17:00 - 18:30</p>
                  <p>Miércoles: 17:00 - 18:30</p>
                </div>
                <div class="col-md-4">
                  <p class="center">Centro Cívico</p>
                  <p class="center bold">Otro Centro</p>
                </div>
                <div class="col-md-4">
                  <button class="cssbuttons-io">
                    <span>¡Inscríbete!</span></button>
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
                <div class="col-md-4">
                  <p>Lunes: 17:00 - 18:30</p>
                  <p>Miércoles: 17:00 - 18:30</p>
                </div>
                <div class="col-md-4">
                  <p class="center">Centro Cívico</p>
                  <p class="center bold">Otro Centro</p>
                </div>
                <div class="col-md-4">
                  <button class="cssbuttons-io">
                    <span>¡Inscríbete!</span></button>
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
                <div class="col-md-4">
                  <p>Lunes: 17:00 - 18:30</p>
                  <p>Miércoles: 17:00 - 18:30</p>
                </div>
                <div class="col-md-4">
                  <p class="center">Centro Cívico</p>
                  <p class="center bold">Ibaiondo 2</p>
                </div>
                <div class="col-md-4">
                  <button class="cssbuttons-io">
                    <span>¡Inscríbete!</span></button>
                  </div>
              </div>
            </div>
          </div>
          <div class="scroll-fade"></div>
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
  
.ancho{
    display: flex;
    flex-wrap: nowrap;
    justify-content: space-between;
    align-items: center;
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
  
  /* Right side: Scrollable Activity Blocks */
  .right-side-scrollable {
    overflow-y: auto;
    position: relative; /* Required for absolute positioning of fade */
    height: 100vh;
    padding: 20px 0;
    margin-top: 5% 5% 0% 0%;
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
  
  /* Estilos para el botón con la clase cssbuttons-io */
  .cssbuttons-io {
    border-radius: 55px;
    margin-bottom: -.2em;
    margin-left: .5em;
    border: none;
    background: linear-gradient(to right, #c1272d, #ff0015); /* Degradado */
    color: rgb(255, 255, 255); /* Letras negras por defecto */
    overflow: hidden;
    transition: all 0.4s; /* Transición para todas las propiedades */
    position: relative;
    z-index: 10;
    display: inline-flex;
    align-items: center;
  }

  .cssbuttons-io span {
    font-weight: 700;
    font-style: italic;
    font-size: 2.5em;
    font-family: Thunder;
    padding: 3px 24px 0px 20px;
    cursor: pointer;
  }

  .cssbuttons-io::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: white; /* Fondo blanco por defecto */
    z-index: -1; /* Poner el degradado detrás del texto */
    transform: translateX(-100%); /* Ocultar el degradado inicialmente */
    transition: transform 0.4s cubic-bezier(0.3, 1, 0.8, 1); /* Transición para la animación */
  }

  .cssbuttons-io:hover {
    color: black; /* Letras negras al hacer hover */
  }

  .cssbuttons-io:hover::before {
    transform: translateX(0); /* Mostrar el degradado al hacer hover */
  }

  .cssbuttons-io span:active {
    transform: scale(0.95);
  }





  .activity-block .schedule {
    position: absolute;
    bottom: 20px;
    left: 20px;
  }
  
  /* Scroll Fade Effect */
  .scroll-fade {
      z-index: 998;
      position: sticky;
      bottom: -21px; /* Adjusted to move the fade a bit lower */
      left: 0;
      width: 100%;
      height: 450px; /* Increased the height of the fade */
      background: linear-gradient(to bottom, rgba(193, 39, 45, 0), #c1272d); /* Gradient from transparent to #c1272d */
      pointer-events: none; /* Ensure the fade doesn't interfere with scrolling */
  }
  
  /* Filters (Absolutely Positioned) */
  .filters {
    position: absolute;
    top: 100px; /* Adjust as needed to position below the title */
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000; /* Ensure filters are above other content */
    width: 100%; /* Ancho completo */
    padding: 0 15px; /* Espacio a los lados */
    box-sizing: border-box; /* Asegura que padding no aumente el ancho */
  }
  
.filtro {
    background-color: black;
    color: white;
    margin: 0 auto; /* Centra horizontalmente */
    max-width: 500px; /* Ancho máximo del filtro */
}

.filtro select {
    background-color: transparent !important;
    color: white;
    border: 0px;
    padding: 10px;
    font-size: 1.5em;
    font-family: Thunder; /* Asegura que la tipografía se aplique a las opciones */
    font-weight: 500;
    font-style: italic;}

.filtro option {
    background-color: #000000;
    color: white;
    
}
  
  /* Responsive design (Optional) */
  @media (max-width: 768px) {
    .container {
      flex-direction: column;
    }
  
    .row {
      flex-direction: column;
    }
  
    .titulo,
    .right-side-scrollable {
      width: 100%;
      box-sizing: border-box; /* Asegura que padding y border se incluyan en el ancho total */
    }
  
    .col-md-4 {
      width: 100%;
      /* Ancho completo en pantallas pequeñas */
      box-sizing: border-box;
    }
  .filters {
          position: relative; /* Vuelve a la posición normal en pantallas pequeñas */
          top: auto;
          left: auto;
          transform: none;
          padding: 10px;
      }
  
      .filtro {
          max-width: 100%;
          margin: 0;
      }
  }
  </style>