<?php

 /** @I-Blog 1.0
  * archivo para ver una publicaci�n
  */


/////// variables necesarias /////////////

// assignamos la configuraci�n general
$Core->Set_Settings();
$Core->Set_Menu();
/////////////////////////////////////////

/////// inicio del c�digo de �ste controlador ////////

$Core->get_pub_fid();

/////// carga del dise�o de �ste controlador /////////
// dibujamos el dise�o
$Core->rain->draw('view');