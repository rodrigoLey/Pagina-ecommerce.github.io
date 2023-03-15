<?php
//Creamos un archivo php para la conexion a mySQL
//Creamos una funcion llamada conectarDB

class Database{
    private $hostname="localhost";
    private $database="spartan";
    private $username="root";
    private $password="";
    

    function conectarDB()
    {
        try{
        //Creamos nuestra conexion al concatenar las variables
        $conexion = "mysql:host=" . $this->hostname . "; dbname=" . $this->database;
        $options = [ 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        $pdo = new PDO($conexion, $this->username, $this->password, $options);

        //Retorna nuestra conexion
        return $pdo;
    } catch(PDOException $e){
        echo 'Error conexion.......: ' . $e->getMessage();
        exit;
    }  
    }    
}
?>