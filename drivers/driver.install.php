<?php

/**
 * I-Blog
 *
 * PHP Version 5.3
 *
 * I-Blog es un proyecto Open Source desarrollado para ser r�pido, y sencillo.
 *
 * El repositorio oficial del proyecto lo puedes encontrar un poco m�s abajo,
 * iblog fu� dise�ado para blogs alojados en servidores peque�os
 * que no cuenten con tantos recursos para tener un blog pesado como son otros
 * sistemas de blog. .
 *
 * @author    Alexander Eberle Renzulli <alexander171294@live.com>
 * @copyright 2012 AlEb Corporation / (http://www.alebcorp.com.ar)
 * @license   http://www.gnu.org/copyleft/gpl.html
 * @link      https://github.com/alexander171294/IBlog
 */

/**
 * driver.install.php
 *
 * Este controlador se encarga de inicializar el instalador del sistema.
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

// si se hizo el post iniciamos la instalaci�n
if(isset($_POST['tit']))
 {
  # pasos de la instalaci�n aqu�
  // redirecci�n al inicio, blog ya instalado.
  header('Location: index.php');
 }

// configuramos la ruta del dise�o para instalaci�n
raintpl::configure('tpl_dir', 'themes/install/');

// configuramos la ruta de cach� para la instalaci�n
raintpl::configure('cache_dir', $Core->Settings['cache'].'/install/');

// dibujamos la plantilla index del instalador
$rain->draw('index');