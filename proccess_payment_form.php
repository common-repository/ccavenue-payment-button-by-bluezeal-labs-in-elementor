<?php
defined('ABSPATH') || exit;
?>
<form method="post" name="redirect" action="<?php echo esc_url($payment_mode == 'live' ? 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction' : 'https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction'); ?> ">
    <input type="hidden" name="encRequest" value="<?php echo esc_attr($encrypted_data) ?>">
    <input type="hidden" name="access_code" value="<?php echo esc_attr($access_code) ?>">
</form>
<script language="javascript">
    document.redirect.submit();
</script>