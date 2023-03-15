<?php 
require 'header.php';
?>
<html>
<head>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" 
    crossorigin="anonymous">

</head>

<body>
    <div class="container">
          <!-- Creamos una clase para el rating de la pagina -->
  <!-- Creamos 5 botones de clase tipo star -->
<div class="star_rating">
      <p>Califique la pagina:</p>
      <button class = "star">&#9734;</button>
      <button class = "star">&#9734;</button>
      <button class = "star">&#9734;</button>
      <button class = "star">&#9734;</button>
      <button class = "star">&#9734;</button>
</div>
        <h1 class="text-danger text-center font-weight-bold my-4" >Contactame</h1>
        <form action="add_message.php" method="POST">
            <div class="form-group my-4">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" name='nombre' required>
            </div>
            <div class="form-group my-4">
                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" id="apellido" class="form-control" name='apellido' required>
            </div>
            <div class="form-group my-4">
                <label for="telefono">Telefono</label>
                <input type="tel" name="telefono" id="telefono" class="form-control" name='telefono' required>
            </div>
            <div class="form-group my-4">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" name='email' required>
            </div>
            <div class="form-group my-4 pb-5">
                <label for="mensaje">Mensaje</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name='mensaje' required></textarea>
            </div>
            <div class="form-group my-4">
        <button class="btn btn-success btn-lg btn-block" type="submit">Enviar</button>
        <button class="btn btn-danger btn-lg btn-block" type="reset">Eliminar</button>
    </div>
    
        </form>
    </div>
</body>
<style>

.star_rating{
    user-select:none;
  }
  .star{
    font-size: 2rem;
    color: #FF9800;
    background-color: unset;
    border: none;
  }
  .star:hover{
    cursor: pointer;
  }


</style>
<script>
  //Seleccionamos todos los elementos que tengan el nombre de esa clase(star)
  const allStars = document.querySelectorAll('.star')
  //Mediante un ciclo se obtiene la posicion del boton(estrella) que fue clickeado
allStars.forEach((star, i) => {
    star.onclick = function(){

        let current_star_level = i + 1;

        //Una vez obtenida la posicion del boton(estrella) clickeado
        //Se hace otro ciclo para rellenar los botones(estrella) que hay hasta el boton(estrella) clickeado
        allStars.forEach((star, j) => {
            if(current_star_level >= j+1){
                star.innerHTML = '&#9733';
            }else{
                star.innerHTML = '&#9734';
            }
        })
    }
})
  </script>
  <style>

:root{
    --color1: #BDBDBD;
    --color2: #9E9E9E;
    --color3: #757575;
    --color4: #E0E0E0;
    --color5: #EEEEEE;
    --color6: #FAFAFA;

}
@keyframes colors{
    0% { background-color: var(--color1); }
    20% { background-color: var(--color2); }
    40% { background-color: var(--color3); }
    60% { background-color: var(--color4); }
    80% { background-color: var(--color5); }
    100% { background-color: var(--color6); }
}
body{
   background-color: red;
   animation-name: colors;
   animation-duration: 5s;
   animation-timing-function: linear;
   animation-iteration-count: infinite;
   animation-direction: alternate;
}

</style>
<footer>
    <div class="footer">
    <?php include('html\footer.html');?>
</div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" 
crossorigin="anonymous"></script>
</html>

