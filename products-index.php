<?php
require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectarDB();

$sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1");
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

//session_destroy();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Productos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" 
    crossorigin="anonymous">

</head>
<header>

  <div class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a href="index.php" class="navbar-brand">
        
        <strong>Spartan Training</strong>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
      data-bs-target="#navbarHeader" aria-controls="navbarHeader" 
      aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

        <div class="collapse navbar-collapse" id="navbarHeader">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="products-index.php" class="nav-link active">Productos</a>
                </li>
                <li class="nav-item">
                    <a href="contact.php" class="nav-link active">Contacto</a>
                </li>
            </ul>
            <a href="checkout.php" class="btn btn-primary">
                Carrito<span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
            </a>
</div>
  </div>
<link href="css/products-styles.css" type="text/css" rel="stylesheet">
</header>


<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" 
crossorigin="anonymous"></script>

<main>
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php foreach($result as $row){ ?>
            <div class="col">
                <div class="card shadow-sm">
                    <?php 
                    $id = $row['id'];
                    $imagen = "images/products/" . $id . "/principal.jpg";
                    
                    if(!file_exists($imagen)){
                        $imagen = "images/imagen-no-disponible.jpg";

                    }           
                    ?>
                    <img src="<?php echo $imagen?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                        <p class="card-text">$ <?php echo number_format($row['precio'], 2, '.', ','); ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="products-details.php?id=<?php echo $row['id']; ?>&token=<?php 
                                echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
                            </div>
                            <button class="btn btn-outline-success" type="button" onclick="addProducto(<?php echo $row['id']; ?>, '<?php 
                                echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>')">Agregar al carrito</button>
                        </div> 
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</main>
</body>
<script>
    //Creamos la se obtendra el id y el token de cada producto para que sea agregado al carrito
    function addProducto(id, token){
        let url = 'clases/cart.php'
        let formData = new FormData()
        formData.append('id', id)
        formData.append('token', token)

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        }).then(response => response.json()).then(data => {
            if(data.ok){
                let elemento = document.getElementById("num_cart")
                elemento.innerHTML = data.numero
            }
        })

    }
</script>
<style>

:root{
    --color1: #BDBDBD;
    --color2: #9E9E9E;
    --color3: #757575;
    --color4: #616161;
    --color5: #424242;
    --color6: #212121;

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
<?php include('html\footer.html');?>
</footer>
</html>