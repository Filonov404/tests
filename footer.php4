			</div>
		</div>
		<footer id="footer">
			<div class="footer_wrapper tessssssst">
				<?php get_template_part('partials/footers/footer', 'top'); ?>
				<?php get_template_part('partials/footers/footer', 'bottom'); ?>
				<?php get_template_part('partials/footers/copyright'); ?>
			</div>
		</footer>

		<?php if(is_singular('events')): ?>
			<?php get_template_part( 'partials/event', 'form' ); ?>
		<?php endif; ?>

		<!-- Searchform -->
		<?php get_template_part('partials/searchform'); ?>

		<script>
			var cf7_custom_image = '<?php echo esc_url( get_stylesheet_directory_uri() )  ?>/assets/img/';
			var daysStr = '<?php esc_html_e('Days', 'masterstudy'); ?>';
			var hoursStr = '<?php esc_html_e('Hours', 'masterstudy'); ?>';
			var minutesStr = '<?php esc_html_e('Minutes', 'masterstudy'); ?>';
			var secondsStr = '<?php esc_html_e('Seconds', 'masterstudy'); ?>';
		</script>

		<?php
			global $wp_customize;
			if( is_stm() && ! $wp_customize ){
				get_template_part( 'partials/frontend_customizer' );
			}
		?>

	<?php wp_footer(); ?>


<script>

jQuery('.stm_lms_register_wrapper .btn').on('click', function(e) {
e.preventDefault();
jQuery('[type="password"]').each(function() {
if(jQuery(this).length < 6) {
jQuery('.stm_lms_register_wrapper').after('Пароль не менее 6 символов');
return false;
} else {
e.stopPropagation();
}
});

});

	jQuery('.sp-form').css('margin', '0');
	jQuery('.sp-form').css('padding-left', '0');
	jQuery('.courses_filters__activities').remove();
	<?php if(is_page('my-account') || is_page('my-account-en')) {
	$on_zakazy = get_post_meta(get_the_id(), 'on_zakazy', true);
	$on_zagruzki = get_post_meta(get_the_id(), 'on_zagruzki', true);
	$on_adresa = get_post_meta(get_the_id(), 'on_adresa', true);
	?>
	<?php if ($on_zakazy !== '1') { ?>
	jQuery('.woocommerce-MyAccount-navigation-link--orders').remove();
	
	<?php } ?>
	<?php if ($on_zagruzki !== '1') { ?>
	jQuery('.woocommerce-MyAccount-navigation-link--downloads').remove();
	
	<?php } ?>
	<?php if ($on_adresa !== '1') { ?>
	jQuery('.woocommerce-MyAccount-navigation-link--edit-address').remove();
	
	<?php } ?>
	
	
<?php } ?>
	
    jQuery('.footer_widgets_wrapper .cols_2').addClass('cols_3');
jQuery('.cols_3').removeClass('cols_2');
   
//    jQuery('.front').css('display', 'none');
//        jQuery('.back').css('transform', 'none');
    jQuery('.fa-facebook::before').css('color', '#fff');
	 jQuery('.btn').css('color', '#fff');
    jQuery('#socials-3 h3').css('padding-left', '15px');
     jQuery('.header_default .container .row').addClass('black_ed');
	
		jQuery('.pmpro_content_message a').each(function() {
			if(jQuery(this).attr('href').includes('register')) {
				jQuery(this).remove();
			}
		});
    
    <?php if(is_user_logged_in()) { ?>
        jQuery('.vc_custom_1588585509092').css('display', 'none');
	jQuery('.vc_custom_1590761414667').css('display', 'none');
	
        jQuery('.vc_custom_1588675427163').css('display', 'none');
	jQuery('.vc_custom_1588586610807').css('display', 'none');
	jQuery('.pmpro_content_message a').each(function() {
			
				jQuery(this).remove();
			
		});
	
        jQuery('#s6333365').css('display', 'none');
    
    jQuery('.vc_custom_1588605926718').css('display', 'none');
    jQuery('#s9777470').css('display', 'none');
    jQuery('#s6333365').css('display', 'none');
    jQuery('.s6333367').css('display', 'none');
    
    
    
    
    
        
<?php } else { ?>
       
        
<?php } ?>
    
        
        <?php $otz = get_post_meta( get_the_id(), 'czv', true ); if ($otz !== 'on') {  ?> 
    jQuery('.nav-tabs li a').each(function() {
       let del_this = jQuery(this).text();
        
        if(del_this.includes('Часто задаваемые вопросы') ) {
            jQuery(this).parent().remove();
        }
         });
        
<?php    } ?>
        
        <?php $obv = get_post_meta( get_the_id(), 'obv', true ); if ($obv !== 'on') {  ?> 
     jQuery('.nav-tabs li a').each(function() {
       let del_this = jQuery(this).text();
        
   if(del_this.includes('Объявление') ) {
            jQuery(this).parent().remove();
        }
    });
        
        <?php    } ?>
        
        <?php $otz = get_post_meta( get_the_id(), 'otz', true ); if ($otz !== 'on') {  ?> 
    jQuery('.nav-tabs li a').each(function() {
       let del_this = jQuery(this).text();
        
         if(del_this.includes('Отзывы лалала') ) {
            jQuery(this).parent().remove();
        }
           });
        
        <?php    } ?>
        
   <?php if(is_page('my-account')) { ?>
   jQuery('.mo-openid-app-icons .btn').css('margin-bottom', '20px');
jQuery('.mo-openid-app-icons .login-button').css('display', 'inline-block');
jQuery('.mo-openid-app-icons .login-button').css('margin-top', '0px');
jQuery('.mo-openid-app-icons svg').css('padding-top', '10px');
jQuery('.mo-openid-app-icons .mofa').css('padding-top', '5px');
jQuery('.mo-openid-app-icons svg').addCLass('fillcolor');

<?php } ?>
    
   
</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(65295190, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/65295190" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
	</body>
</html>