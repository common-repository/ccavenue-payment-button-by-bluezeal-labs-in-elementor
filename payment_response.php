<?php
defined('ABSPATH') || exit;
?>

<script>
    var main = document.querySelector('main');

    var div = document.createElement('div');
    div.classList.add('cc_ave_response');
    div.classList.add('<?php echo esc_attr($order_status); ?>');
    div.innerText = '<?php echo esc_attr($alert); ?>';

    main.parentNode.insertBefore(div, main);
    setTimeout(function() {
        div.remove();
    }, 5000);
</script>
<style>
    .cc_ave_response.Aborted {
        background: #f49938;
        padding: 10px 30px;
        border-radius: 6px;
    }

    .cc_ave_response.Failure {
        background: #f43838;
        padding: 10px 30px;
        border-radius: 6px;
        color: #fff;
    }

    .cc_ave_response.Success {
        background: #399505;
        padding: 10px 30px;
        border-radius: 6px;
        color: #fff;
    }
</style>