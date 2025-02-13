<template>
  <div class="container">
    <!-- Left side: Fixed Title -->
    <div class="left-side">
     
      <h1>ACTIVIDADES DE</h1>
      <h1>BALONCESTO</h1>
      
    </div>

    <!-- Right side: Scrollable Activity Blocks -->
    <div class="right-side-scrollable">
      <div class="right-side">
        <!-- Beginner Basketball -->
        <div class="activity-block">
          <h2>Baloncesto</h2>
          <h2 class="highlight">para principiantes</h2>
          <p>Ejercicio y diversión para adultos que quieren estar activos practicando basket en un ambiente relajado.</p>
          <p class="center">Centro Cívico</p>
          <p class="center bold">Ibaiondo</p>
          <button>¡Inscríbete!</button>
          <div class="schedule">
            <p>Martes: 18:00 - 19:30</p>
            <p>Jueves: 18:00 - 19:30</p>
          </div>
        </div>

        <!-- Advanced Basketball (Hegoalde) -->
        <div class="activity-block">
          <h2>Baloncesto</h2>
          <h2 class="highlight">nivel avanzado</h2>
          <p>Clases diseñadas para niños que quieren aprender las bases del baloncesto mientras se divierten.</p>
          <p class="center">Centro Cívico</p>
          <p class="center bold">Hegoalde</p>
          <button>¡Inscríbete!</button>
          <div class="schedule">
            <p>Lunes: 17:00 - 18:30</p>
            <p>Miércoles: 17:00 - 18:30</p>
          </div>
        </div>

        <!-- Advanced Basketball (Hegoalde) - Duplicated -->
        

        <!-- More activity blocks -->
        <div class="activity-block">
          <h2>Baloncesto</h2>
          <h2 class="highlight">Otro Nivel</h2>
          <p>Descripción de la actividad.</p>
          <p class="center">Centro Cívico</p>
          <p class="center bold">Otro Centro</p>
          <button>¡Inscríbete!</button>
          <div class="schedule">
            <p>Viernes: 16:00 - 17:30</p>
          </div>
        </div>
        <div class="activity-block">
          <h2>Baloncesto</h2>
          <h2 class="highlight">Otro Nivel</h2>
          <p>Descripción de la actividad.</p>
          <p class="center">Centro Cívico</p>
          <p class="center bold">Otro Centro</p>
          <button>¡Inscríbete!</button>
          <div class="schedule">
            <p>Viernes: 16:00 - 17:30</p>
          </div>
        </div>
        <div class="activity-block">
          <h2>Baloncesto</h2>
          <h2 class="highlight">Otro Nivel</h2>
          <p>Descripción de la actividad.</p>
          <p class="center">Centro Cívico</p>
          <p class="center bold">Otro Centro</p>
          <button>¡Inscríbete!</button>
          <div class="schedule">
            <p>Viernes: 16:00 - 17:30</p>
          </div>
        </div>
        <div class="activity-block">
          <h2>Baloncesto</h2>
          <h2 class="highlight">Principiantes 2</h2>
          <p>Más diversión para adultos.</p>
          <p class="center">Centro Cívico</p>
          <p class="center bold">Ibaiondo 2</p>
          <button>¡Inscríbete!</button>
          <div class="schedule">
            <p>Sábado: 10:00 - 11:30</p>
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
  background-image: url(../assets/img/fondoCompletoBasket.jpg);
  background-repeat: no-repeat;
  background-size: 67%;
}


/* Left side: Fixed Title */
.left-side {
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

.left-side h1 {
  font-size: 4em;
  margin: 0;
  font-weight: bold;
  line-height: 0.9;
}

.additional-blocks-top,
.additional-blocks-bottom {
  margin-top: 20px; /* Add space above/below the blocks */
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
  flex: 1;
  overflow-y: auto; /* Enable vertical scroll */
  height: 100vh; /* Fill the viewport height */
  padding: 20px 0; /* Add padding to the top and bottom */
  margin-right: 5%;
}

/* Scrollbar Styling */
.right-side-scrollable::-webkit-scrollbar {
  width: 12px; /* Width of the scrollbar */
}

.right-side-scrollable::-webkit-scrollbar-track {
  height: 80%;
  width: 8px;
}

.right-side-scrollable::-webkit-scrollbar-thumb {
  background: #000000; /* Color of the scroll thumb */
  border-radius: 8px; /* Rounded corners of the scroll thumb */
  width: 12px !important;
}

.right-side-scrollable::-webkit-scrollbar-thumb:hover {
  background: #555; /* Color of the scroll thumb on hover */
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
  border-radius: 5px;
  position: relative;
  overflow: hidden;
}

.activity-block.faded {
  opacity: 0.3;
  background-color: #d92027;
}

.activity-block h2 {
  margin: 0;
  font-size: 1.5em;
  font-weight: bold;
}

.activity-block h2.highlight {
  font-size: 2em;
}

.activity-block p {
  margin-bottom: 10px;
}

.activity-block .center {
  text-align: center;
}

.activity-block .bold {
  font-weight: bold;
}

.activity-block button {
  background-color: white;
  color: black;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  border-radius: 20px;
  font-weight: bold;
  position: absolute;
  bottom: 20px;
  right: 20px;
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