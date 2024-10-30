<?php
defined('ABSPATH') || exit;

if (isset($_POST['ele_cc_ave_merchant_id'])) {
    $ele_cc_ave_merchant_id = wp_kses_post(sanitize_text_field($_POST['ele_cc_ave_merchant_id']));
    update_option('ele_cc_ave_merchant_id', $ele_cc_ave_merchant_id);
}

if (isset($_POST['ele_cc_ave_working_key'])) {
    $ele_cc_ave_working_key = wp_kses_post(sanitize_text_field($_POST['ele_cc_ave_working_key']));
    update_option('ele_cc_ave_working_key', $ele_cc_ave_working_key);
}

if (isset($_POST['ele_cc_ave_access_code'])) {
    $ele_cc_ave_access_code = wp_kses_post(sanitize_text_field($_POST['ele_cc_ave_access_code']));
    update_option('ele_cc_ave_access_code', $ele_cc_ave_access_code);
}

if (isset($_POST['ele_cc_ave_redirect_page'])) {
    $ele_cc_ave_redirect_page = wp_kses_post(sanitize_text_field($_POST['ele_cc_ave_redirect_page']));
    update_option('ele_cc_ave_redirect_page', $ele_cc_ave_redirect_page);
}

if (isset($_POST['ele_cc_ave_payment_mode'])) {
    $ele_cc_ave_payment_mode = wp_kses_post(sanitize_text_field($_POST['ele_cc_ave_payment_mode']));
    update_option('ele_cc_ave_payment_mode', $ele_cc_ave_payment_mode);
}
?>
<div class="wrap">
    <h1>Eelementor CC Avenue Payment Button Settings</h1>
    <form method="post" action="">
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row"><label for="ele_cc_ave_payment_mode">Payment Mode</label></th>
                    <td>
                        <select name="ele_cc_ave_payment_mode" id="ele_cc_ave_payment_mode">
                            <option value="test" <?php echo esc_attr(get_option('ele_cc_ave_payment_mode', '') == 'test' ? 'selected' : '') ?>>Test</option>
                            <option value="live" <?php echo esc_attr(get_option('ele_cc_ave_payment_mode', '') == 'live' ? 'selected' : '') ?>>Live</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ele_cc_ave_merchant_id">Merchant id</label></th>
                    <td><input name="ele_cc_ave_merchant_id" type="text" id="ele_cc_ave_merchant_id" value="<?php echo esc_attr(get_option('ele_cc_ave_merchant_id', '')) ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="ele_cc_ave_working_key">Working Key</label></th>
                    <td><input name="ele_cc_ave_working_key" type="text" id="ele_cc_ave_working_key" value="<?php echo esc_attr(get_option('ele_cc_ave_working_key', '')) ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="ele_cc_ave_access_code">Access Code</label></th>
                    <td><input name="ele_cc_ave_access_code" type="text" id="ele_cc_ave_access_code" value="<?php echo esc_attr(get_option('ele_cc_ave_access_code', '')) ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="ele_cc_ave_redirect_page">Redirect Page</label></th>
                    <td>
                        <select name="ele_cc_ave_redirect_page" id="ele_cc_ave_redirect_page">
                            <option selected disabled>Please select page</option>
                            <?php
                            $pages = get_pages();
                            $selected = esc_html(get_option('ele_cc_ave_redirect_page', '0'));
                            foreach ($pages as $page) { ?>
                                <option value="<?php echo esc_attr($page->ID); ?>" <?php echo esc_attr($selected == $page->ID ? ' selected' : '') ?>><?php echo esc_html($page->post_title) ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
        </p>

        <div class="ele_cc_ave_copy" style="margin-top: 100px;display: flex;width: 100%;justify-content: center;align-items: center;">
            <b>Copyright by &nbsp;</b>
            <a href="https://bluezeal.in" target="_blank">
                <img src="<?php echo esc_url(plugin_dir_url(ELE_CC_AVE_PLUGIN_FILE) . '/images/bluezeal_labs-copyright.png'); ?>">
            </a>
        </div>
    </form>
</div>