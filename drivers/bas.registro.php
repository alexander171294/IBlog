<?php

 /** @I-Blog 1.0
  *  archivo de home
  */

/////// variables necesarias /////////////

// assignamos la configuración general
$Core->Set_Settings();
$Core->Set_Menu();
$captcha = new Captcha('files/');
/////////////////////////////////////////

/////// inicio del código de éste controlador ////////

if(isset($_POST['posteado']))
 {
  $Core->registro($captcha);
 }

$captcha->set_value();
$captcha->create();

unset($captcha);

/////// carga del diseño de éste controlador /////////
// dibujamos el diseño
$Core->rain->draw('registro');