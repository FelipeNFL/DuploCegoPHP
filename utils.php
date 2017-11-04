<?php

class Utils {
    public static function formatCPF($cpf){
        $parte_um     = substr($cpf, 0, 3);
        $parte_dois   = substr($cpf, 3, 3);
        $parte_tres   = substr($cpf, 6, 3);
        $parte_quatro = substr($cpf, 9, 2);

        $monta_cpf = "$parte_um.$parte_dois.$parte_tres-$parte_quatro";

        return $monta_cpf;
    }

    public static function formatYear($years){
        if($years != 1)
            return $years." anos";
        else
            return $years." ano";
    }

    public static function formatCellphone($telefone){
        return substr($telefone,0,5)."-".substr($telefone,5,4);
    }
}

?>
