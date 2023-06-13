<?php
/*
Plugin Name: TwoByteCode
Description: A custom plugin to extand features of 2Bytecode theme
Version: 1.0.3
Author: Abhishek Kumar Pathak
Author URI: mailto:officialabhishekpathak@gmail.com
*/

/*
Copyright Abhishek Kumar Pathak, All rights reserved.
*/

//* Don't access this file directly
defined('ABSPATH') or die();


// add if needed
// function twobcplugin_add_script_style_scripts() {

// 	plugins_url( '/css/myCSS.css', __FILE__ );

// }
// add_action( 'wp_enqueue_scripts', 'twobcplugin_add_script_style_scripts' );




function str_encryptaesgcm($plaintext, $password, $encoding = "hex")
{
    if ($plaintext != null && $password != null) {
        $keysalt = openssl_random_pseudo_bytes(16);
        $key = hash_pbkdf2("sha512", $password, $keysalt, 20000, 32, true);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length("aes-256-gcm"));
        $tag = "";
        $encryptedstring = openssl_encrypt($plaintext, "aes-256-gcm", $key, OPENSSL_RAW_DATA, $iv, $tag, "", 16);
        return $encoding == "hex" ? bin2hex($keysalt . $iv . $encryptedstring . $tag) : ($encoding == "base64" ? base64_encode($keysalt . $iv . $encryptedstring . $tag) : $keysalt . $iv . $encryptedstring . $tag);
    }
}



function app_output_buffer()
{

    // set cookie for video access from subdomain
    if (is_user_logged_in() && !isset($_COOKIE["_2bc_user"])) {
        $val = str_encryptaesgcm("PLAIN TEXT", "PASSWORD");
        $time = time() + (60 * 60 * 6);
        setcookie("_2bc_user", $val, $time, "/", '.2bytecode.in');
    }
    ob_start();
    date_default_timezone_set('Asia/Calcutta');
}
add_action('init', 'app_output_buffer', 1);



function app_output_buffer_admin()
{
    // set cookie for functionality access from subdomain
    if (!isset($_COOKIE["_2bc_admin"])) {
        $val = str_encryptaesgcm("PLAIN TEXT", "PASSWORD");
        $time = time() + (60 * 60 * 6);
        setcookie("_2bc_admin", $val, $time, "/", '.2bytecode.in');
    }
}

add_action('admin_init', 'app_output_buffer_admin', 1);


function remove_2bc_video_cookies()
{
    if (isset($_COOKIE["_2bc_admin"])) {
        unset($_COOKIE["_2bc_admin"]);
        setcookie("_2bc_admin", null, time() - 3600, "/", '.2bytecode.in');
    }
    if (isset($_COOKIE["_2bc_user"])) {
        unset($_COOKIE["_2bc_user"]);
        setcookie("_2bc_user", null, time() - 3600, "/", '.2bytecode.in');
    }
}
add_action('wp_logout', 'remove_2bc_video_cookies');







add_filter('body_class', 'tbc_add_body_class');
function tbc_add_body_class($classes)
{
    if (is_page(get_page_by_path("signup")->ID))
        $classes[] = 'signup-page';

    return $classes;
}




// signup
add_shortcode('wc_reg_form_tbc', 'tbc_separate_registration_form');

function tbc_separate_registration_form()
{
    if (is_admin()) return;
    if (is_user_logged_in()) {
        wp_redirect(get_permalink(get_page_by_path('dashboard')), 301);
        exit();
    }

?>

    <div class="signup-container">
        <div class="signup-wrapper">
            <div class="sec-1">
                <div class="sec-container">
                    <h3>Grab Your</h3>
                    <img src="<?php echo get_template_directory_uri() . '/images/auth-banner.jpeg' ?>">
                    <h3>Free Course</h3>
                </div>
            </div>




            <div class="sec-2">
                <div class="sec-container">
                    <?php
                    ob_start();

                    // NOTE: THE FOLLOWING <FORM></FORM> IS COPIED FROM woocommerce\templates\myaccount\form-login.php
                    // IF WOOCOMMERCE RELEASES AN UPDATE TO THAT TEMPLATE, YOU MUST CHANGE THIS ACCORDINGLY

                    do_action('woocommerce_before_customer_login_form');

                    ?>
                    <div class="textWarp">
                        <p class="lead pb-0 mb-0">SIGN UP To</p>
                        <h2>2ByteCode</h2>
                    </div>
                    <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action('woocommerce_register_form_tag'); ?>>

                        <?php do_action('woocommerce_register_form_start'); ?>

                        <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                <label for="reg_username"><?php esc_html_e('Username', 'woocommerce'); ?> <span class="required">*</span></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine 
                                                                                                                                                                                                                                                                                ?>
                            </p>

                        <?php endif; ?>


                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">

                            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" placeholder="Email Address" value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine 
                                                                                                                                                                                                                                                                                            ?>
                        </p>

                        <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">

                                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" placeholder="Password" />
                            </p>

                        <?php else : ?>

                            <p><?php esc_html_e('A password will be sent to your email address.', 'woocommerce'); ?></p>

                        <?php endif; ?>

                        <?php do_action('woocommerce_register_form'); ?>

                        <p class="woocommerce-FormRow form-row">
                            <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>

                            <button type="submit" class="w-100 btn btn-primary woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e('Sign Up', '2bytecode'); ?>"><?php esc_html_e('SIGN UP', 'woocommerce'); ?></button>

                        </p>

                        <?php do_action('woocommerce_register_form_end'); ?>

                    </form>

                    <div class="social-log-sign-btns mt-2 mb-5">
                        <fieldset>
                            <legend>OR</legend>
                            <button class="d-flex justify-content-center align-items-center m-auto text-center mb-3" id="google-login" data-nonce="<?php echo wp_create_nonce("SocialLogin2BC"); ?>"><i class="bi bi-google"></i> <span class="align-middle">&nbsp; Continue with Google</span></button>
                            <button class="d-flex justify-content-center align-items-center m-auto text-center" id="facebook-login" data-nonce="<?php echo wp_create_nonce("SocialLogin2BC"); ?>"><i class="bi bi-facebook"></i> <span class="align-middle">&nbsp; Continue with Facebook</span></button>
                        </fieldset>
                    </div>
                </div>
            </div>


        </div>
    </div>
<?php

    return ob_get_clean();
}


/**
 * To add WooCommerce registration form custom fields.
 */

function text_domain_woo_reg_form_fields()
{
?>
    <p class="form-row form-row-first">
        <input type="text" class="input-text" name="billing_full_name" id="billing_full_name" placeholder="Full Name" value="<?php if (!empty($_POST['billing_full_name'])) esc_attr_e($_POST['billing_full_name']); ?>" />
    </p>
    <div class="clear"></div>
<?php
}

add_action('woocommerce_register_form_start', 'text_domain_woo_reg_form_fields');


/**
 * To validate WooCommerce registration form custom fields.
 */
function text_domain_woo_validate_reg_form_fields($username, $email, $validation_errors)
{
    if (isset($_POST['billing_full_name']) && empty($_POST['billing_full_name'])) {
        $validation_errors->add('billing_full_name_error', __('<strong>Error</strong>: Full name is required!', '2bytecode'));
    }

    return $validation_errors;
}

add_action('woocommerce_register_post', 'text_domain_woo_validate_reg_form_fields', 10, 3);


/**
 * To save WooCommerce registration form custom fields.
 */
function text_domain_woo_save_reg_form_fields($customer_id)
{
    //Full name field
    if (isset($_POST['billing_full_name'])) {
        $fullname = explode(" ", trim(sanitize_text_field($_POST['billing_full_name'])), 2);


        update_user_meta($customer_id, 'first_name', $fullname[0]);
        update_user_meta($customer_id, 'billing_first_name', $fullname[0]);

        update_user_meta($customer_id, 'last_name', $fullname[1]);
        update_user_meta($customer_id, 'billing_last_name', $fullname[1]);
    }
}

add_action('woocommerce_created_customer', 'text_domain_woo_save_reg_form_fields');











// add dart code block

function tbc_dart_code_block()
{
    wp_enqueue_script(
        'tbc-dart-code-block',
        plugin_dir_url(__FILE__) . '/assets/js/dart-block.js',
        array('wp-blocks', 'wp-editor'),
        true
    );

    wp_enqueue_script(
        'tbc-faq-block',
        plugin_dir_url(__FILE__) . '/assets/js/faqq-block.js',
        array('wp-blocks', 'wp-editor'),
        true
    );
}

add_action('enqueue_block_editor_assets', 'tbc_dart_code_block');













function tbc_contactus_response_send_mail($id, $name, $email, $message)
{

    $send_to = get_option('admin_email');
    $subject = "New Ticket: " . $id;
    $all_message = "Ticket ID: " . $id . " \n\n Name: " . $name . " \n\n Email: " . $email . "\n\n Message: \n\n" . $message;

    wp_mail($send_to, $subject, $all_message);
}














// contact us  -- about page


function tbc_contactus_response_content_callback()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'contactus_responses';
    $email = sanitize_text_field($_POST['email']);
    $name = sanitize_text_field($_POST['name']);
    $message = sanitize_text_field($_POST['message']);
    $nonce = sanitize_text_field($_POST['nonce']);

    if (is_email($email) && wp_verify_nonce($nonce, 'contact_us_n5566_action') && $wpdb->insert($table_name, array('Name' => $name, "Email" => $email, "Message" => $message))) {
        $response['success'] = true;
        $ticket_no = $wpdb->insert_id;
    } else {
        $response['success'] = false;
    }

    wp_send_json($response);
    tbc_contactus_response_send_mail($ticket_no, $name, $email, $message);
}

add_action('wp_ajax_tbc_contactus_response_content', 'tbc_contactus_response_content_callback');
// not logged in users to be allowed to use this function as well
add_action('wp_ajax_nopriv_tbc_contactus_response_content', 'tbc_contactus_response_content_callback');






// newsletter

function ns8888_get_newsletter_response_content_callback()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_emails';
    $ns_email = sanitize_text_field($_POST['newsletter_email']);
    $nonce = sanitize_text_field($_POST['nonce']);

    if (is_email($ns_email) && wp_verify_nonce($nonce, 'add_newsletter8434_action') && $wpdb->insert($table_name, array('Email' => $ns_email))) {
        $response['success'] = true;
        $ticket_no = $wpdb->insert_id;
    } else {
        $response['success'] = false;
    }

    wp_send_json($response);
}

add_action('wp_ajax_ns8888_get_newsletter_response_content', 'ns8888_get_newsletter_response_content_callback');
// not logged in users to be allowed to use this function as well
add_action('wp_ajax_nopriv_ns8888_get_newsletter_response_content', 'ns8888_get_newsletter_response_content_callback');





function tbc_strEncrypt($str)
{
    $ciphering = "AES-128-CTR";
    $iv_len = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_iv = '1234567891012111';
    $pass = "54387fb83a9895988b3b3cdc5dee2699";
    return openssl_encrypt($str, $ciphering, $pass, $options, $encryption_iv);
}


function tbc_strDecrypt($str)
{
    $ciphering = "AES-128-CTR";
    $iv_len = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_iv = '1234567891012111';
    $pass = "54387fb83a9895988b3b3cdc5dee2699";
    return openssl_decrypt($str, $ciphering, $pass, $options, $encryption_iv);
}


// quiz certificate
function quiz_certificate_2bc_callback()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'quiz_certificate';
    $email = sanitize_text_field($_POST['cer-email']);
    $name = sanitize_text_field($_POST['cer-name']);
    $level = sanitize_text_field($_POST['level']);
    $nonce = sanitize_text_field($_POST['nonce']);

    include 'quiz-certificate.php';

    $UniqueID = tbc_strEncrypt(date('Y-m-d H:i:s'));

    if (is_email($email) && wp_verify_nonce($nonce, 'quizCertificateDownload2BC')) {
        $result = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table_name} WHERE Email=%s", $email));
        if ($result) {
            $response = createPDF($result->Name, $result->Email, $result->Level, $result->UniqueID);
        } else if (!$result && $wpdb->insert($table_name, array('Name' => $name, 'Email' => $email, 'Level' => $level, "UniqueID" => $UniqueID))) {
            $response = createPDF($name, $email, $level, $UniqueID);
        } else {
            $response['success'] = false;
            $response['data'] = "<h4 style='color:rgb(12,12,12)'>Error!</h4><br><p>Unable to save data</p>";
        }
    } else {
        $response['success'] = false;
        $response['data'] = "<h4 style='color:rgb(12,12,12)'>Error!</h4><br><p>Please enter valid email address.</p>";
    }
    wp_send_json($response);
}

add_action('wp_ajax_quiz_certificate_2bc', 'quiz_certificate_2bc_callback');
// not logged in users to be allowed to use this function as well
add_action('wp_ajax_nopriv_quiz_certificate_2bc', 'quiz_certificate_2bc_callback');







// database

function twobytecode_create_required_database()
{
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    // $tblname = 'newsletter_emails';
    $wp_track_table = $wpdb->prefix . "newsletter_emails";

    if ($wpdb->get_var("show tables like '$wp_track_table'") != $wp_track_table) {
        $sql = "CREATE TABLE IF NOT EXISTS $wp_track_table (
            `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `Email` varchar(80) NOT NULL,
            PRIMARY KEY (`ID`)
           ) $charset_collate;";

        dbDelta($sql);
    }


    $wp_track_table = $wpdb->prefix . "contactus_responses";

    if ($wpdb->get_var("show tables like '$wp_track_table'") != $wp_track_table) {
        $sql = "CREATE TABLE IF NOT EXISTS $wp_track_table (
            `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `Name` varchar(250) NOT NULL,
            `Email` varchar(250) NOT NULL,
            `Message` varchar(254) NOT NULL,
            PRIMARY KEY (`ID`)
           ) $charset_collate;";

        dbDelta($sql);
    }


    // quiz - name , email
    $wp_track_table = $wpdb->prefix . "quiz_certificate";

    if ($wpdb->get_var("show tables like '$wp_track_table'") != $wp_track_table) {
        $sql = "CREATE TABLE IF NOT EXISTS $wp_track_table (
            `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `Name` varchar(100) NOT NULL,
            `Email` varchar(100) NOT NULL,
            `Level` varchar(25) NOT NULL,
            `UniqueID` varchar(255) NOT NULL,
            PRIMARY KEY (`ID`)
           ) $charset_collate;";

        dbDelta($sql);
    }


    // course certificate
    $wp_track_table = $wpdb->prefix . "course_certificate";

    if ($wpdb->get_var("show tables like '$wp_track_table'") != $wp_track_table) {
        $sql = "CREATE TABLE IF NOT EXISTS $wp_track_table (
                `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `UserID` BIGINT(20) NOT NULL ,
                `CourseID` varchar(25) NOT NULL,
                `UniqueID` varchar(255) NOT NULL,
                PRIMARY KEY (`ID`)
               ) $charset_collate;";

        dbDelta($sql);
    }


    $wp_track_table = $wpdb->prefix . "course_quiz";

    if ($wpdb->get_var("show tables like '$wp_track_table'") != $wp_track_table) {
        $sql = "CREATE TABLE IF NOT EXISTS $wp_track_table (
                `ID` INT NOT NULL AUTO_INCREMENT , 
                `CourseID` INT NOT NULL , 
                `QNumber` TINYINT NOT NULL , 
                `Question` VARCHAR(255) NOT NULL , 
                `Answer` VARCHAR(255) NOT NULL , 
                `Option1` VARCHAR(255) NOT NULL , 
                `Option2` VARCHAR(255) NOT NULL , 
                `Option3` VARCHAR(255) NOT NULL , 
                `Option4` VARCHAR(255) NOT NULL , 
                PRIMARY KEY (`ID`)
               ) $charset_collate;";

        dbDelta($sql);
    }


    $wp_track_table = $wpdb->prefix . "course_quiz_response";

    if ($wpdb->get_var("show tables like '$wp_track_table'") != $wp_track_table) {
        $sql = "CREATE TABLE IF NOT EXISTS $wp_track_table (
                `ID` INT NOT NULL AUTO_INCREMENT , 
                `Score` VARCHAR(30) NOT NULL , 
                `UserID` BIGINT(20) NOT NULL , 
                `CourseID` INT NOT NULL , 
                PRIMARY KEY (`id`)
               ) $charset_collate;";

        dbDelta($sql);
    }
}

register_activation_hook(__FILE__, 'twobytecode_create_required_database');










// remove website field from comment form
add_filter('comment_form_default_fields', 'comment_website_remove');
function comment_website_remove($fields)
{
    if (isset($fields['url']))
        unset($fields['url']);
    return $fields;
}

add_filter('comment_form_default_fields', 'wc_comment_form_change_cookies');
function wc_comment_form_change_cookies($fields)
{
    $commenter = wp_get_current_commenter();

    $consent   = empty($commenter['comment_author_email']) ? '' : ' checked="checked"';

    $fields['cookies'] = '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' .
        '<label for="wp-comment-cookies-consent">' . __('Remember Me', 'twobytecode') . '</label></p>';
    return $fields;
}



// comment on the courses or lesson
// function comments_on_courses_or_lesson($data)
// {
//     if ($data['post_type'] == 'courses' ||  $data['post_type'] == 'lesson') {
//         $data['comment_status'] = 'open';
//     }

//     return $data;
// }
// add_filter('wp_insert_post_data', 'comments_on_courses_or_lesson');


// login redirect shortcode
function twobyte_redirect_login_function()
{
    $mypost = get_page_by_path('dashboard', '', 'page');
    // echo $mypost->ID;
    wp_redirect(get_permalink($mypost->ID));
    exit;
}
add_shortcode('twobyte_redirect_login', 'twobyte_redirect_login_function');






// add login btn

add_filter('wp_nav_menu_items', 'add_login_icon_dropdown', 10, 2);
function add_login_icon_dropdown($items, $args)
{

    //    $items .= '<li class="menu-item theme-btn-2"><i class="bi bi-brightness-high-fill" onclick="toggleTheme(this);"></i></li>';
    $items .= '<li class="menu-item theme-btn"><span onclick="toggleTheme(this);"></span></li>';

    if (is_user_logged_in()) {
        $items .= '<li class="menu-item menu-item-type-post_type menu-item-object-page dropdown-section nav-login-signup-dropdown" >
    <a class="nav-link dropdown-toggle" href="#" id="headerMenuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="bi bi-person-circle"></i>
  </a>
  <ul class="dropdown-menu px-2" aria-labelledby="headerMenuDropdown">
    <li><a class="dropdown-item px-2" href="' . get_permalink(get_page_by_path('dashboard', '', 'page')->ID) . '">My Account</a></li>
    <li><a class="dropdown-item px-2" href="' . wp_logout_url(home_url()) . '">Logout</a></li>
  </ul>
  </li>
  <li class="menu-item nav-login-signup-btns">
  <a role="button" href="' . get_permalink(get_page_by_path('dashboard', '', 'page')->ID) . '" class="btn btn-primary px-5 py-2">Account</a>
  <a role="button" href="' . wp_logout_url(home_url()) . '" class="btn btn-outline-primary px-5 py-2">Logout</a>
  </li>
  ';
    } else {
        $items .= '<li class="menu-item menu-item-type-post_type menu-item-object-page dropdown-section nav-login-signup-dropdown" >
    <a class="nav-link dropdown-toggle" href="#" id="headerMenuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="bi bi-person-circle"></i>
  </a>
  <ul class="dropdown-menu px-2" aria-labelledby="headerMenuDropdown">
    <li><a class="dropdown-item px-2" href="' . get_permalink(get_page_by_path('dashboard', '', 'page')->ID) . '">Login</a></li>
    <li><a class="dropdown-item px-2" href="' . get_permalink(get_page_by_path('signup', '', 'page')->ID) . '">Sign Up</a></li>
  </ul>
  </li>

  <li class="menu-item nav-login-signup-btns">
  <a role="button" href="' . get_permalink(get_page_by_path('dashboard', '', 'page')->ID) . '" class="btn btn-outline-primary px-5 py-2">Login</a>
  <a role="button" href="' . get_permalink(get_page_by_path('signup', '', 'page')->ID) . '" class="btn btn-primary px-5 py-2">Sign Up</a>
  </li>
  ';
    }

    return $items;
}








// social login

// add sdk library
require_once 'google-api/vendor/autoload.php';
require_once 'Facebook/autoload.php';


// generate login link
add_action('wp_ajax_tbc_social_login_link', 'tbc_social_login_generate_link');
// not logged in users to be allowed to use this function as well
add_action('wp_ajax_nopriv_tbc_social_login_link', 'tbc_social_login_generate_link');


function tbc_social_login_generate_link()
{

    // google config
    $gClient = new Google_Client();
    $gClient->setClientId("CLIENT ID");
    $gClient->setClientSecret("CLIENT SECRET");
    $gClient->setApplicationName("YOUR APP NAME");
    $gClient->setRedirectUri(admin_url("admin-ajax.php?action=twobytecode_login_google"));
    $gClient->addScope("https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email");

    // facebook config
    $FBObject = new \Facebook\Facebook([
        'app_id' => 'APP ID',
        'app_secret' => 'APP SECRET',
        'default_graph_version' => 'v2.10'
    ]);
    $handler = $FBObject->getRedirectLoginHelper();


    $type = sanitize_text_field($_POST["type"]);
    $nonce = sanitize_text_field($_POST["nonce"]);

    if (!wp_verify_nonce($nonce, 'SocialLogin2BC')) {
        $response["success"] = false;
        $response["message"] = "invalid nonce";
        wp_send_json($response);
        exit;
    }

    if ($type == "google-login") {
        $auth_link = $gClient->createAuthUrl(); // google

    } else {
        $link = admin_url('admin-ajax.php?action=twobytecode_facebook_login');
        $redirect_to = $link;
        $data = ["email"];
        $auth_link = $handler->getLoginURL($redirect_to, $data); // fb
    }

    $response["success"] = true;
    $response["message"] = $auth_link;
    wp_send_json($response);
}


function tbc_social_after_auth_redirect()
{
    if (isset($_COOKIE["socialAfterRedirect"])) {
        $url = $_COOKIE["socialAfterRedirect"];
        unset($_COOKIE['socialAfterRedirect']);
        setcookie('socialAfterRedirect', null, -1, '/');
        wp_redirect($url);
        exit;
    }
    wp_redirect(get_permalink(get_page_by_path('dashboard', '', 'page')->ID));
    exit;
}


// add google ajax action
add_action('wp_ajax_twobytecode_login_google', 'twobytecode_login_google');
function twobytecode_login_google()
{
    // google config
    $gClient = new Google_Client();
    $gClient->setClientId("CLIENT ID");
    $gClient->setClientSecret("CLIENT SECRET");
    $gClient->setApplicationName("YOUR APP NAME");
    $gClient->setRedirectUri(admin_url("admin-ajax.php?action=twobytecode_login_google"));
    $gClient->addScope("https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email");

    if (isset($_GET['code'])) {
        $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
        if (!isset($token["error"])) {
            // get data from google
            $oAuth = new Google_Service_Oauth2($gClient);
            $userData = $oAuth->userinfo_v2_me->get();
        }

        // check if user email already registered
        if (!email_exists($userData['email'])) {
            // generate password
            $bytes = openssl_random_pseudo_bytes(2);
            $password = md5(bin2hex($bytes));
            $user_login = $userData['id'];


            $new_user_id = wp_insert_user(
                array(
                    'user_login'        => $user_login,
                    'user_pass'             => $password,
                    'user_email'        => $userData['email'],
                    'first_name'        => $userData['givenName'],
                    'last_name'            => $userData['familyName'],
                    'user_registered'    => date('Y-m-d H:i:s'),
                    'role'                => get_option('default_role')
                )
            );
            if ($new_user_id) {
                // send an email to the admin
                wp_new_user_notification($new_user_id);

                // log the new user in
                do_action('wp_login', $user_login, $userData['email']);
                wp_set_current_user($new_user_id);
                wp_set_auth_cookie($new_user_id, true);

                // send the newly created user to the home page after login
                tbc_social_after_auth_redirect();
            }
        } else {
            //if user already registered than we are just loggin in the user
            $user = get_user_by('email', $userData['email']);
            do_action('wp_login', $user->user_login, $user->user_email);
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID, true);
            tbc_social_after_auth_redirect();
        }


        // var_dump($userData);
    } else {
        wp_redirect(get_permalink(get_page_by_path('dashboard', '', 'page')->ID));
        exit();
    }
}










// fb login ajax

add_action("wp_ajax_twobytecode_facebook_login", "twobytecode_facebook_login");
function twobytecode_facebook_login()
{
    // facebook config
    $FBObject = new \Facebook\Facebook([
        'app_id' => 'APP ID',
        'app_secret' => 'APP SECRET',
        'default_graph_version' => 'v2.10'
    ]);
    $handler = $FBObject->getRedirectLoginHelper();


    try {
        $accessToken = $handler->getAccessToken();
    } catch (\Facebook\Exceptions\FacebookResponseException $e) {
        echo "Response Exception: " . $e->getMessage();
        exit();
    } catch (\Facebook\Exceptions\FacebookSDKException $e) {
        echo "SDK Exception: " . $e->getMessage();
        exit();
    }

    if (!$accessToken) {
        wp_redirect(home_url());
        exit;
    }

    $oAuth2Client = $FBObject->getOAuth2Client();
    if (!$accessToken->isLongLived())
        $accessToken = $oAuth2Client->getLongLivedAccesToken($accessToken);

    $response = $FBObject->get("/me?fields=id, first_name, last_name, email, picture.type(large)", $accessToken);
    $userData = $response->getGraphNode()->asArray();

    $user_email = $userData['email'];
    // check if user email already registered
    if (!email_exists($user_email)) {

        // generate password
        $bytes = openssl_random_pseudo_bytes(2);
        $password = md5(bin2hex($bytes));
        $user_login = strtolower($userData['first_name'] . $userData['last_name']);


        $new_user_id = wp_insert_user(
            array(
                'user_login'        => $user_login,
                'user_pass'             => $password,
                'user_email'        => $user_email,
                'first_name'        => $userData['first_name'],
                'last_name'            => $userData['last_name'],
                'user_registered'    => date('Y-m-d H:i:s'),
                'role'                => get_option('default_role')
            )
        );
        if ($new_user_id) {
            // send an email to the admin
            wp_new_user_notification($new_user_id);

            // log the new user in
            do_action('wp_login', $user_login, $user_email);
            wp_set_current_user($new_user_id);
            wp_set_auth_cookie($new_user_id, true);

            // send the newly created user to the home page after login
            tbc_social_after_auth_redirect();
        }
    } else {
        //if user already registered than we are just loggin in the user
        $user = get_user_by('email', $user_email);
        do_action('wp_login', $user->user_login, $user->user_email);
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID, true);

        tbc_social_after_auth_redirect();
    }
}



// ALLOW LOGGED OUT users to access admin-ajax.php action
function add_social_login_ajax_actions()
{
    add_action('wp_ajax_nopriv_twobytecode_login_google', 'twobytecode_login_google');
    add_action('wp_ajax_nopriv_twobytecode_facebook_login', 'twobytecode_facebook_login');
}
add_action('admin_init', 'add_social_login_ajax_actions');





// about-us

add_shortcode('about-us-page', 'twobytecode_about_us_content');

function twobytecode_about_us_content()
{
    ob_start();
    include "about-us-content.php";
    $pagecontent = ob_get_clean();
    return $pagecontent;
}

// freelance page ~ hire us
add_shortcode('freelance-page', 'twobytecode_freelance_content');
function twobytecode_freelance_content()
{
    ob_start();
    include "freelance-content.php";
    $pagecontent = ob_get_clean();
    return $pagecontent;
}

// quiz page
add_shortcode('quiz-page', 'twobytecode_quiz_content');
function twobytecode_quiz_content()
{
    ob_start();
    include "quiz-content.php";
    $pagecontent = ob_get_clean();
    return $pagecontent;
}

// docs page
add_shortcode('docs-page', 'twobytecode_docs_page_content');
function twobytecode_docs_page_content()
{
    ob_start();
    include "docs-page-content.php";
    $pagecontent = ob_get_clean();
    return $pagecontent;
}


// course launch page
add_shortcode('course-launch-page', 'twobytecode_course_launch_page_content');
function twobytecode_course_launch_page_content()
{
    ob_start();
    include "course-launch-content.php";
    $pagecontent = ob_get_clean();
    return $pagecontent;
}



add_shortcode('course-quiz-page', 'twobytecode_course_quiz_page_content');
function twobytecode_course_quiz_page_content()
{
    ob_start();
    include "course-quiz.php";
    $pagecontent = ob_get_clean();
    return $pagecontent;
}


// api
add_action('wp_ajax_course_quiz_response', 'course_quiz_response_callback');
function course_quiz_response_callback()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'course_quiz_response';

    $answer = sanitize_text_field($_POST['Answer']);
    $userans = sanitize_text_field($_POST['Userans']);

    $code = sanitize_text_field($_POST['Code']);
    $qnumber = (int)sanitize_text_field($_POST['QNumber']);
    $course = sanitize_text_field($_POST['CourseID']);
    $nonce = sanitize_text_field($_POST['Nonce']);

    if (empty($answer) || empty($userans) || empty($code) || empty($qnumber) || !is_numeric($qnumber) || empty($course) || !is_numeric($course) || empty($nonce)) {
        wp_send_json([
            "status" => 0, // error
            "message" => "All parameters are required"
        ]);
        die();
    }

    if (!wp_verify_nonce($nonce, "twobytecode_course_quiz")) {
        wp_send_json([
            "status" => 0, // error
            "message" => "Unable to verify nonce"
        ]);
        die();
    }

    $is_enrolled = tutor_utils()->is_enrolled($course);
    if (!$is_enrolled) {
        wp_send_json([
            "status" => 0, // error
            "message" => "You have'nt enrolled for this course"
        ]);
        die();
    }


    // process

    $code = tbc_strDecrypt($code);
    $code = json_decode($code, true);
    $answer = tbc_strDecrypt($answer);

    if($answer == $userans){
        $code[$qnumber] = 1;
    }else{
        $code[$qnumber] = 0;
    }
    
    // next 
    echo $qnumber = $qnumber + 1;
    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE (CourseID=$course AND QNumber=$qnumber)");
    if (!$result) {
        // submit final
        die("no result");
    }

    $ans = tbc_strEncrypt($result[0]->Answer);
    $result[0]->Answer = $ans;
    $result[0]->Nonce = wp_create_nonce("twobytecode_course_quiz");
    $code = json_encode($code);
    $result[0]->Code = tbc_strEncrypt($code);



    wp_send_json(
        [
            "type" => 1,
            "result" => $result[0]
        ]
    );

}






add_action('wp_ajax_course_quiz_response_init', 'course_quiz_response_init_callback');
function course_quiz_response_init_callback()
{

    $course = (int)sanitize_text_field($_POST['course']);
    $is_enrolled = tutor_utils()->is_enrolled($course);
    if (!$is_enrolled) {
        wp_send_json([
            "status" => 0, // error
            "message" => "You have'nt enrolled for this course"
        ]);
        die();
    }

    global $wpdb;
    $result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}course_quiz WHERE (CourseID=$course AND QNumber=1)");
    if (!$result) {
        wp_send_json(
            [
                "status" => 0,
                "message" => "No quesion found"
            ]
        );
    }

    $ans = tbc_strEncrypt($result[0]->Answer);
    $result[0]->Answer = $ans;

    $result[0]->Nonce = wp_create_nonce("twobytecode_course_quiz");

    $code = [1 => 0];
    $code = json_encode($code);
    $result[0]->Code = tbc_strEncrypt($code);

    wp_send_json(
        [
            "type" => 1,
            "result" => $result[0]
        ]
    );
    
}




