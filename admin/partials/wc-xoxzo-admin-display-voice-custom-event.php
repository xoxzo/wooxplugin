<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit(0);
}

hidden_fields(Xoxzo::SETTING__CUSTOM_EVENT__VOICE);
$replies = wp_cache_get( Xoxzo::RESPONSE__CUSTOM_EVENT__VOICE.wp_get_current_user()->ID );
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

<h2>Voice: custom message</h2>
<?= $message ?>
<br class="clear">
<table class="form-table">
    <tbody><tr valign="top">
        <th scope="row" class="titledesc">
            <label for="">Type <span class="woocommerce-help-tip"></span></label>
        </th>
        <td class="forminp forminp-select">
            <select name="type" id="" style="" class="wc-notification-select">
                <option value="tts">
                    TTS (Text To Speech)</option>
                <option value="playback">
                    Audio Playback</option>
            </select>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row" class="titledesc">
            <label for="caller">Caller <span class="woocommerce-help-tip"></span></label>
        </th>
        <td class="forminp forminp-text">
            <input name="caller" type="text" style="" class="" placeholder="+60123456789 (Required)">
        </td>
    </tr>
    <tr valign="top">
        <th scope="row" class="titledesc">
            <label for="">Recipient(s) <span class="woocommerce-help-tip"></span></label>
        </th>
        <td class="forminp forminp-text">
            <input name="recipients" id="" type="text" style="" value="" class="" placeholder="+60123456789,+6019876543"> 							</td>
    </tr>
    <tr valign="top">
        <th scope="row" class="titledesc">
            <label for="">Playback MP3 location <span class="woocommerce-help-tip"></span></label>
        </th>
        <td class="forminp forminp-textarea">
            <textarea name="playback" id="" style="" class="" placeholder=""></textarea>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row" class="titledesc">
            <label for="">TTS message <span class="woocommerce-help-tip"></span></label>
        </th>
        <td class="forminp forminp-textarea">
            <textarea name="tts" id="" style="" class="" placeholder=""></textarea>
        </td>
    </tr>
    </tbody>
</table>
<p class="submit send-voice">
    <button name="save" class="button-primary woocommerce-save-button" type="submit" value="Save changes">Send voice</button>
    <!--                <input type="hidden" id="_wpnonce" name="_wpnonce" value="1ceb0a470d"><input type="hidden" name="_wp_http_referer" value="/wp-admin/admin.php?page=wc-settings&tab=xoxzo&section=voice-setting-custom-event">-->
</p>
<style>
    .submit {
        display:none;
    }
    .send-voice {
        display: block;
    }
    .updated.inline {
        display: none;
    }
    .update-nag-custom {
        display:block;
    }
</style>