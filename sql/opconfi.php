<?php 
include_once "../sql/connection/conexion.php";
function modificarcorreo($correo, $text_header, $text_subheader,$color_fondo,$color_border,$color_header,$color_dato){
    $conn = conectar();
    if($correo !== "" && $text_header !== "" && $text_subheader !== "" && $color_fondo !== "" && $color_border !== ""&& $color_header !== ""&& $color_dato !== ""){
        $query = "UPDATE correos SET text_header = '".$text_header."', text_subheader = '".$text_subheader."',color_fondo = '".$color_fondo."',color_border = '".$color_border."',color_header = '".$color_header."',color_dato = '".$color_dato."'
        WHERE correo = '".$correo."'";
        mysqli_query($conn, $query);
        desconectar($conn);
        return "exito";
    }else {
        desconectar($conn);
        return "Por favor no deje espacios en blanco";
    }
}

?>
