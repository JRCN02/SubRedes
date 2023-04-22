function validar(){
    var ip = document.getElementById("ip").value,
        mascara = document.getElementById("mascara").value,
        nredes = document.getElementById("numero").value;
    
    if(octetos(ip) && octetos(mascara) && cant(nredes)){
        document.mascaraEstatica.submit();
    }else{
        alert("Ingrese datos correctamente");
        document.getElementById("ip").value="";
        document.getElementById("mascara").value="";
        document.getElementById("numero").value="";
    }
}

function octetos(num){
    var p = 0;
    var is = true;
    for(var i=0; i<num.length; i++){
        if(num[i]=='.')
            p++;
        if(num[i]=='-')
            is=false;
    }
    
    //separador 
    if(p==3 && is){
        var aux="";
        for(var i=0; i<num.length; i++){
            if(num[i]!='.')
                aux += num[i];
            if(num[i]=='.'){
                if(parseInt(aux)<0 || parseInt(aux)>255)
                    return false;
                aux="";
            }
        }
        return true;
    } 
    return false; 
}

function cant(num){
    if(num>0)
        return true;
    return false;
}