<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

<title><?php echo $presets["titulo"];?></title>

<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<meta name="author" content="<?php echo $presets["author"];?>" />
<meta name="description" content="<?php echo $presets["description"];?>" />
<meta name="keywords" content="<?php echo $presets["keyword"];?>" />
<meta name="robots" content="index, follow, all" />

<link rel="stylesheet" type="text/css" media="screen" href="/themes/default/css/screen.css" />

</head>

<body>

<!-- wrap starts here -->
<div id="wrap">

	<!--header -->
	<div id="header">			
				
		<h1 id="logo-text"><a href="/" title=""><?php echo $presets["titulo"];?></a></h1>
		<p id="slogan"><?php echo $presets["subtitulo"];?></p>
		
		<div  id="nav">
       <ul>
    <?php $counter1=-1; if( isset($menu_principal) && is_array($menu_principal) && sizeof($menu_principal) ) foreach( $menu_principal as $key1 => $value1 ){ $counter1++; ?>
				<li><a href="//<?php echo $value1["link"];?>"><?php echo $value1["nombre"];?></a></li>
      <?php } ?>
			</ul>
		</div>	
		
		<div id="header-image"></div>
				
	<!--header ends-->					
	</div>
	
	<!-- content -->
	<div id="content-outer" class="clear"><div id="content-wrap">
	
		<div id="content">
		
			<div id="left">			
			<?php $counter1=-1; if( isset($list) && is_array($list) && sizeof($list) ) foreach( $list as $key1 => $value1 ){ $counter1++; ?>
         <div class="post">
         <h2><a href="/index.php?action=view_pub&id=<?php echo $value1["pub_id"];?>"><?php echo $value1["pub_nombre"];?></a></h2>
         <p class="post-info">Posteado por: <a href="/index.php?action=view_list&foruser=<?php echo $value1["u_id"];?>"><?php echo $value1["u_nombre"];?></a> | Categor&iacute;a: <a href="/index.php?action=view_list&forcat=<?php echo $value1["cat_id"];?>"><?php echo $value1["cat_nombre"];?></a>  </p>
         <p><?php echo $value1["pub_preview"];?></p>
         <p class="postmeta">
					<a href="/index.php?action=view_pub&id=<?php echo $value1["pub_id"];?>" class="readmore">Leer M&aacute;s</a> |
					<a href="/index.php?action=view_pub&id=<?php echo $value1["pub_id"];?>" class="comments">Commentarios (<?php echo $value1["pub_comentario"];?>)</a> |
					<span class="date"><?php echo date('d/m/Y h:s',$value1["pub_fecha"]); ?></span>
					</p>
          </div>
      <?php } ?>

			</div>
		
			<div id="right">
							
				<div class="sidemenu">	
					<h3>Menu</h3>
					<ul>				
      <?php $counter1=-1; if( isset($menu_lateral) && is_array($menu_lateral) && sizeof($menu_lateral) ) foreach( $menu_lateral as $key1 => $value1 ){ $counter1++; ?>
				<li><a href="//<?php echo $value1["link"];?>"><?php echo $value1["nombre"];?></a></li>
      <?php } ?>
					</ul>	
				</div>
      <?php if( $menu_afiliados ){ ?>
				<div class="sidemenu">
					<h3>Afiliados</h3>
                    <ul>
      <?php $counter1=-1; if( isset($menu_afiliados) && is_array($menu_afiliados) && sizeof($menu_afiliados) ) foreach( $menu_afiliados as $key1 => $value1 ){ $counter1++; ?>
				<li><a href="//<?php echo $value1["link"];?>"><?php echo $value1["nombre"];?></a></li>
      <?php } ?>
					</ul>
				</div>
       <?php } ?>
				
				<h3>Search</h3>
			
				<form id="quick-search" action="index.php?action=search" method="post" >
					<p>
					<label for="qsearch">Search:</label>
					<input class="tbox" id="qsearch" type="text" name="texto" value="type and hit enter..." title="Start typing and hit ENTER" />
					<input class="btn" alt="Search" type="image" name="searchsubmit" title="Search" src="/themes/default/images/search.gif" />
					</p>
				</form>		
					
			</div>		
		
		</div>	
			
	<!-- content end -->	
	</div></div>
			
	<!-- footer starts here -->	
	<div id="footer-outer" class="clear"><div id="footer-wrap">
	
		<div class="col-a">
		
			<h3>Image Gallery </h3>					
				
			<p class="thumbs">
				<a href="/index.html"><img src="/themes/default/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>
				<a href="/index.html"><img src="/themes/default/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>
				<a href="/index.html"><img src="/themes/default/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>
				<a href="/index.html"><img src="/themes/default/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>
				<a href="/index.html"><img src="/themes/default/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>
				<a href="/index.html"><img src="/themes/default/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>	
				<a href="/index.html"><img src="/themes/default/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>
				<a href="/index.html"><img src="/themes/default/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>				
			</p>	
			
			<h3>Lorem ipsum dolor</h3>
			
			<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. 
			Cras id urna. Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu 
			posuere nunc justo tempus leo. Donec mattis, purus nec placerat bibendum, dui pede condimentum 
			odio, ac blandit ante orci ut diam. Cras fringilla magna.  
		   </p>				
				
		</div>
		
		<div class="col-a">
		
			<h3>Lorem Ipsum</h3>
			
			<p>
			<strong>Lorem ipsum dolor</strong> <br />
			Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. 
			Cras id urna. Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu 
			posuere nunc justo tempus leo. Donec mattis, purus nec placerat bibendum, dui pede condimentum 
			odio, ac blandit ante orci ut diam.</p>
				
			<div class="footer-list">
				<ul>				
					<li><a href="/index.html">consequat molestie</a></li>
					<li><a href="/index.html">sem justo</a></li>
					<li><a href="/index.html">semper</a></li>
					<li><a href="/index.html">magna sed purus</a></li>
					<li><a href="/index.html">tincidunt</a></li>		
					<li><a href="/index.html">consequat molestie</a></li>		
					<li><a href="/index.html">magna sed purus</a></li>					
				</ul>
			</div>
				
		</div>		
	
		<div class="col-b">
		<?php if( $presets["about"] ){ ?>
			<h3>Acerca de nosotros</h3>
			
			<p>
      <?php echo $presets["about"];?>
			</p>
		<?php } ?>
		</div>		
	
	<!-- footer ends -->		
	</div></div>
	
	<!-- footer-bottom starts -->		
	<div id="footer-bottom">
		<div class="bottom-left">
			<p>
			&copy; <?php echo date('Y'); ?> <strong><?php echo $presets["footer"];?></strong>&nbsp; &nbsp; &nbsp;
		   Design by <a href="http://www.styleshout.com/">styleshout</a> - Powered by I-blog <?php echo $version;?>
			</p>
		</div>
	
		<div class="bottom-right">
			<p>		
    <?php $counter1=-1; if( isset($menu_inferior) && is_array($menu_inferior) && sizeof($menu_inferior) ) foreach( $menu_inferior as $key1 => $value1 ){ $counter1++; ?>
				<a href="//<?php echo $value1["link"];?>"><?php echo $value1["nombre"];?></a> |
      <?php } ?>
			</p>
		</div>
	<!-- footer-bottom ends -->		
	</div>
	
<!-- wrap ends here -->
</div>

</body>
</html>
