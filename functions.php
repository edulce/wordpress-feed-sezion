<?php

// add this functions to the functions.php of your theme and customize them



//
// URL SHORTNER TO tinyurl.com
//
function get_tiny_url($url)  {  
	$ch = curl_init();  
	$timeout = 5;  
	curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
	$data = curl_exec($ch);  
	curl_close($ch);  
	return $data;  
}

//
// EXCERPT LIMPIO- SIN HTML O SIGNOS
// FUNCION UTILIZADA PARA LIMPIAR CUSTOM FIELDS
//
function get_excerpt($count){  
    $permalink = get_permalink($post->ID);
    $excerpt = get_the_content(); 
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $count);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    return $excerpt;
}

//
// FUNCION PARA INSERTAR CUSTOM FIELDS PERSONALIZADOS 
// EN EL FEED RSS DE WORDPRESS
//
function add_custom_fields_to_rss() {
	// 
	// TAG
	// post-image
	// imagen del producto
	//
    $post_image_meta_value = get_post_meta(get_the_ID(), 'post-image', true);
	if ($post_image_meta_value != '') {
        ?>
        <post-image><![CDATA[ <?php echo $post_image_meta_value ?> ]]></post-image>
        <?php  		
	}
	
	// 
	// TAG
	// durl
	// url de afiliado
	//	
	$durl_meta_value = get_post_meta(get_the_ID(), 'durl', true);
	if ($durl_meta_value != '') {	
        ?>
		<durl><![CDATA[ <?php echo $durl_meta_value ?> ]]></durl>
        <?php  
	}
	
	// 
	// TAG
	// precio
	//
	$schema_product_price_meta_value = get_post_meta(get_the_ID(), 'schema_product_price', true);
	if ($schema_product_price_meta_value != '') {	
        ?>
		<schema_product_price><![CDATA[ <?php echo $schema_product_price_meta_value ?> ]]></schema_product_price>
        <?php  
	}	
 	
	// 
	// TAG
	// excerpt
	// LIMITADA EN CARACTERES, con url sin acortar 130 funciona
	// LIMITADA EN CARACTERES, con url acortada 170 funciona-> creo que no. Son 188 en total - 64 URL CORTA = 124
	//
	?>
		<excerpt><![CDATA[ <?php echo ' '; ?> ]]><![CDATA[ <?php echo get_excerpt(130); ?> ]]></excerpt>
    <?php 
	
	// 
	// TAG
	// title
	// LIMITADA EN CARACTERES, con 58 funciona
	//
	?>
		<titulo><![CDATA[ <?php echo substr(the_title('', '', FALSE), 0, 60); ?> ]]></titulo>
    <?php 
	
	// 
	// TAG
	// shorturl
	// url acortada
	//
    $permalink = get_permalink();
	?>
		<shorturl><![CDATA[ <?php echo get_tiny_url($permalink)	; ?> ]]></shorturl>
    <?php 	
}
add_action('rss2_item', 'add_custom_fields_to_rss');


?>
