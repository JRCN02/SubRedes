<?php
    //bitsActivos
    function bitsActivos($oct){
        $bits=0;
        while($oct>0){
            if($oct%10==1)
                $bits++;
            $oct/=10;
        }
        return $bits;
    }
    //Decimal a Binario
    function decimalToBin($octe){
        //Dec a bin /dividir hasta que quede 0 o 1 e 
        //invertir el orden
		$bin2=0;
        $iter = 0;
        $bin=0;
		while($octe>=1) {
			$bin2+=$octe%2; //1 0 1 1 ...
            $bin2*=10;
			$octe/=2; //Reducir la mitad ...
            $iter++;
		}
        $bin2/=10; //quito un digito demas
        //echo "Binario revez: ".$bin2."</br>";
		//Solo falta invertir
		for($i=$iter; $i>=0; $i--) {
			$bin+= $bin2%10;
            $bin2/=10;
            $bin*=10;
        }
        $bin/=100;
		
        return $bin;
		
    }
    //Binario a decimal
    function binToDecimal($octe){
        $incremento=1;
        $decimal=0;
		while($octe>0) {
			if($octe%10==1)//sacara el ultimo digito
				$decimal+=$incremento;
			$incremento*=2;
			$octe/=10;
		}
        return $decimal;
		
    }
    //bITS a activar
    function  bitsToActive($nr){
        $n = 1;
        while(pow(2,$n)<=$nr){
            $n++;
        }
        return $n;
    }
?>