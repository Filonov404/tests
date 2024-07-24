<?php
add_filter('show_admin_bar', '__return_false');



$theme_info = wp_get_theme();
define('STM_THEME_VERSION', ( WP_DEBUG ) ? time() : $theme_info->get( 'Version' ) );

$inc_path = get_template_directory() . '/inc';

$widgets_path = get_template_directory() . '/inc/widgets';
// Theme setups

// Custom code and theme main setups
require_once($inc_path . '/setup.php');

// Enqueue scripts and styles for theme
require_once($inc_path . '/scripts_styles.php');

/*Theme configs*/
require_once($inc_path . '/theme-config.php');

// Visual composer custom modules
if (defined('WPB_VC_VERSION')) {
	require_once($inc_path . '/visual_composer.php');
}

// Custom code for any outputs modifying
//require_once($inc_path . '/payment.php');
require_once($inc_path . '/custom.php');

// Custom code for woocommerce modifying
if (class_exists('WooCommerce')) {
	require_once($inc_path . '/woocommerce_setups.php');
}

if(defined('STM_LMS_URL')) {
	require_once($inc_path . '/lms/main.php');
}
function stm_glob_pagenow(){
    global $pagenow;
    return $pagenow;
}
function stm_glob_wpdb(){
    global $wpdb;
    return $wpdb;
}

if(class_exists('BuddyPress')) {
    require_once($inc_path . '/buddypress.php');
}

//Announcement banner
if (is_admin()) {
	require_once($inc_path . '/admin/generate_styles.php');
	require_once($inc_path . '/admin/admin_helpers.php');
	require_once($inc_path . '/admin/review/review-notice.php');
	require_once($inc_path . '/admin/product_registration/admin.php');
	require_once($inc_path . '/tgm/tgm-plugin-registration.php');
}

// Handle the parsing of the _ga cookie or setting it to a unique identifier
function gaParseCookie($ga_cookie = NULL) {

$cookie_ga = isset($_COOKIE['_ga']) ? $_COOKIE['_ga'] : $ga_cookie;

  if (isset($cookie_ga)) {
    list($version,$domainDepth, $cid1, $cid2) = explode('.', $cookie_ga);
    $contents = array('version' => $version, 'domainDepth' => $domainDepth, 'cid' => $cid1.'.'.$cid2);
    $cid = $contents['cid'];
  }
  else $cid = ''; 
  return $cid;
}

add_filter( 'wpcf7_before_send_mail', 'wpcf7_before_send_mail_start_function' );
function wpcf7_before_send_mail_start_function($cf7) {
	$mail=$cf7->prop('mail');
	if($mail){
		// Отправка данных в CRM
		$send_result = send_to_crm($cf7);
		// По результату отправки данных 
		if(isset($send_result['result'])){
			// отправка прошла удачно и письмо отправляем на резервный e-mail
			$mail['recipient'] = "резервный_e-mail_для_заявок_с_сайта";
		} else {
			// отправка прошла не удачно и надо отправить письмо на e-mail указанный в настройках CF7
			$text = wpcf7_mail_replace_tags($mail['body']);
			$text .= '<br><p>' . print_r($send_result, true) . '</p>';
			$mail['body'] = $text;
		}
		$cf7->set_properties(array('mail'=>$mail));
	}
}

function restCommand($method, array $params = array(), array $auth = array()) {
    $queryUrl  = 'https://uchebnyytsentr1.bitrix24.ru/rest/1/vmsd8mr9yt0i1i2y/profile/' . $method;
    $queryData = http_build_query($params);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_POST           => 1,
        CURLOPT_HEADER         => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL            => $queryUrl,
        CURLOPT_POSTFIELDS     => $queryData,
        )
    );
    $result = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($result, 1);
    return $result;
}

function send_to_crm($contact_form) {
        $result = array();        
        $submission = WPCF7_Submission :: get_instance() ;
        if ($submission) {
                $posted_data = $submission->get_posted_data() ;
                $form_id = $posted_data['_wpcf7'];
                $name = 'empty';
                // заполняем поля в зависимости от id заполненной формы 
                switch ($form_id) {
                        case 112: // заявка с формы
                                $subj = 'Заявка с формы ...';
                                $mail = $posted_data['your-mail']; // данные о номере телефона из формы  
                                $name = $posted_data['your-name']; // данные о ФИО из формы 
                                break;
                }
                $mail = $contact_form->prop('mail');
                $text = wpcf7_mail_replace_tags($mail['body']);
                $phone_trim = trim(preg_replace("/[^0-9+]/", '', $phone));
                $gauid = gaParseCookie();
                $fields = array(
                        'TITLE' => $subj .' от '. $name .' '. $phone, // название Лида название формы имя из формы и номер телефона
                        'NAME' => $name,
                        'SOURCE_ID' => '3', // строка ид для поля Источник
                        'ASSIGNED_BY_ID' => 1, // id сотрудника ответственного за Лид в CRM
                        'COMMENTS' => $text,
                        'UF_CRM_1546540791' => $gauid, // пользовательское поле в Лиде для хранения clientID
                        'UTM_SOURCE' => $posted_data['utm_source'],
                        'UTM_MEDIUM' => $posted_data['utm_medium'],
                        'UTM_CAMPAIGN' => $posted_data['utm_campaign'],
                        'UTM_CONTENT' => $posted_data['utm_content'],
                        'UTM_TERM' => $posted_data['utm_term'],
                );
                // проверка номера телефона на правильность ввода
                if (preg_match("/^(?:8(?:(?:21|22|23|24|51|52|53|54|55)|(?:15\d\d))?|\+?7)?(?:(?:3[04589]|4[012789]|8[^89\D]|9\d)\d)?\d{7}$/", 
                   $phone_trim)) {
                        $fields['PHONE'][0] = array('VALUE' => $phone_trim, 'VALUE_TYPE' => 'WORK');
                } else {
                        $fields['COMMENTS'] = '<p>Номер телефона вероятно не правильный!</p><br>' . $text;
                }
                // Отправка Лида в CRM
                $result = restCommand('crm.lead.add.json', 
                array(
                        'FIELDS' => $fields, 
                        'PARAMS' => array('REGISTER_SONET_EVENT' => 'Y'),
                )
                );
        }        
        return $result;
}




add_action('add_meta_boxes', 'myplugin_add_custom_boxz');
function myplugin_add_custom_boxz(){
	$screens = array( 'stm-courses' );
 
    add_meta_box( 'myplugin_sectionid', 'Отключение блоков', 'myplugin_meta_box_callbackz', $screens );

	
}

// HTML код блока
function myplugin_meta_box_callbackz( $post, $meta ){
	$screens = $meta['args'];

	

	?>
<label for="czv">Включить Часто Задаваемые вопросы?</label>
<input <?php $czv = get_post_meta( get_the_id(), 'czv', true ); if ($czv == 'on') { echo 'checked';}; ?> type="checkbox" name="czv"><br>
<label for="czv">Включить Объявления?</label>
<input <?php $obv = get_post_meta( get_the_id(), 'obv', true ); if ($obv == 'on') { echo 'checked';}; ?> type="checkbox" name="obv"><br>
<label for="czv">Включить Отзывы?</label>
<input <?php $otz = get_post_meta( get_the_id(), 'otz', true ); if ($otz == 'on') { echo 'checked';}; ?> type="checkbox" name="otz"><br>
	
	<?php 
}



## Сохраняем данные, когда пост сохраняется
add_action( 'save_post', 'myplugin_save_postdata' );
function myplugin_save_postdata( $post_id ) {
	// Убедимся что поле установлено.
	

	

	// если это автосохранение ничего не делаем
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return;

	// проверяем права юзера
	if( ! current_user_can( 'edit_post', $post_id ) )
		return;

	// Все ОК. Теперь, нужно найти и сохранить данные
	// Очищаем значение поля input.
	$my_data = sanitize_text_field( $_POST['czv'] );
    $my_data2 = sanitize_text_field( $_POST['obv'] );
    $my_data3 = sanitize_text_field( $_POST['otz'] );

	// Обновляем данные в базе данных.
	update_post_meta( $post_id, 'czv', $my_data );
    update_post_meta( $post_id, 'obv', $my_data2 );
    update_post_meta( $post_id, 'otz', $my_data3 );
   
}

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Основные настройки',
		'menu_title'	=> 'Настройки темы',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	
	
}



add_action('wp_ajax_new_like', 'new_like');
add_action('wp_ajax_nopriv_new_like', 'new_like');

function new_like() {
$get_ip_likes_base = get_post_meta($_POST['post_id'], 'ip_likes', false);
if(!in_array($_POST['ip'], $get_ip_likes_base)) {
$get_count_likes = get_post_meta($_POST['post_id'], 'liked', true);
$new_val_count = ($get_count_likes + 1);
update_post_meta($_POST['post_id'], 'liked', $new_val_count);
add_post_meta($_POST['post_id'], 'ip_likes', $_POST['ip']);
echo $get_count_final = get_post_meta($_POST['post_id'], 'liked', true);
die();
} else {
echo $get_count_final = get_post_meta($_POST['post_id'], 'liked', true);
die();
} 

}


add_filter( 'the_content', 'filter_function_name_11' );

function filter_function_name_11( $content ) {

if ($GLOBALS['post']->post_type == 'post' ) {
if(is_single()) {
    $content = $content;
	$content .= '<br><div class="s9877" style="display: flex; align-items: center;"><img id="new_like" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAB0UlEQVRYhe2Vv2vVUBiGU7UoUlAEh+ImKEgnN6Vgxc1B7ve+3/lIGzLcDj2DcF26OEkc/BNEcXPQDuooVnAQZx3F1UHqr1LoUKRUjUsDJU1uk9skLn3g207yPJycJEFwwAFDSNP0kJldFhFPchHAbBRFZ/dYP6OqCyQXRWTOzM7UFpvZYefcTZIrANLc/BWR5SiKzu28BsA8yc9F6wG8UdWLleRJkhwTkZcFN8rPunPuahAEgYjcr7B+S0Tm9gwQkScVbpbNN1W9XXU9yT9mNlMqB3CthnzU+ZgkyZGygKcdBKQkrxT5x0h+7yjg3i67mU10Id8OWCoKONVVAIAXuwL6/f7JDnfgWeEhJPm1iwDnXFIW8KqjgF5hgKre6WD7f8dxPFkYEMfxJMnNNgNU9XmhfMdjeNzyDkwPDVDVKQBbLQW8GyrPAHC3BflG/hdeivd+nOSHhgNuVZJnhGF4HsBqgwdvrFbAdsQlABv7DHg7GAyO1pZniMh1kr9GlL83sxMjyzNITgNYqyMXkWUzm9i3PCMMwwskP1WRk3zovR9vTJ7hvT8O4MEQ+U9VlcbFeXq93g2SP3Ly16Xf+DYws9MAHpH8AmA+GOU1a4j/Jm6Ef5WsA4toQyhzAAAAAElFTkSuQmCC"><span style="font-size:16px; padding-left:5px; font-weight: bold;" id="count_likes">'.get_post_meta(get_the_id(), 'liked', true).' Нравится</span></div>';
	$content .= '<script>
		
		jQuery("#new_like").on("click", function(e) {
e.preventDefault();
var post_id = "'.get_the_ID().'";
var ip = "'.$_SERVER['REMOTE_ADDR'].'";
jQuery.ajax({
        url: "/wp-admin/admin-ajax.php",
        method: "POST",
        data: {
            action:"new_like",
			post_id: post_id,
			ip:ip
			},
        success: function (data) {
		jQuery("#new_like").addClass("liked");

jQuery("#count_likes").html(data);

 },
        Error: function (data) {

        }
      })
	 
		}); 
	
		</script>
		<style>
		.liked {filter: invert(30%) sepia(80%) saturate(6127%) hue-rotate(348deg) brightness(125%) contrast(102%);}
		</style>
		';

	return $content;
	} else {
	$content = $content;
	return $content;
	}
} else {

return $content;
}

}


add_action( 'woocommerce_account_dashboard', 'action_function_name_8460' );
function action_function_name_8460(){

if(get_user_meta(get_current_user_id(), 'first_enter', true) !== '1') {

?>

<label style="background: rgb(237, 255, 216);
padding: 10px;
color: #000;
border-radius: 10px;
font-size: 13px;">Логин и пароль отправлены на ваш email</label>
<?php 
}
update_user_meta(get_current_user_id(), 'first_enter', '1');
}



//function wc_remove_password() {
//
//	if(wp_script_is("wc-password-strength-meter", "enqueued")) {
//	
////		wp_dequeue_script("wc-password-strength-meter"); 
//		
//	}
//	
//}
//
//add_action("wp_print_scripts", "wc_remove_password", 100);




add_action( 'user_register', 'reg_s' );
function reg_s( $user_id ) {
global $wpdb;
	$sqlQuery = "INSERT INTO `wpxa_pmpro_memberships_users` (`id`, `user_id`, `membership_id`, `code_id`, `initial_payment`, `billing_amount`, `cycle_number`, `cycle_period`, `billing_limit`, `trial_amount`, `trial_limit`, `status`, `startdate`, `enddate`, `modified`) VALUES (NULL, $user_id, '1', '', '', '', '', '', '', '', '', 'active', '', NULL, CURRENT_TIMESTAMP)";
			$wpdb->query($sqlQuery);
			
}


add_action('wp_ajax_nopriv_send_req_new', 'send_req_new');
add_action('wp_ajax_send_req_new', 'send_req_new');

function send_req_new() {

$pass_gen = wp_generate_password();
$name_user_req = $_POST['name_user_req'];
$phone_user_req = $_POST['phone_user_req'];
$email_user_req = $_POST['email_user_req'];
$question_user = $_POST['question_user'];
$register_s = $_POST['register_s'];
 if($register_s == 'true') {
if(email_exists($email_user_req) ){
echo 'Вы уже зарегистрированы! Войдите под своим логином <a href="/my-account">здесь</a>';
die();
 } else {


$userdata = array(

	'user_pass'       => $pass_gen, // обязательно
	'user_login'      => $email_user_req, // обязательно
	'user_email'      => $email_user_req,
	
	
);


if (!is_user_logged_in() ) {
 $finish_registration = wp_insert_user( $userdata );
 } else {
 echo 'Нельзя зарегистрироваться, т.к. вы уже авторизованы на сайте. Начните с <a href="/">Главной</a>';
 }

 
if (!is_user_logged_in() ) {
$user       = get_userdata($finish_registration);
$creds = array();
$creds['user_login'] = $email_user_req;
$creds['user_password'] = $pass_gen;

	$user = wp_signon( $creds, false );

if ( is_wp_error($user) ) {
   echo $user->get_error_message();
}

	
} 



}


}

$token = '1362868540:AAHHYVNSffNg1lcmb8OUcC8FSXZsi_h8U88';
$chat_id = '185658911';

if(empty($question_user)) {
$question = 'Вопрос не задан';
} else {
$question = $question_user;
}

$arr = array(
'Сайт: ' => 'ОЮ RU',
  'Имя : ' => $name_user_req,
  'Телефон: ' => $phone_user_req,
  'Email: ' => $email_user_req,
  'Вопрос: ' => $question

);
 
foreach($arr as $key => $value) {
  $txt .= "<b>".$key."</b> ".$value."%0A";
};
 

$sendToTelegram =  file_get_contents("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}");


 

if ($sendToTelegram) {
  echo "Спасибо, Отправлено!<br>";
  if(!empty($finish_registration)) {
  echo 'Мы зарегистрировали Вас на сайте!<br> Можете совершить:  <a href="/my-account/">Вход</a>';
  }
	die();
} else {
  echo "Возникла ошибка, повторите...";
	die();
}
}



$taxname = 'category';

// Поля при добавлении элемента таксономии
add_action("{$taxname}_add_form_fields", 'add_new_custom_fields');
// Поля при редактировании элемента таксономии
add_action("{$taxname}_edit_form_fields", 'edit_new_custom_fields');

// Сохранение при добавлении элемента таксономии
add_action("create_{$taxname}", 'save_custom_taxonomy_meta');
// Сохранение при редактировании элемента таксономии
add_action("edited_{$taxname}", 'save_custom_taxonomy_meta');

function edit_new_custom_fields( $term ) {
	?>
		<tr class="form-field">
			<th scope="row" valign="top"><label>ID Адресной книги SENDPULSE</label></th>
			<td>
				<input type="text" name="extra[id_book_sendpulse]" value="<?php echo esc_attr( get_term_meta( $term->term_id, 'id_book_sendpulse', 1 ) ) ?>"><br />
				
			</td>
		</tr>
		
	<?php
}

function add_new_custom_fields( $taxonomy_slug ){
	?>
	<div class="form-field">
		<label for="tag-title">Заголовок</label>
		<input name="extra[id_book_sendpulse]" id="tag-title" type="text" value="" />
		<p>ID Адресной книги SENDPULSE</p>
	</div>
	
	<?php
}

function save_custom_taxonomy_meta( $term_id ) {
	if ( ! isset($_POST['extra']) ) return;
	if ( ! current_user_can('edit_term', $term_id) ) return;
	if (
		! wp_verify_nonce( $_POST['_wpnonce'], "update-tag_$term_id" ) && // wp_nonce_field( 'update-tag_' . $tag_ID );
		! wp_verify_nonce( $_POST['_wpnonce_add-tag'], "add-tag" ) // wp_nonce_field('add-tag', '_wpnonce_add-tag');
	) return;

	// Все ОК! Теперь, нужно сохранить/удалить данные
	$extra = wp_unslash($_POST['extra']);

	foreach( $extra as $key => $val ){
		// проверка ключа
		$_key = sanitize_key( $key );
		if( $_key !== $key ) wp_die( 'bad key'. esc_html($key) );

		// очистка
		if( $_key === 'tag_posts_shortcode_links' )
			$val = sanitize_textarea_field( strip_tags($val) );
		else
			$val = sanitize_text_field( $val );

		// сохранение
		if( ! $val )
			delete_term_meta( $term_id, $_key );
		else
			update_term_meta( $term_id, $_key, $val );
	}

	return $term_id;
}