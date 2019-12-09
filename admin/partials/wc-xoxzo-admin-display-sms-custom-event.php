<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit(0);
}

hidden_fields(Xoxzo::SETTING__CUSTOM_EVENT__SMS);
$replies = wp_cache_get( XOXZO::RESPONSE__CUSTOM_EVENT__SMS.wp_get_current_user()->ID );
$message = "";
if(!empty($replies)) {
    $_replies = json_decode($replies);
    foreach($_replies->error as $key => $reply_list) {
        $message = $message."<div class=\"notice error inline\">";
        $message.="<p><strong>";
        $message.=( ucwords($key).": ". implode("<br>", $reply_list) );
        $message.="</strong></p>";
        $message.="</div>";
    }
    if($_replies->success) {
        $message = $message."<div class=\"updated\">";
        $message.="<p><strong>";
        $message.= implode("<br>", $_replies->success);
        $message.="</strong></p>";
        $message.="</div>";
    }
}
?>

<h2>Sms: custom message</h2>
<?= $message; ?>
<br class="clear">
<table class="form-table">
    <tbody>
    <tr valign="top">
        <th scope="row" class="titledesc">
            <label for="">Recipient(s) <span class="woocommerce-help-tip"></span></label>
        </th>
        <td class="forminp forminp-text">
            <input name="recipients" id="" type="text" style="" value="" class="" placeholder="+60123456789,+6019876543"> 							</td>
    </tr>
    <tr valign="top">
        <th scope="row" class="titledesc">
            <label for="">Message <span class="woocommerce-help-tip"></span></label>
        </th>
        <td class="forminp forminp-textarea">

            <textarea name="message" id="" style="" class="" placeholder=""></textarea>
        </td>
    </tr>
    </tbody>
</table>
<p class="submit send-sms">
    <button name="save" class="button-primary woocommerce-save-button" type="submit" value="Save sms">Send sms</button>
</p>
<style>
    .submit {
        display:none;
    }
    .send-sms {
        display: block;
    }
    .updated.inline {
        display: none;
    }
    .update-nag-custom {
        display:block;
    }
</style>