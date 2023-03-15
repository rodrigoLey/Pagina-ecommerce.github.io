<?php
require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectarDB();
//Obtenemos el id y token de los productos para luego proceder hacer un llamado a la base de datos y obtener los productos en la pagina web
$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if($id == '' || $token == ''){
    echo 'Error al procesar la peticion.';
    exit;
}else{
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);
    if($token == $token_tmp){

        $sql = $con->prepare("SELECT count(id) FROM productos WHERE id=? AND activo=1");
        $sql->execute([$id]);

        if($sql->fetchColumn() > 0){
            $sql = $con->prepare("SELECT nombre, descripcion, precio FROM productos WHERE id=? AND activo=1 
            LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $dir_images = 'images/products/' . $id . '/';
            $rutaImg = $dir_images . 'principal.jpg';

            
            //En caso de no importar imagenes de los productos, se mostrara una imagen predeterminada de que la imagen no esta disponible
            if(!file_exists($rutaImg)){
                $rutaImg = 'images/imagen-no-disponible.jpg';
            }

            $imagenes = array();
            if(file_exists($dir_images)){
            $dir = dir($dir_images);
            while (($archivo = $dir->read()) != false){
                if($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))){
                    $imagenes[] = $dir_images . $archivo;
                }
            }
            $dir->close();
        }
        }
    }else{
        echo 'Error al procesar la peticion.';
        exit;
    }
}

$sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1");
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
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
                    <a href="#" class="nav-link active">Contacto</a>
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

<main>
    <div class="container">
        <div class="row">
            <div class="col-md-6 order-md-1">

                <div id="carouselImages" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?php echo $rutaImg; ?>" class="d-block w-100">
                        </div>

                        <?php foreach ($imagenes as $img){ ?>
                            <div class="carousel-item">
                                <img src="<?php echo $img; ?>" class="d-block w-100">
                            </div>
                        <?php } ?>
    
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                
            </div>
            
            <div class="col-md-6 order-md-2">
                <h2><?php echo $nombre; ?></h2>
                <h2><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></h2>
                <p class="lead">
                <?php echo $descripcion; ?>
                </p>
                <div class="d-grid gap-3 col-10 mx-auto">
                    <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $id; ?>, '<?php echo $token_tmp; ?>')">Agregar al carrito</button>
                </div>

            </div>   
           
        </div>
    </div>
</main>
</body>
<script>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" 
crossorigin="anonymous"></script>
<footer>
<?php include('html\footer.html');?>
</footer>
</html>