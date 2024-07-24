<?php $vc_status = get_post_meta(get_the_ID(), '_wpb_vc_js_status', true); ?>


<?php if ($vc_status != 'false' && $vc_status == true): ?>

	<?php get_template_part('partials/title_box'); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="container">
			<?php the_content(); ?>
			<?php
			wp_link_pages(array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'masterstudy') . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __('Page', 'masterstudy') . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			));
			?>
        </div>
    </article>

<?php else: ?>


	<?php
	// Blog setup
	$blog_layout = stm_option('blog_layout');

	// Sidebar
	$blog_sidebar_position = stm_option('blog_sidebar_position', 'none');


	$content_before = $content_after = $sidebar_before = $sidebar_after = '';

	if (!empty($_GET['sidebar_id'])) {
		$blog_sidebar_id = intval($_GET['sidebar_id']);
	} else {
		$blog_sidebar_id = stm_option('blog_sidebar');
	}

	if ($blog_sidebar_id) {
		$blog_sidebar = get_post($blog_sidebar_id);
	}

	if (empty($blog_sidebar)) {
		$blog_sidebar_position = 'none';
	}

	if ($blog_sidebar_position == 'right' && isset($blog_sidebar)) {
		$content_before .= '<div class="row">';
		$content_before .= '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">';

		$content_after .= '</div>'; // col
		$sidebar_before .= '<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">';
		// .sidebar-area
		$sidebar_after .= '</div>'; // col
		$sidebar_after .= '</div>'; // row
	}

	if ($blog_sidebar_position == 'left' && isset($blog_sidebar)) {
		$content_before .= '<div class="row">';
		$content_before .= '<div class="col-lg-9 col-lg-push-3 col-md-9 col-md-push-3 col-sm-12 col-xs-12">';

		$content_after .= '</div>'; // col
		$sidebar_before .= '<div class="col-lg-3 col-lg-pull-9 col-md-3 col-md-pull-9 hidden-sm hidden-xs">';
		// .sidebar-area
		$sidebar_after .= '</div>'; // col
		$sidebar_after .= '</div>'; // row
	}

	?>
    <!-- Title -->
	<?php get_template_part('partials/title_box'); ?>
    <div class="container blog_main_layout_<?php echo esc_attr($blog_layout); ?>">

		<?php echo wp_kses_post($content_before); ?>
        <div class="blog_layout_list sidebar_position_<?php echo esc_attr($blog_sidebar_position); ?>">
            <div class="stm_post_unit">
                <div class="stm_post_info">
                    <h1 class="h2 post_title"><?php the_title(); ?></h1>
                    <div class="stm_post_details clearfix">
                        <ul class="clearfix post_meta">
                            <li class="post_date h6"><i
                                        class="far fa-clock"></i><span><?php echo get_the_date(); ?></span></li>
                            <li class="post_by h6"><i class="fa fa-user"></i><?php _e('Posted by:', 'masterstudy'); ?>
                                <span><a href="/about-author/"><?php the_author(); ?></a></span></li>
							<?php $cats = get_the_category(get_the_id()); //print_r($cats); ?>
							<?php if (!empty($cats)): ?>
                                <li  class="post_cat h6"><i class="fa fa-flag"></i>
									<?php _e('Category:', 'masterstudy'); ?>
									<?php foreach ($cats as $cat): ?>
                                        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><span><?php echo sanitize_text_field($cat->name); ?></span></a>
									<?php endforeach; ?>
                                </li>
							<?php endif; ?>
                        </ul>
                        <div class="comments_num">
                            <a href="<?php comments_link(); ?>" class="post_comments h6"><i
                                        class="fa fa-comments-o"></i> <?php comments_number(); ?> </a>
                        </div>
                    </div>
					<?php if (has_post_thumbnail()) { ?>
						<?php if (!isset($blog_sidebar) && $blog_sidebar_position == 'none') {
							$image_size = 'img-1170-500';
						} else {
							$image_size = 'large';
						}; ?>
                        <div class="post_thumbnail">
							<?php the_post_thumbnail($image_size, array('class' => 'img-responsive s02114')); ?>
                        </div>
					<?php } ?>
                </div>
				<?php if (get_the_content()) { ?>
                    <div class="text_block clearfix">
						<?php the_content(); ?>
						<?php 
			$catd = get_the_category(get_the_id());
			
  $catd[0]->term_id;
	?>
	<div class="subscribe_form">
	<div class="row">
	<div class="col-lg-12">
	<h4 style="margin-top:3%;">Подпишитесь на e-mail-рассылку , чтобы в числе первых узнавать о выходе новых материалов.</h4>
	</div>
	</div>
	<div class="row subscribe_user">
	<style>
	@media (max-width: 740px) {
	.subscribe_form button { font-size: 13px;}
	.check_topic { display: block !important; margin-left: 10px;}
.subscribe_user { display: block !important; }
.step_2_sub {  margin-top: 10px;}
.sub_button_user { width: 100%; text-align: center;}
}
	.subscribe_form { margin-top: 10px; margin-bottom: 10px;}
	.subscribe_user { display: flex; align-items: center; }
	.subscribe_user span {color:  #ACACAC; font-size: 12px;}
	.subscribe_user input { width: 100%; margin-bottom: 10px;}
	.sub_button_user {
	background: #c6ae81;
	height: 45px;
color: #FFFFFF;
font-size: 15px;
padding: 5px 12px;
border: 0px;
margin-bottom: 5px;
	}
	.ckeck_topic { margin-bottom: 10px;}
	#result { font-size: 13px; text-align: center; font-weight: 600; margin-bottom: 10px;}
	.step_2_sub { display: none; padding-left: 30px; margin-top: 10px;}
	.check_topic { display: inline-block; margin-left: 10px;}
	.step_2_sub h5 { font-size: 17px;}
	.check_topic label {color: #222222;}
	</style>
	
	<div class="col-lg-3">
	<input type="text" class="req_val" placeholder="Email" id="email_user_s">
	</div>
	<div class="col-lg-3">
	<input type="text" class="req_val" placeholder="Имя" id="name_user_s">
	</div>
	
	<div class="col-lg-2">
	<button id="sub_button_user" class="sub_button_user button" disabled>Далее</button>
	</div>
	<div class="col-lg-4">
	<span>Подписываясь на рассылку, вы даете свое согласие на <a href="/privacy-policy/">обработку персональных данных</a></span>
	</div>
	</div>
	<div class="row step_2_sub">
	<div class="col-lg-12">
	<h5>Какие темы Вам интересны?</h5>
	</div>
	<div class="col-lg-8">
<?php 
$categories = get_categories( [
	'taxonomy'     => 'category',
	'type'         => 'post',
	'child_of'     => 0,
	'parent'       => '',
	'orderby'      => 'name',
	'order'        => 'ASC',
	'hide_empty'   => 0,
	'hierarchical' => 1,
	'exclude'      => [1, 21],
	'include'      => '',
	'number'       => 0,
	'pad_counts'   => false,
	
] );
?>
<div class="ckeck_topic">
<?php
if( $categories ){ ?>

<div class="form-check check_topic">
    <input id="select_topic_all" type="checkbox" class="form-check-input select_topic_all">
    <label class="form-check-label" for="exampleCheck1">Все категории</label>
  </div>
<?php
	foreach( $categories as $cat ){
		?>
		 <div class="form-check check_topic">
    <input type="checkbox" class="form-check-input select_topic" data-id-book="<?php echo get_term_meta( $cat->term_id, 'id_book_sendpulse', 1 );?>">
    <label class="form-check-label" for="exampleCheck1"><?php echo $cat->name; ?></label>
  </div>
		<?php
		
	}
}
?>
</div>
</div>
<div class="col-lg-2 col-xs-6 col-sm-6"><button id="sub_button_user_final" class="sub_button_user button">Подписаться</button></div>
<div class="col-lg-2 col-xs-6 col-sm-6"><button id="sub_button_user_back" class="sub_button_user button">Отмена</button></div>

	</div>
	<script>
	
	
	
	jQuery('#select_topic_all').click(function(){
	if (jQuery(this).is(':checked')){
		jQuery('.select_topic').prop('checked', true);
	} else {
		jQuery('.select_topic').prop('checked', false);
	}
});
	
	
	jQuery('#sub_button_user').on('click', function() {
	jQuery(this).hide();
	jQuery('#result').text('');
	if(jQuery('.req_val').val().length > 0) {
	jQuery('.subscribe_user').hide(1000);
    jQuery('.step_2_sub').show(1000);
	} else {
	jQuery('#result').text('Нужно заполнить все поля!');
	jQuery('#result').css('color', 'red');
	}
	});
	jQuery('#sub_button_user_back').on('click', function() {
	jQuery('#sub_button_user').show();
	jQuery('.subscribe_user').show(1000);
	jQuery('.step_2_sub').hide(1000);
	});
	
	jQuery('#sub_button_user_final').on('click', function(e) {
	if(jQuery('.select_topic').prop('checked')) {
e.preventDefault();
let ars = [];
jQuery('.select_topic:checked').each(function() {
ars.push(jQuery(this).data('id-book'));
});
var user_email = jQuery('#email_user_s').val();
var user_name = jQuery('#name_user_s').val();
jQuery.ajax({
        url: '/sendpulse_lib/get_api.php',
        method: 'POST',
        data: {
            email_user:user_email,
			name_user:user_name,
			selected_topic:ars
			
 },
        success: function (data) {
		if(data.includes('Спасибо')) {
		jQuery('#result').html(data);
		jQuery('#result').css('color', 'green');
		jQuery('.step_2_sub').hide();
		}



 },
        Error: function (data) {

        }
      }); } else {
	  jQuery('#result').text('Нужно выбрать хотя бы одну тему');
	  jQuery('#result').css('color', 'red');
	  }
	  
	 
		}); 
		
		

 var pattern = /^[a-z0-9_-]+@[a-z0-9-]+\.[a-z]{2,6}$/i;
 var mail = jQuery('#email_user_s');
 
 mail.blur(function(){
 if(mail.val() != ''){
 if(mail.val().search(pattern) == 0){

 jQuery('#sub_button_user').attr('disabled', false);

 }else{
 jQuery('#result').text('Укажите email в правильном формате.');
 jQuery('#result').css('color', 'red');
 jQuery('#sub_button_user').attr('disabled', true);

 }
 }else{
 jQuery('#result').text('Поле e-mail не должно быть пустым!');
 jQuery('#result').css('color', 'red');

 jQuery('#submit').attr('disabled', true);
 }
 });


//jQuery('#sub_button_user_final').on('click', function(e) {
//
//});
	
	</script>
	<p id="result"></p>
	</div>
                    </div>
				<?php } ?>
            </div> <!-- stm_post_unit -->

			<?php
			wp_link_pages(array(
				'before'      => '<div class="page-links"><label>' . __('Pages:', 'masterstudy') . '</label>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '%',
				'separator'   => '',
			));
			?>

            <div class="row mg-bt-10">
                <div class="col-md-8 col-sm-8">
                    <div class="stm_post_tags widget_tag_cloud">
						<?php if ($tags = wp_get_post_tags(get_the_ID())) { ?>
                            <div class="tagcloud">
								<?php foreach ($tags as $tag) { ?>
                                    <a href="<?php echo get_tag_link($tag); ?>"><?php echo sanitize_text_field($tag->name); ?></a>
								<?php } ?>
                            </div>
						<?php } ?>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
<!--
                    <div class="pull-right xs-pull-left">
						<?php if(function_exists('stm_configurations_share')) stm_configurations_share(); ?>
                    </div>
-->
                </div>
            </div> <!-- row -->

			<?php //if (get_the_author_meta('description')) : ?>
                <div class="stm_author_box clearfix">
                    <div class="author_name">
                        <div style="display: inline-block;" class="avatar_u"><?php echo get_avatar(get_the_author_meta('email'), 174); ?></div>
						<style>.avatar_u img { max-width: 60px; padding-right: 15px;}</style>
						<div style="display: inline-block;"><a href="/about-author/"><h4><?php _e('Автор: ', 'masterstudy'); ?><?php the_author_meta('nickname'); ?></h4></a></div>
                    </div>
                    <div class="author_avatar">
						
<!--
                        <div class="author_info">
                            <div class="author_content"><?php echo get_the_author_meta('description'); ?></div>
                        </div>
-->
                    </div>
                </div>
			<?php //endif; ?>

            <div class="multiseparator"></div>
			<?php if (comments_open() || get_comments_number()) { ?>
                <div class="stm_post_comments">
					<?php comments_template(); ?>
                </div>
			<?php } ?>
        </div>
		<?php echo wp_kses_post($content_after); ?>
		<?php echo wp_kses_post($sidebar_before); ?>
        <div class="sidebar-area sidebar-area-<?php echo esc_attr($blog_sidebar_position); ?>">
			<?php
			if (isset($blog_sidebar) && $blog_sidebar_position != 'none') {
				echo apply_filters('the_content', $blog_sidebar->post_content);
			}
			?>
        </div>
		<?php echo wp_kses_post($sidebar_after); ?>

    </div>

<?php endif; ?>