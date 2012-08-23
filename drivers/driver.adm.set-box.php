<?php

/**
 * I-Blog
 *
 * PHP Version 5.3
 *
 * I-Blog es un proyecto Open Source desarrollado para ser rápido, y sencillo.
 *
 * El repositorio oficial del proyecto lo puedes encontrar un poco más abajo,
 * iblog fué diseñado para blogs alojados en servidores pequeños
 * que no cuenten con tantos recursos para tener un blog pesado como son otros
 * sistemas de blog. .
 *
 * @author    Alexander Eberle Renzulli <alexander171294@live.com>
 * @copyright 2012 AlEb Corporation / (http://www.alebcorp.com.ar)
 * @license   http://www.gnu.org/copyleft/gpl.html
 * @link      https://github.com/alexander171294/IBlog
 */

/**
 * driver.adm.set-box.php
 *
 * Éste controlador se gestionar los shoutbox...
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

// asignamos los valores de báse a 0
$rain->assign ('error',array(
                             'box1' => '',
                             'box2' => '',
                             'about' => '')
                            );

// instanciamos la clase ShoutBox
$shoutbox = new ShoutBox($db);

// obtenemos los valores de los shouts
$sh = $shoutbox->get();

// asignamos los valores de titulo de los shouts
$rain->assign ('sh1_titulo',$sh[1]['titulo']);
$rain->assign ('sh2_titulo',$sh[2]['titulo']);

// asignamos los valores de contenido de los shouts
$rain->assign ('sh1_content',$sh[1]['content']);
$rain->assign ('sh2_content',$sh[2]['content']);
$rain->assign ('about_content',$sh[3]['content']);

// si se realizó el post
if($_SERVER['REQUEST_METHOD']=='POST')
 {
  // guardamos las variables
  $titulo_sh1 = $_POST['sh1_titulo'];
  $titulo_sh2 = $_POST['sh2_titulo'];
  $content_sh1 = $_POST['sh1_content'];
  $content_sh2 = $_POST['sh2_content'];
  $content_about = $_POST['about_content'];
  // actualizamos los shouts
  $shoutbox->update($titulo_sh1, $titulo_sh2, $content_sh1, $content_sh2, $content_about);
  // redirigimos al inicio para que vea los cambios que realizó
  header('Location: /index.php');
  // finalizamos aquí el script para no levantar el diseño y perder recursos
  die();
 }