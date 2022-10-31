<?php 


#fonction d'envoi de mail
function sendMail($to,$subject,$message){

        $from = "Body Active Fitness <contact@ecf.blackshadowsphoto.com>";
        $bcc = "dianamaizcaceres@gmail.com";
        $headers  = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: " . $from . "\r\n";
        $headers .= "Bcc: ".$bcc. "\r\n";

        mail($to,$subject,$message,$headers);


}

?>