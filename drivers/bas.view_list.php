<?php

 /** @I-blog 1.0
  *  archivo para ver listas de post especiales
  */

/////// variables necesarias /////////////

// assignamos la configuraci�n general
$Core->Set_Settings();
$Core->Set_Menu();
/////////////////////////////////////////

/////// inicio del c�digo de �ste controlador ////////

$Core->Set_Pub_for();

/////// carga del dise�o de �ste controlador /////////
// dibujamos el dise�o
$Core->rain->draw('index');