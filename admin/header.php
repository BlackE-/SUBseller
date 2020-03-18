    <div class="container headerAdmin">
        <div class="row header">
            <div class="two columns">
                <!-- <a href="index.php">    <img class="u-full-width" src="../img/header/kualogo.png">   </a> -->
            </div>
            
            <div class="eight columns">
                <?php
                    // switch($tipo_usuario){
                    //     case 1:
                    //         echo '<p>Hola Admin</p>';
                    //     break;
                    //     case 2:
                    //         //revisar el grupo al que pertenece y colocar imagen
                    //         echo '<p>'.$site->getNameUsuario().'</p>';
                    //     break;
                    // }
                ?>
            </div>
            
            <div class="two columns">
                <a href="logout.php">    <button class="logout u-full-width">Cerrar Sesión</button>   </a>
            </div>
        </div>
    </div>
    <div class="container menuAdmin">
        <div class="row">
            <div class="two columns"><a href="pedidos.php"><button>PEDIDOS</button></a></div>
            <div class="two columns"><a href="productos.php"><button>PRODUCTOS</button></a></div>
            <div class="two columns"><a href="productoAlta.php"><button>ALTA PRODUCTO</button></a></div>
            <div class="two columns"><a href="paqueteAlta.php"><button>ALTA PAQUETE</button></a></div>
            <div class="two columns"><a href="descuentos.php"><button>DESCUENTOS</button></a></div>
            <div class="two columns"><a href="clientes.php"><button>CLIENTES</button></a></div>
        </div>
    </div>
<?php
// switch($tipo_usuario){
//     case 1:
//     echo '<div class="container menuAdmin2">';
//     echo    '<div class="row">';
//     echo        '<div class="two columns"><a href="grupos.php"><button>GRUPOS</button></a></div>';
//     echo        '<div class="two columns"><a href="marcas.php"><button>MARCAS</button></a></div>';
//     echo        '<div class="two columns"><a href="categorias.php"><button>CATEGORIAS</button></a></div>';
//     echo        '<div class="two columns"><a href="tipos_producto.php"><button>TIPO PRODUCTO</button></a></div>';
//     echo        '<div class="two columns"><a href="carouseles.php"><button>CAROUSEL</button></a></div>';
//     echo        '<div class="two columns"><a href="inventario.php"><button>INVENTARIO</button></a></div>';
//     echo    '</div>';
//     echo    '<div class="row">';
//     echo        '<div class="two columns"><a href="usuarios.php"><button>USUARIOS</button></a></div>';
//     echo        '<div class="two columns"><a href="contenido_dinamico.php"><button>CONTENIDO DINAMICO</button></a></div>';
//     echo    '</div>';
//     echo '</div>';
        
//     break;
// }
?>