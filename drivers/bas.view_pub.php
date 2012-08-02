<?php

 /** @I-Blog 1.0
  * archivo para ver una publicación
  */


/////// variables necesarias /////////////

// assignamos la configuración general
$Core->Set_Settings();
$Core->Set_Menu();
/////////////////////////////////////////

/////// inicio del código de éste controlador ////////

$Core->get_pub_fid();

/////// carga del diseño de éste controlador /////////
// dibujamos el diseño
$Core->rain->draw('view');