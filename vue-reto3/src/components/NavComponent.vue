<template>
    <nav>
      <div class="nav">
        <div class="logo">
          <img src="../assets/img/logoAyuntmaiento.png" alt="Logo" />
        </div>
        <div class="categorias">
          <div class="cat_borde">
            <a href="">
            Categorias
          </a>
          </div>
        </div>
        <div class="inicio_sesion">
          <a href="#" class="btn_login">Iniciar sesión</a>
        </div>
      </div>
    </nav>
  </template>
  
  <style>
  nav{
    background-color: #000000;
    padding: 10px 0;
    width: 100vw;
   
  }
  .nav{
    display: flex;
    justify-content: space-between;
  }
  .logo img{
    height: 70px;
    width: auto;
  }
  .logo{
    width: 10%;
    margin-left: 2%;
  }
  .inicio_sesion{
    width: 10%;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .inicio_sesion a{
    color: white;
  }
  .categorias{
    width: 20%;
    display: flex;
    justify-content: center;
    align-items: center;
    transition:ease-in-out 0.2s;
    text-decoration: none;

  }
  
  .cat_borde:hover{
    padding: 4px 8px 4px 8px;
    border: .1px solid black;
    position:absolute;
  }
  .cat_borde{
    border: 2px solid white;
    padding: 2px 2px 2px 2px;
    border-radius: 10px;
    transition: ease-in-out 0.2s;

  }
  .categorias a{
    color: rgb(0, 0, 0);
    background-color: aliceblue;
    padding: 3px 15px 3px 15px;
    border-radius: 6px;
  }
</style>