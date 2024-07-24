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
<div class="button_send_req" style="z-index: 9999;"><button id="send_req" data-toggle="modal" data-target="#send_req_modal">Записаться на консультацию</button></div>



<!-- Modal -->
<div class="modal fade" id="send_req_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<script>
function limitInput( k, obj ) {
        switch( k ){
              
                case 'en':
                        obj.value = obj.value.replace(/[^a-zA-Z0-9 -@\_]/ig,'');           
                break;
				case 'num':
                        obj.value = obj.value.replace(/[^0-9 -\+]/ig,'');           
                break;
        }
}

</script>
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Запись на консультацию</h5>
      
      </div>
	  <?php $user_info = get_userdata(get_current_user_id()); ?>
      <div class="modal-body">
    <input type="text" id="name_user_req" value="" placeholder="Ваше Имя">
	<input type="text" id="phone_user_req" onkeyup="limitInput( 'num', this );" value="" placeholder="Телефон">
	<input type="text" id="email_user_req" onkeyup="limitInput( 'en', this );" value="<?php echo $user_info->user_email; ?>" placeholder="Email">
	
  <div class="form-group">
   
    <textarea class="form-control" id="question_user" placeholder="Опишите суть вопроса" rows="3"></textarea>
  </div>
  <div class="form-check" id="personal_check">
    <input type="checkbox" class="form-check-input" id="personal_s">
    <label class="form-check-label" for="exampleCheck1"><a target="_blank" href="/privacy-policy/">Даю согласие на обработку персональных данных</a></label>
  </div>
  <?php if (!is_user_logged_in() ) { ?>
  <div class="form-check" id="register_check">
    <input type="checkbox" class="form-check-input" id="register_s">
    <label class="form-check-label" for="exampleCheck1">Даю согласие на автоматическую регистрацию на сайте</label>
  </div>
  <?php } ?>
      </div>
      <div class="modal-footer">
   <button type="button" class="btn btn-secondary" data-dismiss="modal">Зыкрыть</button>
        <button type="button" class="btn btn-primary" id="send_reqs">Записаться</button>
		<p id="result"></p>
      </div>
    </div>
  </div>
</div>
	<?php 
	?>
	<script>
	


jQuery('#send_reqs').on('click', function(e) {
e.preventDefault();

var name_user_req = jQuery('#name_user_req').val();
var phone_user_req = jQuery('#phone_user_req').val();
var email_user_req = jQuery('#email_user_req').val();
var question_user = jQuery('#question_user').val();
var personal_s = jQuery('#personal_s').prop("checked");
var register_s = jQuery('#register_s').prop("checked");
if(personal_s == true) {

if((name_user_req != '') && (phone_user_req != '') && (email_user_req != '')  ) {
jQuery('#send_reqs').prop('disabled', true);
jQuery.ajax({
        url: '<?php echo  admin_url('admin-ajax.php'); ?>',
        method: 'POST',
        data: {
            action:'send_req_new',
			name_user_req:name_user_req,
			phone_user_req:phone_user_req,
			email_user_req:email_user_req,
			question_user:question_user,
			register_s:register_s
			
 },
        success: function (data) {

jQuery('#result').html(data);
if(data.includes('Спасибо')) {

jQuery('#send_req_modal input').val('');
jQuery('#send_req_modal input').css('opacity', '0.6');
jQuery('#send_req_modal textarea').val('');
jQuery('#send_req_modal input').prop('disabled', true);
} else {

}

 },
        Error: function (data) {

        }
      }) } else {
	  jQuery('#result').text('Нужно заполнить все поля');
	  } } else {
	 jQuery('#personal_check a').css('color', 'red');
	  }
	 
		}); 


	
	
	
	var header = jQuery('.button_send_req'),
		scrollPrev = 0;

jQuery(window).scroll(function() {
	var scrolled = jQuery(window).scrollTop();
 
	if ( scrolled > 50 && scrolled > scrollPrev ) {
		header.addClass('out');
		
		
		
	} else {
		header.removeClass('out');
		header.addClass('shadow_header_box');
	}
	scrollPrev = scrolled;
});
	</script>

<script>
jQuery('.mailchimp-newsletter .woocommerce-form__label span').each(function() {
jQuery(this).html('<a href="/privacy-policy/" target="_blank">Даю согласие на обработку персональных данных</a>'); 
});

jQuery('.register .woocommerce-Button').on('click',  function(e) {
if(jQuery("#mailchimp_woocommerce_newsletter").prop("checked")) {
} else {
e.preventDefault();
jQuery('.mailchimp-newsletter .woocommerce-form__label span a').css('color', 'red');
}
});
	jQuery('#mailchimp_woocommerce_newsletter').css('width', 'auto');


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