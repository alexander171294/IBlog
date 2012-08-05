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
 * cls.captcha.php
 *
 * Ésta clase se encarga de crear imagenes captcha para evitar ataques de flood.
 * es utilizada en el registro y en la publicación de comentarios.
 *
 * @author  Cody Roodaka <roodakazo@hotmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html
 * @link    https://github.com/alexander171294/IBlog
 */

class Captcha
 {
  // Archivo de la fuente
  protected $font = 'extras/verdana.ttf';
  // Nombre de la imagen creada
  protected $image = 'captcha.jpeg';
  // Directorio del captcha
  protected $folder = null;
  // Clave Captcha
  protected $value = null;
  // Ancho de la imagen
  protected $width = 0;
  // Alto de la imagen
  protected $height = 0;


  /**
   * Inicializamos la Clase
   * @param string $folder Directorio donde está ubicada la Imagen Captcha
   * @param int $width Ancho de la Imagen Captcha
   * @param int $height Alto de la Imagen Captcha
   * @author Cody Roodaka <roodakazo@hotmail.com>
   */
  public function __construct($folder, $width = 65, $height = 25)
   {
    $this->value = null;
    $this->folder = $folder;
    $this->width = $width;
    $this->height = $height;
   } // public function Captcha();



  /**
   * Generamos una clave Captcha
   * @author Cody Roodaka <roodakazo@hotmail.com>
   */
  public function set_value()
   {
    if($this->value == null || !isset($_SESSION['captcha']))
     {
      $letras = 'ABCDEFGHIJKLMNOPRSTUVWXYZ1234567890abcdefghkmnprstwxz';
      $i = 0;
      $code = '';
      while($i < 5)
       {
        ++$i;
        $code .= $letras[mt_rand(0,52)];
       }
      $this->value = $code;
      $_SESSION['captcha'] = $this->value;
     }
    return $this->value;
   } // public function setValue();



  /**
   * Obtenemos la ubicación de la Imagen Captcha
   * @author Cody Roodaka <roodakazo@hotmail.com>
   */
  public function get_patch()
   {
    return $this->folder.'/'.$this->image;
   } // public function getPatch();



  /**
   * Checkeamos si el captcha es correcto
   * @return boolean Resultado
   * @author Cody Roodaka <roodakazo@hotmail.com>
   */
  public function check($val)
   {
    if($this->value==$val || $_SESSION['captcha'] == $val && isset($_SESSION['captcha'])) { return true; }
    else
     {
      unset ($_SESSION['captcha']);
      return false;
     }
   } // public function check();



  /**
   * Creamos la Imagen Captcha
   * @author Cody Roodaka <roodakazo@hotmail.com>
   */
  public function create()
   {
    // Borrar el captcha anterior
    $patch = $this->get_patch();
    if(is_file($patch)) { unlink($patch); }
    // Creamos la imagen
    $imagen = imagecreate($this->width, 25);
    // Preparamos los colores
    $fondo_color = imagecolorallocate($imagen, 250, 250, 250);
    $texto_color = imagecolorallocate($imagen, 255, 128, 0);
    // Creamos y colocamos el texto en la imagen
    $textbox = imagettfbbox(13, 0, $this->font, $this->value);
    $x = (($this->width - $textbox[4]) / 2);
    $y = (($this->height - $textbox[5]) / 2);
    imagettftext($imagen, 13, 0, $x, $y, $texto_color, $this->font, $this->value);
    // Terminamos
    imagejpeg($imagen, $patch);
   } // public function create ();
 } // class Captcha();