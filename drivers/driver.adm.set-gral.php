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
 * driver.adm.add-menu.php
 *
 * Controlador editar la configuración general, ésto abarca:
 *  - Titulo
 *  - Subtitulo
 *  - Footer
 *  - Pubsforpage
 *
 * @author  Alexander1712 <alexander171294@live.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

// seteamos los errores a nada
$rain->assign('error','');

// seteamos la configuración
$rain->assign('config_titulo',$Core->config_get('titulo'));
$rain->assign('config_subtitulo',$Core->config_get('subtitulo'));
$rain->assign('config_footer',$Core->config_get('footer'));
$rain->assign('config_pubsforpage',$Core->config_get('pubsforpage'));
$rain->assign('config_rss',$Core->config_get('rss'));
$rain->assign('config_twt',$Core->config_get('twt'));
$rain->assign('config_fb',$Core->config_get('fb'));
$rain->assign('config_design',$Core->config_get('design'));

// si se realizó el post del artículo editado
if($_SERVER['REQUEST_METHOD']=='POST')
 {
  // pasamos el arreglo a variables más fáciles de usar
  $title = $_POST['titulo'];
  $subtitulo = $_POST['subtitulo'];
  $footer = $_POST['footer'];
  $pubsforpage = (int) $_POST['pubsforpage'];
  $fb = $_POST['fb'];
  $twt = $_POST['twt'];
  $rss = $_POST['rss'];
  $design = $_POST['design'];

  // si el titulo es mayor a 3 caracteres
  if(!empty($title) && strlen($title) > 3)
   {
    // si hay un footer
    if (!empty($footer))
     {
      if($pubsforpage >= 1)
       {
        $Core->update_settings($title, $subtitulo, $footer, $pubsforpage, $fb, $twt, $rss, $design);
        header ('Location: /index.php');
       } else { $rain->assign('error','por lo menos debe mostrarse 1 publicaci&oacute;n por p&aacute;gina'); }
     } else { $rain->assign('error','debe haber un pi&eacute; de p&aacute;gina'); }
   } else { $rain->assign('error','debe haber un titulo mayor que 3 caracteres'); }
 }