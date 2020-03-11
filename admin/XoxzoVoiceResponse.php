<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit(0);
}

/**
 * Automatically handle the Xoxzo response based on success or error API request
 *
 * @since 1.0.0
 */
class XoxzoVoiceResponse {

    /**
     * Proxy the sending of Xoxzo message. Save the response in an appropriate format if successful or error.
     *
     * @since 1.0.0
     *
     * @param string $recipient The number receiving the message
     * @param string $message The message being send to the recipient
     * @param string $stub_message The $message being filtered before saving into database
     * @param string $caller The caller that is shown on screen when calling recipient
     * @param string $languageLocale The string used to identify the language of the message sent.
     * @param string $current_filter The context(WordPress hook) of this send() method being run.
     * @param string $event_name The event string name. Must be stated in Xoxzo::parse_event_name()
     * @return boolean
     */
    public function send_tts(
        $recipient,
        $message,
        $stub_message,
        $caller,
        $languageLocale,
        $current_filter,
        $event_name
    ) {
        $client = (new \XoxzoVoiceClient);
        $resp = $client->send_tts_playback($caller, $recipient, $message, $languageLocale);
        if($this->is_error($resp, $current_filter, $stub_message, $recipient, $client->sender_id())) {
            return false;
        }
        $data = $this->get($resp, $message, $event_name);
        return $this->save($data);
    }

    /**
     * Proxy the sending of Xoxzo message. Save the response in an appropriate format if successful or error.
     *
     * @since 1.0.0
     *
     * @param string $recipient The number receiving the message
     * @param string $message The message being send to the recipient
     * @param string $stub_message The $message being filtered before saving into database
     * @param string $caller The caller that is shown on screen when calling recipient
     * @param string $current_filter The context(WordPress hook) of this send() method being run.
     * @param string $event_name The event string name. Must be stated in Xoxzo::parse_event_name()
     * @return boolean
     */
    public function send_playback(
        $recipient,
        $message,
        $stub_message,
        $caller,
        $current_filter,
        $event_name
    ) {
        $client = (new \XoxzoVoiceClient);
        $resp = $client->send_simple_playback($caller, $recipient, $message);
        if($this->is_error($resp, $current_filter, $stub_message, $recipient, $client->sender_id())) {
            return false;
        }
        $data = $this->get($resp, $message, $event_name);
        return $this->save($data);
    }

    public function send_custom_event() {
        $type = "";
        $caller = "";
        $recipients = "";
        $playback = "";
        $tts = "";
        if(isset($_POST['type']) and !empty($_POST['type'])) {
            $type = sanitize_text_field($_POST["type"]);
        }
        if(isset($_POST['caller']) and !empty($_POST['caller'])) {
            $caller = sanitize_text_field($_POST["caller"]);
        }
        if(isset($_POST['recipients']) and !empty($_POST['recipients'])) {
            $recipients = array();
            foreach(explode(",", $_POST["recipients"]) as $recipient) {
                $recipients[] = sanitize_text_field(trim($recipient));
            }
        }
        if(isset($_POST['playback']) and !empty($_POST['playback'])) {
            $playback = sanitize_text_field(trim($_POST["playback"]));
        }
        if(isset($_POST['tts']) and !empty($_POST['tts'])) {
            $tts = sanitize_text_field(trim($_POST["tts"]));
        }

        $replies = [
            "error" => [],
            "success" => [],
        ];
        foreach($recipients as $recipient) {
            if($type==="playback") {

                $client = (new \XoxzoVoiceClient);
                $resp = $client->send_simple_playback($caller, $recipient, $playback);

                if($this->is_error($resp, \Xoxzo::HOOK__VOICE__CUSTOM_EVENT_PLAYBACK, $playback, $recipient, $client->sender_id())) {
                    foreach($resp->messages as $key => $error_message) {
                        $replies['error'][$key] = $error_message;
                    }
                }
                else {
                    $data = $this->get($resp, $playback, \Xoxzo::HOOK__VOICE__CUSTOM_EVENT_PLAYBACK);
                    $this->_save($data);
                    $replies['success'][] = "Voice playback sent to $recipient";
                }
            }
            else if($type=="tts") {

                $client = (new \XoxzoVoiceClient);
                $resp = $client->send_tts_playback($caller, $recipient, $tts, "en");

                if($this->is_error($resp, \Xoxzo::HOOK__VOICE__CUSTOM_EVENT_TTS, $tts, $recipient, $client->sender_id())) {
                    foreach($resp->messages as $key => $error_message) {
                        $replies['error'][$key] = $error_message;
                    }
                }
                else {
                    $data = $this->get($resp, $tts, \Xoxzo::HOOK__VOICE__CUSTOM_EVENT_TTS);
                    $this->_save($data);
                    $replies['success'][] = "Voice TTS sent to $recipient";
                }
            }
        }
        wp_cache_set( XOXZO::RESPONSE__CUSTOM_EVENT__VOICE.wp_get_current_user()->ID, json_encode($replies) );
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

        $callid = -1;
        if($response->messages[0]->callid) {
            $callid = $response->messages[0]->callid;
        }

        $data = $this->fetch_status($callid);
        if(isset($data["callid"])) {
            return array(
                "event" => $event_name,
                "message" => $stub_message,
                "msgid" => isset($data["callid"]) ? $data["callid"]: "",
                "start_time" => isset($data["start_time"]) ? $data["start_time"]: "",
                "end_time" => isset($data["end_time"]) ? $data["end_time"]: "",
                "cost" => isset($data["cost"]) ? $data["cost"]: "",
                "duration" => isset($data["duration"]) ? $data["duration"]: "",
                "url" => isset($data["url"]) ? $data["url"]: "",
                "status" => isset($data["status"]) ? $data["status"]: "",
                "caller" => isset($data["caller"]) ? $data["caller"]: "",
                "recipient" => isset($data["recipient"]) ? $data["recipient"]: "",
            );
        }
        else {
            return array(
                "event" => $event_name,
                "message" => $stub_message,
                "msgid" => $callid,
                "sender" => "",
                "start_time" => "",
                "end_time" => "",
                "cost" => "",
                "duration" => "",
                "url" => "",
                "status" => "",
                "caller" => "",
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
     * @param string $sender The sender id used in the voice request
     * @return boolean
     */
    public function is_error($response, $current_filter_event, $stub_message, $recipient, $sender) {
        if($response->errors) {
            global $wpdb;

            $tablename = (new \Xoxzo)->table_name__error();
            $wpdb->insert($tablename, array(
                "notification_type" => "voice",
                "event" => $current_filter_event,
                "error_code" => $response->errors,
                "error_message" => json_encode($response->messages),
                "recipient" => $recipient,
                "message" => $stub_message,
                "sender" => $sender,
                "created_at" => date('Y-m-d H:i:s', time()),
            ));

            return true;
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
    public static function save($data) {

        $tablename = (new \Xoxzo)->table_name__status();

        global $wpdb;
        $result = $wpdb->insert($tablename, array(
            "notification_type" => "voice",
            "event" => $data["event"],
            "message" => $data["message"],
            "msgid_callid" => $data["msgid"],
            "cost" => $data["cost"],
            "duration" => $data["duration"],
            "status" => $data["status"],
            "caller" => $data["caller"],
            "recipient" => $data["recipient"],
            "url" => $data["url"],
            "start_time" => $data["start_time"],
            "end_time" => $data["end_time"],
            "created_at" => date('Y-m-d H:i:s', time()),
        ));

        return $result;
    }

    /**
     * Wrap around the static function save()
     * */
    private function _save($data) {
        return self::save($data);
    }

    /**
     * HTTP call to check delivery status of each Xoxzo API request.
     *
     * @since 1.0.0
     *
     * @param  string $callid The call id request. Refer Xoxzo Docs for more information.
     * @return string|array String is error. Array for response
     */
    private function fetch_status($callid) {

        $client = (new \XoxzoVoiceClient);

        $url = "https://api.xoxzo.com/voice/calls/{$callid}/";
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