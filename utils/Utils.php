<?php 
class Utils {
    function strNoEmptyOrNull($str){
        if($str != null && trim($str) != "") {
            return true;
        } else {
            return false;
        }

    }

    function isIdade($idade) {
        $str = preg_replace( '/[0-9]/', '', $idade);
    
        if (strlen($str) != 0) {
            return false;
        }
        return true;
    }

    function isSUS($sus_number){
        $padrao = '/^[0-9]{15}$/';
        if(preg_match($padrao, intval($sus_number))) {
            return true;
        } else {
            return false;
        }

    }

    function isCodigo($codigo){
        $padrao = '/^[0-9]{9}$/';
        if(preg_match($padrao, intval($codigo))) {
            return true;
        } else {
            return false;
        }

    }

    function isCPF($cpf) {
    
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/', '', $cpf );
        
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        /*if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }*/
        return true;

    }
}

?>