<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit(0);
}

/**
 * Automatically handle the Xoxzo response based on success or error API request
 *
 * @since 1.0.0
 */
class XoxzoSmsResponse {

    /**
     * Proxy the sending of Xoxzo message. Save the response in an appropriate format if successful or error.
     *
     * @since 1.0.0
     *
     * @param string $recipient The number receiving the message
     * @param string $message The message being send to the recipient
     * @param string $stub_message The $message being filtered before saving into database
     * @param string $current_filter The context(WordPress hook) of this send() method being run.
     * @param string $event_name The event string name. Must be stated in Xoxzo::parse_event_name()
     * @return boolean
     */
    public function send(
        $recipient,
        $message,
        $stub_message,
        $current_filter,
        $event_name
    ) {
        $client = (new \XoxzoSmsClient);
        $resp = $client->send($recipient, $message);
        if($this->is_error($resp, $current_filter, $stub_message, $recipient, $client->sender_id())) {
            return false;
        }
        $data = $this->get($resp, $stub_message, $event_name);
        return $this->save($data);
    }

    public function send_custom_event() {
        $recipients = "";
        $message = "";
        if(isset($_POST['recipients']) and !empty($_POST['recipients'])) {
            $recipients = array();
            foreach(explode(",", $_POST["recipients"]) as $recipient) {
                $recipients[] = sanitize_text_field(trim($recipient));
            }
        }
        if(isset($_POST['message']) and !empty($_POST['message'])) {
            $message = sanitize_text_field($_POST["message"]);
        }

        $replies = [
            'error' => [],
            'success' => [],
        ];
        $client = (new \XoxzoSmsClient);
        foreach($recipients as $recipient) {
            $resp = $client->send($recipient, $message);
            if($this->is_error($resp, \Xoxzo::HOOK__SMS__CUSTOM_EVENT, $message, $recipient, $client->sender_id())) {
                foreach($resp->messages as $key => $error_message) {
                    $replies['error'][$key] = $error_message;
                }
            }
            else {
                $data = $this->get($resp, $message, \Xoxzo::HOOK__SMS__CUSTOM_EVENT);
                $this->save($data);
                $replies['success'][] = "Sms sent to $recipient";
            }
        }
        wp_cache_set( XOXZO::RESPONSE__CUSTOM_EVENT__SMS.wp_get_current_user()->ID, json_encode($replies) );
    }

    /**
     * Create a list contain the relevant information of an API request. Typically used to store in database.
     *
     * @since 1.0.0
     *
     * @param string $response The response object from the Xoxzo PHP Client
     * @param string $stub_message The message being saved into database
     * @param string $event_name The event tag to be saved into database
     * @return array Refer to Xoxzo sms documentation for the meaning of some of the keys
     */
    public function get($response, $stub_message, $event_name) {

        $msgid = -1;
        if($response->messages[0]->msgid) {
            $msgid = $response->messages[0]->msgid;
        }

        $data = $this->fetch_status($msgid);
        if(isset($data["msgid"])) {
            return array(
                "event" => $event_name,
                "message" => $stub_message,
                "msgid" => isset($data["msgid"]) ? $data["msgid"]: "",
                "sender" => isset($data["sender"]) ? $data["sender"]: "",
                "sent_time" => isset($data["sent_time"]) ? $data["sent_time"]: "",
                "cost" => isset($data["cost"]) ? $data["cost"]: "",
                "url" => isset($data["url"]) ? $data["url"]: "",
                "status" => isset($data["status"]) ? $data["status"]: "",
                "recipient" => isset($data["recipient"]) ? $data["recipient"]: "",
            );
        }
        else {
            return array(
                "event" => $event_name,
                "message" => $stub_message,
                "msgid" => $msgid,
                "sender" => "",
                "sent_time" => "",
                "cost" => "",
                "url" => "",
                "status" => "",
                "recipient" => "",
            );
        }
    }

    /**
     * Check if the response object receiving is an error response, then save it into database.
     *
     * @since 1.0.0
     *
     * @param \xoxzo\cloudphp\XoxzoResponse $response The response object from the Xoxzo PHP Client
     * @param string $current_filter_event The event tag, using the current_filter() as a basis
     * @param string $stub_message The stub message to be saved into database
     * @param string $recipient The recipient phone number
     * @param string $sender The sender id used in the sms request
     * @return boolean
     */
    public function is_error($response, $current_filter_event, $stub_message, $recipient, $sender) {
        if($response->errors) {

            $tablename = (new \Xoxzo)->table_name__error();

            global $wpdb;
            $result = $wpdb->insert($tablename, array(
                "notification_type" => "sms",
                "event" => $current_filter_event,
                "error_code" => $response->errors,
                "error_message" => json_encode($response->messages),
                "recipient" => $recipient,
                "message" => $stub_message,
                "sender" => $sender,
                "created_at" => date('Y-m-d H:i:s', time()),
            ));

            return $result;
        }
        return false;
    }

    /**
     * Save response object receiving as a success response, used in conjunction with self::is_error() as guard.
     *
     * @since 1.0.0
     *
     * @param  array $data Fetch the data using self::get()
     * @return boolean
     */
    private function save($data) {
        $tablename = (new \Xoxzo)->table_name__status();

        global $wpdb;
        $result = $wpdb->insert($tablename, array(
            "notification_type" => "sms",
            "event" => $data["event"],
            "message" => $data["message"],
            "msgid_callid" => $data["msgid"],
            "sender" => $data["sender"],
            "cost" => $data["cost"],
            "status" => $data["status"],
            "recipient" => $data["recipient"],
            "url" => $data["url"],
            "sent_time" => $data["sent_time"],
            "created_at" => date('Y-m-d H:i:s', time()),
        ));

        return $result;
    }

    /**
     * HTTP call to check delivery status of each Xoxzo API request.
     *
     * @since 1.0.0
     *
     * @param  string $msgid The message id request. Refer Xoxzo Docs for more information.
     * @return string|array String is error. Array for response
     */
    private function fetch_status($msgid) {


        $client = (new \XoxzoSmsClient);

        $url = "https://api.xoxzo.com/sms/messages/{$msgid}/";
        $encodedAuth = base64_encode($client->sid().":".$client->auth_token());

        $response = wp_remote_request( $url,
            array(
                "headers" => array(
                    "Authorization" => "Basic ".$encodedAuth
                ),
                "method" => "GET",
            )
        );

        //Check for success
        if(!is_wp_error($response) && ($response['response']['code'] == 200 || $response['response']['code'] == 201)) {
            $result = json_decode($response['body'], true);
            if(json_last_error()) {
                return json_last_error_msg();
            }
            return $result;
        }
        else {
            return $response['body'];
        }
    }
}