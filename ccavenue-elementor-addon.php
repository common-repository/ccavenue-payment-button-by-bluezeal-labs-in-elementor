<?php
defined('ABSPATH') || exit;

/**
 * Plugin Name: CCAvenue Payment Button by BlueZeal Labs in Elementor
 * Plugin URI: https://bluezeal.in/ * 
 * Description: Upgrade your WordPress experience with the CCAvenue Payment Gateway Plugin, seamlessly integrated with Elementor. 
 * Version:     1.0.0
 * Requires at least: 4.7
 * Tested up to: 6.4.4
 * Author:      BlueZeal Labs
 * Author URI:  https://bluezeal.in/
 * License: GPLv3
 * Text Domain: ele_cc_ave
 */


include_once ABSPATH . 'wp-admin/includes/plugin.php';

define('ELE_CC_AVE_PLUGIN_FILE', __FILE__);

// check for plugin using plugin name
if (!is_plugin_active('elementor/elementor.php')) {
    add_action('admin_notices', function () {
?>
        <div class="error notice">
            <?php echo esc_html('Sorry Elementor plugin is required to be installed and active for use of CCAvenue Payment Button by BlueZeal Labs in Elementor', 'ele_cc_ave'); ?>
        </div>
<?php
        deactivate_plugins(plugin_basename(ELE_CC_AVE_PLUGIN_FILE));
    });
} else {

    require_once(__DIR__ . '/helpers.php');


    function ele_cc_ave_register_ccavennue_payment_button_widget($widgets_manager)
    {

        require_once(__DIR__ . '/widgets/cc-avenue-payment-button-widget.php');
        if (class_exists('Ele_Cc_Ave_Cc_Avenue_Payment_btn')) {
            $widgets_manager->register(new \Ele_Cc_Ave_Cc_Avenue_Payment_btn());
        }
    }

    add_action('elementor/widgets/register', 'ele_cc_ave_register_ccavennue_payment_button_widget');


    function ele_cc_ave_frontend_stylesheets()
    {
        wp_register_style('ele_cc_ave_front_style', plugin_dir_url(ELE_CC_AVE_PLUGIN_FILE) . 'style.css?t=' . time());
        wp_enqueue_style('ele_cc_ave_front_style');
    }

    add_action('elementor/editor/after_enqueue_styles', 'ele_cc_ave_frontend_stylesheets');



    function ele_cc_ave_process_payment()
    {
        if (
            isset($_GET['payment-ccavenue']) &&
            !empty($_GET['payment-ccavenue']) &&
            isset($_POST['amount']) &&
            filter_var($_POST['amount'], FILTER_VALIDATE_FLOAT)
        ) {
            $merchant_id = esc_html(get_option('ele_cc_ave_merchant_id')); //Shared by CCAVENUES
            $working_key = esc_html(get_option('ele_cc_ave_working_key')); //Shared by CCAVENUES
            $access_code = esc_html(get_option('ele_cc_ave_access_code')); //Shared by CCAVENUES
            $redirect_page = esc_html(get_option('ele_cc_ave_redirect_page'));
            $redirect_url = get_permalink($redirect_page);
            $order_id = time();

            $merchant_data = [
                'tid' => time() * 1000,
                'merchant_id' => $merchant_id,
                'order_id' => $order_id,
                'redirect_url' => $redirect_url,
                'cancel_url' => $redirect_url,
                'amount' => wp_kses_post(sanitize_text_field($_POST['amount'])),
                'currency' => 'INR',
                'language' => 'EN',
            ];
            // print_r($merchant_data);
            // 		die;
            $merchant_data = http_build_query($merchant_data);

            $encrypted_data = ele_cc_ave_encrypt($merchant_data, $working_key);
            $payment_mode = esc_html(get_option('ele_cc_ave_payment_mode', ''));

            /* if ($payment_mode == 'live') {
                '<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction">';
            } else {
                '<form method="post" name="redirect" action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction">';
            }  */

            require_once(__DIR__ . '/proccess_payment_form.php');
            die;
        }

        // print_r($post);
        // die;
        global $post;
        $redirect_page = esc_html(get_option('ele_cc_ave_redirect_page'));

        if ($redirect_page == $post->ID && isset($_POST["encResp"])) {
            // error_reporting(0);
            $working_key = esc_html(get_option('ele_cc_ave_working_key')); //Working Key should be provided here.
            $encResponse = wp_kses_post(sanitize_text_field($_POST["encResp"])); //This is the response sent by the CCAvenue Server
            $rcvdString = ele_cc_ave_decrypt($encResponse, $working_key); //Crypto Decryption used as per the specified working key.
            $order_status = "";
            $decryptValues = explode('&', $rcvdString);
            $dataSize = sizeof($decryptValues);
            for ($i = 0; $i < $dataSize; $i++) {
                $information = explode('=', $decryptValues[$i]);
                if ($i == 3)    $order_status = $information[1];
            }

            if ($order_status === "Success") {
                $alert =  "Thank you, Your transaction is successful.";
            } else if ($order_status === "Aborted") {
                $alert =  "Payment Aborted. Please let us know what goes wrong.";
            } else if ($order_status === "Failure") {
                $alert =  "The transaction has been declined.";
            }

            // $html = ' <div class="cc_ave_response ' . $order_status . '">' . $alert . '</div>';
            require_once(__DIR__ . '/payment_response.php');
        }
    }

    add_action('template_redirect', 'ele_cc_ave_process_payment');


    function ele_cc_ave_admin_menu()
    {
        add_options_page(
            __('Page Title', 'ele_cc_ave'),
            __('Eelementor CCAvenue Payment Button Settings', 'ele_cc_ave'),
            'manage_options',
            'ele_cc_ave_payment_settings',
            'ele_cc_ave_settings_page'
        );
    }

    function ele_cc_ave_settings_page()
    {
        require_once(__DIR__ . '/setting_form.php');
    }

    add_action('admin_menu',  'ele_cc_ave_admin_menu');
}
