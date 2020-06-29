<?php
    $path = 'subseller/phone/';
    $pathLink = '/subseller/';
    require_once  $_SERVER['DOCUMENT_ROOT'].$pathLink."include/_setup.php";
    $set = new Setup();
    $login = $set->checkLogin();
    if(!$login){
        $set->RedirectToURL('../login');
        exit();
    }
    $name = $set->getClientName();
?>
<!DOCTYPE html>
<html>
<head>
    <script>
        if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            window.location.replace("../../client");
        }
     </script>  
    <?php
        require_once('header_meta.php');
    ?>
    <link rel="stylesheet" type="text/css" href="../css/CLIENT-shippings.css">
</head>
</head>
<body>
    <?php include('header.php');?>
    <div id="main">
        <?php include('sidebar.php');?>
        <div class="body">
            <h2>Direcciones</h2>
            <div id="ordersList">
                <?php
                    $shippings = $set->getShippingsFromClient();
                    if(!$shippings){
                        echo $set->getErrorMessage();
                    }
                    else{
                        echo '<ul class="list">';
                        foreach ($shippings as $key => $value) {
                            echo '<li>';
                            echo '<a href="shipping?id_shipping='.$value['id_shipping'].'"><div class="liBox">';
                            echo '<p class="id_pedido">Nombre: '.$value['name'].'</p>';
                            echo '<i class="fas fa-home"></i>';
                            echo '</div></a>';
                            echo '</li>';
                        }
                        echo '</ul>';
                        
                    }
                ?>
            </div>
        </div>
    </div>

    <?php include('footer.php');?>

</body>
</html>