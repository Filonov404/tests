<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <?php do_action('masterstudy_head_start'); ?>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head(); ?>
    <?php do_action('masterstudy_head_end'); ?>
</head>
<body <?php body_class(); ?> ontouchstart="">
	<?php if(!$_COOKIE['yes_lang'] == 'EN') { ?>
	<section id="select_lang" style="background: #c6ae81; color: rgb(255, 255, 255); font-size: 13px; padding: 10px;" class="attention-weekend">
                    <div class="container" style="position:relative;">
						<div class="row">
						<div class="col-lg-3 col-xs-12" style="padding-bottom: 5px;"><i class="fa fa-exclamation-circle" aria-hidden="true" style="font-size: 18px;position: relative;bottom: -1px;margin-right: 5px;"></i>
                        Ваш язык Русский?   </div>
						
						<div class="col-lg-5 col-xs-12" style="padding-bottom: 5px;"><span id="yes_lang" style="border: 1px solid rgba(255,255,255,1.00); padding: 3px 7px; cursor: pointer; margin-left: 15px; margin-bottom: 5px;">Да</span><a href="https://en.omaslennikova.com" id="no_lang" style="border: 1px solid rgba(255,255,255,1.00); padding: 3px 7px; margin-bottom: 5px; cursor: pointer; color: rgba(255,255,255,1.00); margin-left: 15px;">No, English</a><a href="https://pt.omaslennikova.com" id="no_lang" style="border: 1px solid rgba(255,255,255,1.00); margin-bottom: 5px; padding: 3px 7px; cursor: pointer; color: rgba(255,255,255,1.00); margin-left: 15px;">Não, português</a></div>
						
						</div>
                         
						
						
						
                    </div>
                </section> <?php } ?>
<?php wp_body_open(); ?>

<?php do_action('masterstudy_body_start'); ?>

<div id="wrapper">

    <?php do_action('masterstudy_before_header'); ?>

    <?php get_template_part('partials/headers/main'); ?>
    <script>
      function set_cookie ( name, value, exp_y, exp_m, exp_d, path, domain, secure )
{
  var cookie_string = name + "=" + escape ( value );
 
  if ( exp_y )
  {
    var expires = new Date ( exp_y, exp_m, exp_d );
    cookie_string += "; expires=" + expires.toGMTString();
  }
 
  if ( path )
        cookie_string += "; path=" + escape ( path );
 
  if ( domain )
        cookie_string += "; domain=" + escape ( domain );
  
  if ( secure )
        cookie_string += "; secure";
  
  document.cookie = cookie_string;
}
		jQuery('#yes_lang').on('click', function() {
			set_cookie ( "yes_lang", "EN", 2021, 01, 01 );
			jQuery('#select_lang').hide();
		});
		
	 jQuery('div.pull-right:first').before('<div class="pull-right s8065 hidden-xs right_buttons"></div>');
        jQuery('.s8065').append('<ul class="header-menu s9633 clearfix"><div class="magic_line" style="max-width: 160px;"></div></ul>');
        jQuery('.s9633').append(jQuery('.header_main_menu_wrapper .pll-parent-menu-item'));
        jQuery('.s9633 .menu-item-1941').css('margin-left', '20px');
        jQuery('.s9633 .menu-item-1941').css('margin-right', '50px');
		jQuery('.s9633 .menu-item-2356').css('margin-left', '20px');
        jQuery('.s9633 .menu-item-2356').css('margin-right', '50px');
//        jQuery('.header_main_menu_wrapper .search-toggler').css('margin-left', '25px');
        jQuery('.header_main_menu_wrapper .s8065 .header-menu > li > ul.sub-menu > li a').css('padding', '1px 2px 0px 28px');
        jQuery('.header_main_menu_wrapper .s8065 .header-menu > li > ul.sub-menu').css('width','70px');
        jQuery('.header_main_menu_wrapper .s8065 .header-menu > li > ul.sub-menu').css('left','30px');
        jQuery('.menu-item-1565 .sub-menu').css('left','-15px');
        jQuery('.header_main_menu_wrapper .s8065 .header-menu > li > ul.sub-menu').css('padding','10px 0px');
        jQuery('.s8065').before('<div class="pull-right s8066 hidden-xs right_buttons"></div>');
        jQuery('.s8066').append('<ul class="header-menu s9634 clearfix"><div class="magic_line" style="max-width: 160px;"></div></ul>');
		jQuery('.s9634').append(jQuery('.header_main_menu_wrapper .menu-item-2721'));
		jQuery('.s9634').append(jQuery('.header_main_menu_wrapper .menu-item-2722'));
        jQuery('.s9634').append(jQuery('.header_main_menu_wrapper .menu-item-2023'));
		jQuery('.s9634').append(jQuery('.header_main_menu_wrapper .menu-item-2357'));
		jQuery('.s9634 .menu-item-2721').css('margin-left', '50px');
		
		jQuery(window).ready(function() {
			jQuery('.magic_line').removeClass('line_visible');
		});
		var href = window.location.href;
		if(href.includes('/en/')) {
			jQuery('.menu-item-2356-en').remove();
		}
		
		
        
        
        <?php if(is_user_logged_in()) { ?>
		//ru
        jQuery('.menu-item-1565').css('display', 'block');
        jQuery('.menu-item-2023').css('display', 'none');
		//en
		 jQuery('.menu-item-1565').css('display', 'block');
		 jQuery('.menu-item-2357').css('display', 'none');
		//ru
        jQuery('.menu-item-2023').css('display', 'none');
		 jQuery('.menu-item-1565').css('display', 'block');
       
<?php } else { ?>
		//ru
        jQuery('.menu-item-1565').css('display', 'none');
        jQuery('.menu-item-2023').css('display', 'block');
		jQuery('.menu-item-2023').css('margin-left', '0px');
		//en
		 jQuery('.menu-item-2412').css('display', 'none');
        jQuery('.menu-item-2357').css('display', 'block');
		
		//pt
		 jQuery('.menu-item-1565').css('display', 'none');
        jQuery('.menu-item-2023').css('display', 'block');
		
        
<?php } ?>
        
       
    </script>

    
    
    

    
    
    
    
    
    
    <div id="main">