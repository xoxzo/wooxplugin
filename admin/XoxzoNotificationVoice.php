<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class XoxzoNotificationVoice {

    /**
     * Class constructor
     */
    public function __construct() {

        /* New order created.
         * */
        add_action( 'woocommerce_order_status_pending_to_processing_notification', array( $this, 'event_order_new_notification' ), 99, 2 );
        add_action( 'woocommerce_order_status_pending_to_completed_notification', array( $this, 'event_order_new_notification' ), 99, 2 );
        add_action( 'woocommerce_order_status_pending_to_on-hold_notification', array( $this, 'event_order_new_notification' ), 99, 2 );
        add_action( 'woocommerce_order_status_failed_to_processing_notification', array( $this, 'event_order_new_notification' ), 99, 2 );
        add_action( 'woocommerce_order_status_failed_to_completed_notification', array( $this, 'event_order_new_notification' ), 99, 2 );
        add_action( 'woocommerce_order_status_failed_to_on-hold_notification', array( $this, 'event_order_new_notification' ), 99, 2 );

        /* Low and no stock
         * */
        add_action( 'woocommerce_low_stock_notification', array( $this, 'event_low_stock_notification' ) );
        add_action( 'woocommerce_no_stock_notification', array( $this, 'event_no_stock_notification' ) );

        /* Cancel order
         * */
        add_action( 'woocommerce_order_status_processing_to_cancelled_notification', array( $this, 'event_order_cancel_notification' ), 99, 2 );
        add_action( 'woocommerce_order_status_on-hold_to_cancelled_notification', array( $this, 'event_order_cancel_notification' ), 99, 2 );

        /* Fail order
         * */
        add_action( 'woocommerce_order_status_pending_to_failed_notification', array( $this, 'event_order_fail_notification' ), 99, 2 );
        add_action( 'woocommerce_order_status_on-hold_to_failed_notification', array( $this, 'event_order_fail_notification' ), 99, 2 );

        /* On-hold order
         * */
        add_action( 'woocommerce_order_status_pending_to_on-hold_notification', array( $this, 'event_order_on_hold_notification' ), 99, 2 );
        add_action( 'woocommerce_order_status_failed_to_on-hold_notification', array( $this, 'event_order_on_hold_notification' ), 99, 2 );

        /* Processing order
         * */
        add_action( 'woocommerce_order_status_failed_to_processing_notification', array( $this, 'event_order_processing_notification' ), 99, 2 );
        add_action( 'woocommerce_order_status_on-hold_to_processing_notification', array( $this, 'event_order_processing_notification' ), 99, 2 );
        add_action( 'woocommerce_order_status_pending_to_processing_notification', array( $this, 'event_order_processing_notification' ), 99, 2 );

        /* Completed order
         * */
        add_action( 'woocommerce_order_status_completed_notification', array( $this, 'event_order_complete_notification' ), 99, 2 );

        /* Full refund
         * */
        add_action( 'woocommerce_order_fully_refunded_notification', array( $this, 'event_fully_refunded_notification' ), 99, 2 );

        /* Partial refund
         * */
        add_action( 'woocommerce_order_partially_refunded_notification', array( $this, 'event_partially_refunded_notification' ), 99, 2 );

        /* Manual send order details.
         * */
        add_action( 'woocommerce_before_resend_order_emails', array( $this, 'event_manual_customer_invoice_notification' ), 99);

        /* New customer note
         * */
        add_action( 'woocommerce_new_customer_note', array( $this, 'event_new_customer_note_notification' ), 99, 1);

        /* User reset password
         * */
        add_action ( 'woocommerce_reset_password_notification', array($this, 'event_reset_password_notification'), 99, 2 );

        /* New user(Role: Customer)/customer created
         * */
        add_action("woocommerce_created_customer", array($this, "event_created_customer_notification"), 99, 3);
    }

    /**
     * Trigger the sending of this email.
     *
     * @param int            $order_id The order ID.
     * @param WC_Order|false $order Order object.
     */
    public function event_order_new_notification( $order_id, $order = false ) {
        $voice = new XoxzoValueVoice(Xoxzo::VOICE_NEW);
        if(!$voice->enabled())
            return;

        try {
            if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
                $order = wc_get_order( $order_id );
            }
            if ( !is_a( $order, 'WC_Order' ) ) {
                return;
            }

            foreach($voice->recipients() as $recipient) {
                $message_template = $voice->payload();
                $message = $voice->format_message($message_template,  [
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                ]);

                if($voice->is_tts()) {
                    (new \XoxzoVoiceResponse)->send_tts(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        "en",
                        current_filter(),
                        current_filter()
                    );
                }
                else if($voice->is_playback()) {
                    (new \XoxzoVoiceResponse)->send_playback(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        current_filter(),
                        current_filter()
                    );
                }
            }
        }
        catch(\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    /**
     * Trigger the sending of this email when order is cancelled.
     *
     * @param int            $order_id The order ID.
     * @param WC_Order|false $order Order object.
     */
    public function event_order_cancel_notification( $order_id, $order = false ) {
        $voice = new XoxzoValueVoice(Xoxzo::VOICE_CANCELLED);
        if(!$voice->enabled())
            return;

        try {
            if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
                $order = wc_get_order( $order_id );
            }
            if ( !is_a( $order, 'WC_Order' ) ) {
                return;
            }

            foreach($voice->recipients() as $recipient) {
                $message_template = $voice->payload();
                $message = $voice->format_message($message_template,  [
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                ]);
                if($voice->is_tts()) {
                    (new \XoxzoVoiceResponse)->send_tts(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        "en",
                        current_filter(),
                        current_filter()
                    );
                }
                else if($voice->is_playback()) {
                    (new \XoxzoVoiceResponse)->send_playback(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        current_filter(),
                        current_filter()
                    );
                }
            }
        }
        catch(\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    /**
     * Trigger the sending of this sms when order goes from on-hold to fail.
     *
     * @param int            $order_id The order ID.
     * @param WC_Order|false $order Order object.
     */
    public function event_order_fail_notification( $order_id, $order = false ) {
        $voice = new XoxzoValueVoice(Xoxzo::VOICE_FAILED);
        if(!$voice->enabled())
            return;

        try {

            if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
                $order = wc_get_order( $order_id );
            }
            if ( !is_a( $order, 'WC_Order' ) ) {
                return;
            }

            foreach($voice->recipients() as $recipient) {
                $message_template = $voice->payload();
                $message = $voice->format_message($message_template,  [
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                ]);

                if($voice->is_tts()) {
                    (new \XoxzoVoiceResponse)->send_tts(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        "en",
                        current_filter(),
                        current_filter()
                    );
                }
                else if($voice->is_playback()) {
                    (new \XoxzoVoiceResponse)->send_playback(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        current_filter(),
                        current_filter()
                    );
                }
            }
        }
        catch(\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    /**
     * Low stock notification email.
     *
     * @param WC_Product $product Product instance.
     */
    public function event_low_stock_notification( $product ) {
        $voice = new XoxzoValueVoice(Xoxzo::VOICE_LOW_STOCK);
        if(!$voice->enabled())
            return;

        try {
            foreach($voice->recipients() as $recipient) {
                $message_template = $voice->payload();
                $message = $voice->format_message($message_template,  [
                    "{product_name}" => html_entity_decode( strip_tags( $product->get_formatted_name() ) ),
                    "{product_stock}" => html_entity_decode( strip_tags( $product->get_stock_quantity() ) ),
                ]);

                if($voice->is_tts()) {
                    (new \XoxzoVoiceResponse)->send_tts(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        "en",
                        current_filter(),
                        current_filter()
                    );
                }
                else if($voice->is_playback()) {
                    (new \XoxzoVoiceResponse)->send_playback(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        current_filter(),
                        current_filter()
                    );
                }
            }
        }
        catch(\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    /**
     * No stock notification email.
     *
     * @param WC_Product $product Product instance.
     */
    public function event_no_stock_notification( $product ) {
        $voice = new XoxzoValueVoice(Xoxzo::VOICE_NO_STOCK);
        if(!$voice->enabled())
            return;

        try {
            foreach($voice->recipients() as $recipient) {
                $message_template = $voice->payload();
                $message = $voice->format_message($message_template,  [
                    "{product_name}" => html_entity_decode( strip_tags( $product->get_formatted_name() ) ),
                ]);
                if($voice->is_tts()) {
                    (new \XoxzoVoiceResponse)->send_tts(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        "en",
                        current_filter(),
                        current_filter()
                    );
                }
                else if($voice->is_playback()) {
                    (new \XoxzoVoiceResponse)->send_playback(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        current_filter(),
                        current_filter()
                    );
                }
            }
        }
        catch(\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    /**
     * Trigger the sending of this sms when order is on-hold.
     *
     * @param int            $order_id The order ID.
     * @param WC_Order|false $order Order object.
     */
    public function event_order_on_hold_notification( $order_id, $order = false ) {
        $voice = new XoxzoValueVoice(Xoxzo::VOICE_ON_HOLD);
        if(!$voice->enabled())
            return;

        try {
            if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
                $order = wc_get_order( $order_id );
            }
            if ( !is_a( $order, 'WC_Order' ) ) {
                return;
            }

            $user_recipients = (new \XoxzoValueCustomerPhone($order))->voice($voice);
            if(empty($user_recipients)) {
                return;
            }
            foreach($user_recipients as $recipient) {
                $message_template = $voice->payload();
                $message = $voice->format_message($message_template,  [
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                ]);
                if($voice->is_tts()) {
                    (new \XoxzoVoiceResponse)->send_tts(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        "en",
                        current_filter(),
                        current_filter()
                    );
                }
                else if($voice->is_playback()) {
                    (new \XoxzoVoiceResponse)->send_playback(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        current_filter(),
                        current_filter()
                    );
                }
            }
        }
        catch(\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    /**
     * Trigger the sending of this sms when order is changed into processing.
     *
     * @param int            $order_id The order ID.
     * @param WC_Order|false $order Order object.
     */
    public function event_order_processing_notification( $order_id, $order = false ) {
        $voice = new XoxzoValueVoice(Xoxzo::VOICE_PROCESSING);
        if(!$voice->enabled())
            return;

        try {
            if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
                $order = wc_get_order( $order_id );
            }
            if ( !is_a( $order, 'WC_Order' ) ) {
                return;
            }

            $user_recipients = (new \XoxzoValueCustomerPhone($order))->voice($voice);
            if(empty($user_recipients)) {
                return;
            }

            foreach($user_recipients as $recipient) {
                $message_template = $voice->payload();
                $message = $voice->format_message($message_template,  [
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                ]);
                if($voice->is_tts()) {
                    (new \XoxzoVoiceResponse)->send_tts(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        "en",
                        current_filter(),
                        current_filter()
                    );
                }
                else if($voice->is_playback()) {
                    (new \XoxzoVoiceResponse)->send_playback(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        current_filter(),
                        current_filter()
                    );
                }
            }
        }
        catch(\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    /**
     * Trigger the sending of this sms when order is completed.
     *
     * @param int            $order_id The order ID.
     * @param WC_Order|false $order Order object.
     */
    public function event_order_complete_notification( $order_id, $order = false ) {
        $voice = new XoxzoValueVoice(Xoxzo::VOICE_COMPLETED);
        if(!$voice->enabled())
            return;

        try {
            if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
                $order = wc_get_order( $order_id );
            }
            if ( !is_a( $order, 'WC_Order' ) ) {
                return;
            }

            $user_recipients = (new \XoxzoValueCustomerPhone($order))->voice($voice);
            if(empty($user_recipients)) {
                return;
            }

            foreach($user_recipients as $recipient) {
                $message_template = $voice->payload();
                $message = $voice->format_message($message_template,  [
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                    "{order_pay_url}" => $this->remove_http( esc_url( add_query_arg( array( 'key' => $order->order_key ), wc_get_endpoint_url( 'order-pay', $order->id, wc_get_page_permalink( 'checkout' ) ) ) ) ),
                ]);
                if($voice->is_tts()) {
                    (new \XoxzoVoiceResponse)->send_tts(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        "en",
                        current_filter(),
                        current_filter()
                    );
                }
                else if($voice->is_playback()) {
                    (new \XoxzoVoiceResponse)->send_playback(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        current_filter(),
                        current_filter()
                    );
                }
            }
        }
        catch (\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    public function event_fully_refunded_notification($order_id, $refund_id = null) {
        $voice = new XoxzoValueVoice(Xoxzo::VOICE_FULLY_REFUNDED);
        if(!$voice->enabled())
            return;

        try {
            if ( !$order_id ) {
                return;
            }
            $order = wc_get_order( $order_id );

            $user_recipients = (new \XoxzoValueCustomerPhone($order))->voice($voice);
            if(empty($user_recipients)) {
                return;
            }
            foreach($user_recipients as $recipient) {
                $message_template = $voice->payload();
                $message = $voice->format_message($message_template,  [
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                    "{order_pay_url}" => $this->remove_http( esc_url( add_query_arg( array( 'key' => $order->order_key ), wc_get_endpoint_url( 'order-pay', $order->id, wc_get_page_permalink( 'checkout' ) ) ) ) ),
                ]);
                if($voice->is_tts()) {
                    (new \XoxzoVoiceResponse)->send_tts(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        "en",
                        current_filter(),
                        current_filter()
                    );
                }
                else if($voice->is_playback()) {
                    (new \XoxzoVoiceResponse)->send_playback(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        current_filter(),
                        current_filter()
                    );
                }
            }
        }
        catch (\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    public function event_partially_refunded_notification($order_id, $refund_id = null) {
        $voice = new XoxzoValueVoice(Xoxzo::VOICE_PARTIALLY_REFUNDED);
        if(!$voice->enabled())
            return;

        try {
            if ( !$order_id ) {
                return;
            }
            $order = wc_get_order( $order_id );

            $user_recipients = (new \XoxzoValueCustomerPhone($order))->voice($voice);
            if(empty($user_recipients)) {
                return;
            }

            foreach($user_recipients as $recipient) {
                $message_template = $voice->payload();
                $message = $voice->format_message($message_template,  [
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                    "{order_pay_url}" => $this->remove_http( esc_url( add_query_arg( array( 'key' => $order->order_key ), wc_get_endpoint_url( 'order-pay', $order->id, wc_get_page_permalink( 'checkout' ) ) ) ) ),
                ]);
                if($voice->is_tts()) {
                    (new \XoxzoVoiceResponse)->send_tts(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        "en",
                        current_filter(),
                        current_filter()
                    );
                }
                else if($voice->is_playback()) {
                    (new \XoxzoVoiceResponse)->send_playback(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        current_filter(),
                        current_filter()
                    );
                }
            }
        }
        catch (\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    public function event_manual_customer_invoice_notification($args) {
        $voice = new XoxzoValueVoice(Xoxzo::VOICE_ORDER_DETAILS);
        if(!$voice->enabled())
            return;

        try {
            if ( empty( $args ) or !$args->id ) {
                return;
            }
            $order = $args;

            $user_recipients = (new \XoxzoValueCustomerPhone($order))->voice($voice);
            if(empty($user_recipients)) {
                return;
            }

            foreach($user_recipients as $recipient) {
                $message_template = $voice->payload();
                $message = $voice->format_message($message_template,  [
                    "{username}" => empty($user) ? "Guest" : $user->user_login,
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                    "{order_pay_url}" => $this->remove_http( esc_url( add_query_arg( array( 'key' => $order->order_key ), wc_get_endpoint_url( 'order-pay', $order->id, wc_get_page_permalink( 'checkout' ) ) ) ) ),
                ]);
                if($voice->is_tts()) {
                    (new \XoxzoVoiceResponse)->send_tts(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        "en",
                        current_filter(),
                        current_filter()
                    );
                }
                else if($voice->is_playback()) {
                    (new \XoxzoVoiceResponse)->send_playback(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        current_filter(),
                        current_filter()
                    );
                }
            }
        }
        catch(\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    public function event_new_customer_note_notification(array $args = array()) {
        $voice = new XoxzoValueVoice(Xoxzo::VOICE_CUSTOMER_NOTE);
        if(!$voice->enabled())
            return;

        try {
            if(!isset($args["order_id"]) or empty($args["order_id"])) {
                return;
            }
            if(!isset($args["customer_note"]) or empty($args["customer_note"])) {
                return;
            }

            $customer_note =  $args["customer_note"];
            $order = wc_get_order( $args["order_id"] );
            if(empty($order)) {
                return;
            }

            $user_recipients = (new \XoxzoValueCustomerPhone($order))->voice($voice);
            if(empty($user_recipients)) {
                return;
            }

            foreach($user_recipients as $recipient) {
                $message_template = $voice->payload();
                $message = $voice->format_message($message_template,  [
                    "{customer_note}" => $customer_note
                ]);
                if($voice->is_tts()) {
                    (new \XoxzoVoiceResponse)->send_tts(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        "en",
                        current_filter(),
                        current_filter()
                    );
                }
                else if($voice->is_playback()) {
                    (new \XoxzoVoiceResponse)->send_playback(
                        $recipient,
                        $message,
                        $message,
                        $voice->caller(),
                        current_filter(),
                        current_filter()
                    );
                }
            }
        }
        catch (\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    /**
     * Reset password notification.
     *
     * @param string $user_login User login.
     * @param string $reset_key Password reset key.
     */
    public function event_reset_password_notification( $user_login = '', $reset_key = '' ) {
        $voice = new XoxzoValueVoice(Xoxzo::VOICE_RESET_PASSWORD);
        if(!$voice->enabled())
            return;

        try {
            if ( !$user_login or !$reset_key ) {
                return;
            }

            $user = get_user_by( 'login', $user_login );
            foreach($voice->user_recipient($user) as $recipient) {
                $message_template = $voice->payload();
                $password_reset_url = esc_url( add_query_arg( array( 'key' => $reset_key ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) );
                $message = $voice->format_message($message_template, [
                    "{username}" => $user_login,
                    "{password_reset_url}" => $password_reset_url,
                ]);
                $stub_message = $voice->format_message($message_template, [
                    "{username}" => $user_login,
                    "{password_reset_url}" => $password_reset_url,
                ]);
                if($voice->is_tts()) {
                    (new \XoxzoVoiceResponse)->send_tts(
                        $recipient,
                        $message,
                        $stub_message,
                        $voice->caller(),
                        "en",
                        current_filter(),
                        current_filter()
                    );
                }
                else if($voice->is_playback()) {
                    (new \XoxzoVoiceResponse)->send_playback(
                        $recipient,
                        $message,
                        $stub_message,
                        $voice->caller(),
                        current_filter(),
                        current_filter()
                    );
                }
            }
        }
        catch(\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    /**
     * Customer new account welcome email.
     *
     * @param int   $customer_id        Customer ID.
     * @param array $new_customer_data  New customer data.
     *              $new_customer_data["user_login"]
     *              $new_customer_data["user_pass"]
     *              $new_customer_data["user_email"]
     *              $new_customer_data["role"]
     * @param bool  $password_generated If password is generated.
     */
    public function event_created_customer_notification( $customer_id, $new_customer_data = array(), $password_generated = false ) {
        $voice = new XoxzoValueVoice(Xoxzo::VOICE_NEW_ACCOUNT);
        if(!$voice->enabled())
            return;
        if ( ! $customer_id ) {
            return;
        }

        try {
            foreach($voice->customer_recipient(new WC_Customer($customer_id)) as $recipient) {
                $message_template = $voice->payload();
                $message = $voice->format_message($message_template, [
                    "{username}" => $new_customer_data["user_login"],
                    "{password}" => $password_generated ? $new_customer_data["user_pass"] : "********",
                ]);
                $stub_message = $voice->format_message($message_template, [
                    "{username}" => $new_customer_data["user_login"],
                    "{password}" => "********",
                ]);
                if($voice->is_tts()) {
                    (new \XoxzoVoiceResponse)->send_tts(
                        $recipient,
                        $message,
                        $stub_message,
                        $voice->caller(),
                        "en",
                        current_filter(),
                        current_filter()
                    );
                }
                else if($voice->is_playback()) {
                    (new \XoxzoVoiceResponse)->send_playback(
                        $recipient,
                        $message,
                        $stub_message,
                        $voice->caller(),
                        current_filter(),
                        current_filter()
                    );
                }
            }
        }
        catch(\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    function remove_http($url) {
        $disallowed = array('http://', 'https://');
        foreach($disallowed as $d) {
            if(strpos($url, $d) === 0) {
                return str_replace($d, '', $url);
            }
        }
        return $url;
    }
}