<?php

 /** @I-blog 1.0
  *  archivo para ver listas de post especiales
  */

/////// variables necesarias /////////////

// assignamos la configuración general
$Core->Set_Settings();
$Core->Set_Menu();
/////////////////////////////////////////

/////// inicio del código de éste controlador ////////

$Core->Set_Pub_for();

/////// carga del diseño de éste controlador /////////
// dibujamos el diseño
$Core->rain->draw('index');