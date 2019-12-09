<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit(0);
}

/**
 * Proxy the Xoxzo PHP Client send() method.
 *
 * Make it easier to pass authentication value into it, without it being litter all over the codebase.
 *
 * @since 1.0.0
 */
class XoxzoSmsClient {

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
     * @param string $recipient The number receiving the message
     * @param string $message The message being send to the recipient
     *
     * @return object XoxzoResponse object
     */
    public function send($recipient, $message) {
        $client = new \xoxzo\cloudphp\XoxzoClient($this->sid(), $this->auth_token());
        return $client->send_sms($message, $recipient, $this->sender_id());
    }
}