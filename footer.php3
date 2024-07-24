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
    jQuery('.footer_widgets_wrapper .cols_2').addClass('cols_3');
jQuery('.cols_3').removeClass('cols_2');
   
//    jQuery('.front').css('display', 'none');
//        jQuery('.back').css('transform', 'none');
    jQuery('.fa-facebook::before').css('color', '#fff');
    jQuery('#socials-3 h3').css('padding-left', '15px');
     jQuery('.header_default .container .row').addClass('black_ed');
	
		jQuery('.pmpro_content_message a').each(function() {
			if(jQuery(this).attr('href').includes('register')) {
				jQuery(this).remove();
			}
		});
    
    <?php if(is_user_logged_in()) { ?>
        jQuery('.vc_custom_1588585509092').css('display', 'none');
        jQuery('.vc_custom_1588675427163').css('display', 'none');
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
        
   
    
   
</script>
	</body>
</html>