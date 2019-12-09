<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit(0);
}

/**
 * Proxy the Xoxzo PHP Client send_tts_playback() and send_simple_playback() method.
 *
 * Make it easier to pass authentication value into it, without it being litter all over the codebase.
 *
 * @since 1.0.0
 */
class XoxzoVoiceClient {

    public function sid() {
        return get_option("woocommerce_xoxzo_sid");
    }

    public function auth_token() {
        return get_option("woocommerce_xoxzo_auth_token");
    }

    /**
     * Find the sender_id. Used internally by the object
     *
     * @return string $sender_id
     */
    public function sender_id() {
        $sender_id = get_option("woocommerce_xoxzo_sender_id");
        if(empty($sender_id)) {
            return "Xoxzo";
        }
        else {
            return $sender_id;
        }
    }

    /**
     * Send API request to Xoxzo Telephony Service.
     *
     * @param string $caller The number shown on screen during call
     * @param string $recipient The number receiving the message
     * @param string $message The message being send to the recipient
     *
     * @return object XoxzoResponse object
     */
    public function send_tts_playback($caller, $recipient, $message, $languageLocale) {
        $client = new \xoxzo\cloudphp\XoxzoClient($this->sid(), $this->auth_token());
        return $client->call_tts_playback($caller, $recipient, $message, $languageLocale);
    }

    /**
     * Send API request to Xoxzo Telephony Service.
     *
     * @param string $caller The number shown on screen during call
     * @param string $recipient The number receiving the message
     * @param string $message The message being send to the recipient
     *
     * @return object XoxzoResponse object
     */
    public function send_simple_playback($caller, $recipient, $message) {
        $client = new \xoxzo\cloudphp\XoxzoClient($this->sid(), $this->auth_token());
        return $client->call_simple_playback($caller, $recipient, $message);
    }

}