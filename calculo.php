<?php
    include("funciones.php");
    $mascOctetos=[4]; $j=0;
    $ipOctetos=[4];
    $aux=0;
    $ip = $_POST['ip'];
    $masc = $_POST['mascara'];
    $n = $_POST['subRedes'];
    //Separando octetos de la mascara
    for($i=0; $i<strlen($masc); $i++){
        if($masc[$i]!='.'){
            $aux+=$masc[$i];
            $aux*=10;
        }
        if($masc[$i]=='.'){
            $mascOctetos[$j] = $aux/10;
            $j++;
            $aux=0;
        }
    }
    $mascOctetos[3]=$aux/10;
    $aux=0;
    $j=0;
    //Separando octetos de la IP
    for($i=0; $i<strlen($ip); $i++){
        if($ip[$i]!='.'){
            $aux+=$ip[$i];
            $aux*=10;
        }
        if($ip[$i]=='.'){
            $ipOctetos[$j] = $aux/10;
            $j++;
            $aux=0;
        }
    }
    $ipOctetos[3]=$aux/10;

    /*
    foreach($ipOctetos as $pp){
        echo $pp."<br>";
    } */

    //convirtiendo mi mascara a binario
    for($i=0; $i<4; $i++){
        $mascOctetos[$i]= decimalToBin($mascOctetos[$i]);
    }
    //cuantos bits activare
    $aux = bitsToActive($n);
    $bitsA = bitsActivos($mascOctetos[3]);
    
    //bits disponible
    $bitsDisponible = 8 - ($aux+$bitsA);
    
    //Activar bits
    if($bitsA==0){
        $mascOctetos[3]=1;    
        for($i=0; $i<=$aux; $i++){
            $mascOctetos[3]*=10;
            $mascOctetos[3]+=1;
        }
        $mascOctetos[3]= intval($mascOctetos[3] / 100);
        $mascOctetos[3] = $mascOctetos[3];
        for($i=0; $i<8-$aux; $i++){
            $mascOctetos[3]*=10;
        }
    }else{
        //quita los ceros
        while($mascOctetos[3]%10==0){
            $mascOctetos[3]= intval($mascOctetos[3] / 10);
        }
        for($i=$bitsA; $i<=($bitsA+$aux)+1; $i++){
            $mascOctetos[3]*=10;
            $mascOctetos[3]+=1;
        }
        $mascOctetos[3]= intval($mascOctetos[3] / 100);
        $mascOctetos[3] = $mascOctetos[3];
        for($i=0; $i<8-($aux+$bitsA); $i++){
            $mascOctetos[3]*=10;
        }
    }
    //Volviendo todo a decimal
    for($i=0; $i<4; $i++){
        $mascOctetos[$i] = binToDecimal($mascOctetos[$i]);
    }


    //Salto De red
    $saltoRed = 256 - $mascOctetos[3];
    //Host
    $host = pow(2,$bitsDisponible)-2;
    


    //echo "<br>activaods ".$mascOctetos[3]." activados"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Mascara Estatica</title>

</head>
<body>
    <div class="container bg-primary">
        <div class="row text-center">
            <div class="fs-1 text-light">
                RESULTADO
            </div>
        </div>
        <div class="row text-center justify-content-center pb-4 text-light">
            <div class="col-3 bg-secondary p-2">
                Direccion IP: <?php echo $ip; ?>
            </div>
            <div class="col-3 bg-secondary p-2">
                Nueva Mascara: 
                <?php 
                    foreach ($mascOctetos as $key => $value){
                        if($key==3)
                            echo $value;
                        else
                            echo $value.".";
                    }
                ?>
             </div>
            <div class="col-3 bg-secondary p-2">
                Numero de Sub Redes: <?php echo $n; ?>
            </div>
        </div>
    </div>

    <div class="container pt-3 ">

        <table class="table">
            <thead class="thead-dark table-primary">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">IP Sub Red</th>
                    <th scope="col">1ra IP Utilizable</th>
                    <th scope="col">Ultima IP Utilizable</th>
                    <th scope="col">BroadCast</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i=1;
                    while($i<=$n){
                        ?>
                    <tr 
                        <?php
                            if($i%2==0)
                                echo 'class="table-secondary"';
                        ?>
                    >
                        <th scope="row">
                            <?php
                                echo $i;
                            ?>  
                        </th>
                        <td>
                            <?php
                                foreach ($ipOctetos as $key => $value){
                                    if($key==3)
                                        echo $value;
                                    else
                                        echo $value.".";
                                }
                                $ipOctetos[3]+=1;//increment
                            ?>
                        </td>
                        <td>
                            <?php
                                foreach ($ipOctetos as $key => $value){
                                    if($key==3)
                                        echo $value;
                                    else
                                        echo $value.".";
                                }
                                $ipOctetos[3]+=($host-1);
                            ?>
                        </td>
                        <td>
                            <?php
                                foreach ($ipOctetos as $key => $value){
                                    if($key==3)
                                        echo $value;
                                    else
                                        echo $value.".";
                                }
                                $ipOctetos[3]+=1;
                            ?>
                        </td>
                        <td>
                            <?php
                                foreach ($ipOctetos as $key => $value){
                                    if($key==3)
                                        echo $value;
                                    else
                                        echo $value.".";
                                }
                                $ipOctetos[3]+=1;
                            ?>
                        </td>
                    </tr>
                    <?php
                        $i++;
                    }
                ?>
            </tbody>
        </table>
    
        <div class="row text-center">
            <a href="index.html">
                <button type="button" class="btn btn-success ">Volver</button>
            </a>

        </div>
    </div>

</body>
</html>