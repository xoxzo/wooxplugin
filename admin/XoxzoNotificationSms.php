<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class XoxzoNotificationSms {

    /**
     * Class constructor
     */
    public function __construct() {

        /* New order created.
         * */
        add_action( Xoxzo::HOOK__WOOCOMMERCE__ORDER_STATUS_PENDING_TO_PROCESSING_NOTIFICATION, array( $this, 'event_order_new_notification' ), 99, 2 );
        add_action( Xoxzo::HOOK__WOOCOMMERCE__ORDER_STATUS_PENDING_TO_COMPLETED_NOTIFICATION, array( $this, 'event_order_new_notification' ), 99, 2 );
        add_action( Xoxzo::HOOK__WOOCOMMERCE__ORDER_STATUS_PENDING_TO_ONHOLD_NOTIFICATION, array( $this, 'event_order_new_notification' ), 99, 2 );
        add_action( Xoxzo::HOOK__WOOCOMMERCE__ORDER_STATUS_FAILED_TO_PROCESSING_NOTIFICATION, array( $this, 'event_order_new_notification' ), 99, 2 );
        add_action( Xoxzo::HOOK__WOOCOMMERCE__ORDER_STATUS_FAILED_TO_COMPLETED_NOTIFICATION, array( $this, 'event_order_new_notification' ), 99, 2 );
        add_action( Xoxzo::HOOK__WOOCOMMERCE__ORDER_STATUS_FAILED_TO_ONHOLD_NOTIFICATION, array( $this, 'event_order_new_notification' ), 99, 2 );

        /* Low and no stock
         * */
        add_action( Xoxzo::HOOK__WOOCOMMERCE__LOW_STOCK_NOTIFICATION, array( $this, 'event_low_stock_notification' ) );
        add_action( Xoxzo::HOOK__WOOCOMMERCE__NO_STOCK_NOTIFICATION, array( $this, 'event_no_stock_notification' ) );

        /* Cancel order
         * */
        add_action( Xoxzo::HOOK__WOOCOMMERCE__ORDER_STATUS_PROCESSING_TO_CANCELLED_NOTIFICATION, array( $this, 'event_order_admin_cancel_notification' ), 10, 2 );
        add_action( Xoxzo::HOOK__WOOCOMMERCE__ORDER_STATUS_ONHOLD_TO_CANCELLED_NOTIFICATION, array( $this, 'event_order_admin_cancel_notification' ), 10, 2 );
        add_action( Xoxzo::HOOK__WOOCOMMERCE__CUSTOMER_CANCELLED_NOTIFICATION, array( $this, 'event_order_customer_cancel_notification' ), 10, 1 );

        /* Fail order
         * */
        add_action( Xoxzo::HOOK__WOOCOMMERCE__ORDER_STATUS_PENDING_TO_FAILED_NOTIFICATION, array( $this, 'event_order_fail_notification' ), 10, 2 );
        add_action( Xoxzo::HOOK__WOOCOMMERCE__ORDER_STATUS_ONHOLD_TO_FAILED_NOTIFICATION, array( $this, 'event_order_fail_notification' ), 10, 2 );

        /* On-hold order
         * */
        add_action( Xoxzo::HOOK__WOOCOMMERCE__ORDER_STATUS_PENDING_TO_ONHOLD_NOTIFICATION, array( $this, 'event_order_on_hold_notification' ), 99, 2 );
        add_action( Xoxzo::HOOK__WOOCOMMERCE__ORDER_STATUS_FAILED_TO_ONHOLD_NOTIFICATION, array( $this, 'event_order_on_hold_notification' ), 99, 2 );

        /* Processing order
         * */
        add_action( Xoxzo::HOOK__WOOCOMMERCE__ORDER_STATUS_FAILED_TO_PROCESSING_NOTIFICATION, array( $this, 'event_order_processing_notification' ), 99, 2 );
        add_action( Xoxzo::HOOK__WOOCOMMERCE__ORDER_STATUS_ONHOLD_TO_PROCESSING_NOTIFICATION, array( $this, 'event_order_processing_notification' ), 99, 2 );
        add_action( Xoxzo::HOOK__WOOCOMMERCE__ORDER_STATUS_PENDING_TO_PROCESSING_NOTIFICATION, array( $this, 'event_order_processing_notification' ), 99, 2 );

        /* Completed order
         * */
        add_action( Xoxzo::HOOK__WOOCOMMERCE__ORDER_STATUS_COMPLETED_NOTIFICATION, array( $this, 'event_order_complete_notification' ), 99, 2 );

        /* Full refund
         * */
        add_action( Xoxzo::HOOK__WOOCOMMERCE__FULLY_REFUNDED_NOTIFICATION, array( $this, 'event_fully_refunded_notification' ), 99, 2 );

        /* Partial refund
         * */
        add_action( Xoxzo::HOOK__WOOCOMMERCE__PARTIALLY_REFUNDED_NOTIFICATION, array( $this, 'event_partially_refunded_notification' ), 99, 2 );

        /* Manual send order details.
         * */
        add_action( Xoxzo::HOOK__WOOCOMMERCE__BEFORE_RESEND_ORDER_EMAILS_NOTIFICATION, array( $this, 'event_manual_customer_invoice_notification' ), 99);

        /* New customer note
         * */
        add_action( Xoxzo::HOOK__WOOCOMMERCE__NEW_CUSTOMER_NOTE_NOTIFICATION, array( $this, 'event_new_customer_note_notification' ), 99, 1);

        /* User reset password
         * */
        add_action ( Xoxzo::HOOK__WOOCOMMERCE__RESET_PASSWORD_NOTIFICATION, array($this, 'event_reset_password_notification'), 99, 2 );

        /* New user(Role: Customer)/customer created
         * */
        add_action( Xoxzo::HOOK__WOOCOMMERCE__CREATED_CUSTOMER_NOTIFICATION, array($this, "event_created_customer_notification"), 99, 3);
        add_action('woocommerce_new_customer', array($this, "event_created_customer_notification"), 99, 3);
    }

    /**
     * Trigger the sending of this sms when new order received.
     *
     * @param int            $order_id The order ID.
     * @param WC_Order|false $order Order object.
     */
    public function event_order_new_notification( $order_id, $order = false ) {
        $sms = new XoxzoValueSms(Xoxzo::SMS_NEW);
        if(!$sms->enabled())
            return;

        try {

            if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
                $order = wc_get_order( $order_id );
            }
            if ( !is_a( $order, 'WC_Order' ) ) {
                return;
            }
            foreach($sms->recipients() as $recipient) {
                $message_template = $sms->payload();
                $message = $sms->format_message($message_template,  [
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                ]);

                $response = new \XoxzoSmsResponse;
                $response->send($recipient, $message, $message, current_filter(), "new_order__".current_filter());
            }
        }
        catch(\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    /**
     * Low stock notification sms.
     *
     * @param WC_Product $product Product instance.
     */
    public function event_low_stock_notification( $product ) {
        $sms = new XoxzoValueSms(Xoxzo::SMS_LOW_STOCK);
        if(!$sms->enabled())
            return;

        try {
            foreach($sms->recipients() as $recipient) {
                $message_template = $sms->payload();
                $message = $sms->format_message($message_template,  [
                    "{product_name}" => html_entity_decode( strip_tags( $product->get_formatted_name() ) ),
                    "{product_stock}" => html_entity_decode( strip_tags( $product->get_stock_quantity() ) ),
                    "{product_id}" => $product->get_id(),
                ]);

                $response = new \XoxzoSmsResponse;
                $response->send($recipient, $message, $message, current_filter(), current_filter());
            }
        }
        catch(\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    /**
     * No stock notification sms.
     *
     * @param WC_Product $product Product instance.
     */
    public function event_no_stock_notification( $product ) {
        $sms = new XoxzoValueSms(Xoxzo::SMS_NO_STOCK);
        if(!$sms->enabled())
            return;

        try {

            foreach($sms->recipients() as $recipient) {
                $message_template = $sms->payload();
                $message = $sms->format_message($message_template,  [
                    "{product_name}" => html_entity_decode( strip_tags( $product->get_formatted_name() ) ),
                    "{product_id}" => $product->get_id(),
                ]);

                $response = new \XoxzoSmsResponse;
                $response->send($recipient, $message, $message, current_filter(), current_filter());
            }
        }
        catch(\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    /**
     * Trigger the sending of this sms when order is cancelled.
     *
     * @param int            $order_id The order ID.
     * @param WC_Order|false $order Order object.
     */
    public function event_order_admin_cancel_notification( $order_id, $order = false ) {
        $sms = new XoxzoValueSms(Xoxzo::SMS_CANCELLED);
        if(!$sms->enabled())
            return;

        try {
            if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
                $order = wc_get_order( $order_id );
            }
            if ( !is_a( $order, 'WC_Order' ) ) {
                return;
            }

            $user_recipients = (new \XoxzoValueCustomerPhone($order))->sms($sms);
            foreach($user_recipients as $recipient) {
                $message_template = $sms->payload();
                $message = $sms->format_message($message_template,  [
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                ]);

                $response = new \XoxzoSmsResponse;
                $response->send($recipient, $message, $message, current_filter(), current_filter()."_backend");
            }
        }
        catch(\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    /**
     * Trigger the sending of this sms when order is cancelled by customer.
     *
     * @param int            $order_id The order ID.
     */
    public function event_order_customer_cancel_notification( $order_id ) {
        $sms = new XoxzoValueSms(Xoxzo::SMS_CANCELLED);
        if(!$sms->enabled())
            return;

        try {
            $order = wc_get_order( $order_id );
            if ( !is_a( $order, 'WC_Order' ) ) {
                return;
            }

            foreach($sms->recipients() as $recipient) {
                $message_template = $sms->payload();
                $message = $sms->format_message($message_template,  [
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                ]);

                $response = new \XoxzoSmsResponse;
                $response->send($recipient, $message, $message, current_filter(), current_filter()."_frontend");
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
        $sms = new XoxzoValueSms(Xoxzo::SMS_FAILED);
        if(!$sms->enabled())
            return;

        try {
            if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
                $order = wc_get_order( $order_id );
            }
            if ( !is_a( $order, 'WC_Order' ) ) {
                return;
            }

            foreach($sms->recipients() as $recipient) {
                $message_template = $sms->payload();
                $message = $sms->format_message($message_template,  [
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                ]);

                $response = new \XoxzoSmsResponse;
                $response->send($recipient, $message, $message, current_filter(), current_filter()."_backend");
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
        $sms = new XoxzoValueSms(Xoxzo::SMS_ON_HOLD);
        if(!$sms->enabled())
            return;

        try {
            if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
                $order = wc_get_order( $order_id );
            }

            if ( !is_a( $order, 'WC_Order' ) ) {
                return;
            }

            $user_recipients = (new \XoxzoValueCustomerPhone($order))->sms($sms);
            if(empty($user_recipients)) {
                return;
            }

            foreach($user_recipients as $recipient) {
                $message_template = $sms->payload();
                $message = $sms->format_message($message_template,  [
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                ]);

                $response = new \XoxzoSmsResponse;
                $response->send($recipient, $message, $message, current_filter(), current_filter());
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
        $sms = new XoxzoValueSms(Xoxzo::SMS_PROCESSING);
        if(!$sms->enabled())
            return;

        try {
            if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
                $order = wc_get_order( $order_id );
            }
            if ( !is_a( $order, 'WC_Order' ) ) {
                return;
            }

            $user_recipients = (new \XoxzoValueCustomerPhone($order))->sms($sms);
            if(empty($user_recipients)) {
                return;
            }

            foreach($user_recipients as $recipient) {
                $message_template = $sms->payload();
                $message = $sms->format_message($message_template,  [
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                ]);

                $response = new \XoxzoSmsResponse;
                $response->send($recipient, $message, $message, current_filter(), current_filter());
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
        $sms = new XoxzoValueSms(Xoxzo::SMS_COMPLETED);
        if(!$sms->enabled())
            return;

        try {
            if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
                $order = wc_get_order( $order_id );
            }
            if ( !is_a( $order, 'WC_Order' ) ) {
                return;
            }

            $user_recipients = (new \XoxzoValueCustomerPhone($order))->sms($sms);
            if(empty($user_recipients)) {
                return;
            }

            foreach($user_recipients as $recipient) {
                $message_template = $sms->payload();
                $message = $sms->format_message($message_template,  [
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                    "{order_pay_url}" => $this->remove_http( esc_url( add_query_arg( array( 'key' => $order->order_key ), wc_get_endpoint_url( 'order-pay', $order->id, wc_get_page_permalink( 'checkout' ) ) ) ) ),
                ]);

                $response = new \XoxzoSmsResponse;
                $response->send($recipient, $message, $message, current_filter(), current_filter());
            }
        }
        catch (\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    /**
     * Trigger the sending of this sms when order is fully refunded.
     *
     * @param int $order_id The order ID.
     * @param int $refund_id The refund ID.
     */
    public function event_fully_refunded_notification($order_id, $refund_id = null) {
        $sms = new XoxzoValueSms(Xoxzo::SMS_FULLY_REFUNDED);
        if(!$sms->enabled())
            return;

        try {
            if ( !$order_id ) {
                return;
            }
            $order = wc_get_order( $order_id );

            $user_recipients = (new \XoxzoValueCustomerPhone($order))->sms($sms);
            if(empty($user_recipients)) {
                return;
            }

            foreach($user_recipients as $recipient) {
                $message_template = $sms->payload();
                $message = $sms->format_message($message_template,  [
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                    "{order_pay_url}" => $this->remove_http( esc_url( add_query_arg( array( 'key' => $order->order_key ), wc_get_endpoint_url( 'order-pay', $order->id, wc_get_page_permalink( 'checkout' ) ) ) ) ),
                ]);

                $response = new \XoxzoSmsResponse;
                $response->send($recipient, $message, $message, current_filter(), current_filter());
            }
        }
        catch (\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    /**
     * Trigger the sending of this sms when order is partially refunded.
     *
     * @param int $order_id The order ID.
     * @param int $refund_id The refund ID.
     */
    public function event_partially_refunded_notification($order_id, $refund_id = null) {
        $sms = new XoxzoValueSms(Xoxzo::SMS_PARTIALLY_REFUNDED);
        if(!$sms->enabled())
            return;

        try {
            if ( !$order_id ) {
                return;
            }
            $order = wc_get_order( $order_id );

            $user_recipients = (new \XoxzoValueCustomerPhone($order))->sms($sms);
            if(empty($user_recipients)) {
                return;
            }

            foreach($user_recipients as $recipient) {
                $message_template = $sms->payload();
                $message = $sms->format_message($message_template,  [
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                    "{order_pay_url}" => $this->remove_http( esc_url( add_query_arg( array( 'key' => $order->order_key ), wc_get_endpoint_url( 'order-pay', $order->id, wc_get_page_permalink( 'checkout' ) ) ) ) ),
                ]);

                $response = new \XoxzoSmsResponse;
                $response->send($recipient, $message, $message, current_filter(), current_filter());
            }
        }
        catch (\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    /**
     * Customer payment info
     *
     * @param Object $args An object, maybe the WC_Order object
     */
    public function event_manual_customer_invoice_notification($args) {
        $sms = new XoxzoValueSms(Xoxzo::SMS_ORDER_DETAILS);
        if(!$sms->enabled())
            return;

        try {
            if ( empty( $args ) or !$args->id ) {
                return;
            }
            $order = $args;

            $user_recipients = (new \XoxzoValueCustomerPhone($order))->sms($sms);
            if(empty($user_recipients)) {
                return;
            }

            $user = $order->get_user();
            foreach($user_recipients as $recipient) {
                $message_template = $sms->payload();
                $message = $sms->format_message($message_template, [
                    "{username}" => empty($user) ? "Guest" : $user->user_login,
                    "{order_number}" => $order->get_order_number(),
                    "{order_date}" => wc_format_datetime( $order->get_date_created() ),
                    "{order_pay_url}" => $this->remove_http( esc_url( add_query_arg( array( 'key' => $order->order_key ), wc_get_endpoint_url( 'order-pay', $order->id, wc_get_page_permalink( 'checkout' ) ) ) ) ),
                ] );
                $response = new \XoxzoSmsResponse;
                $response->send($recipient, $message, $message, current_filter(), current_filter());
            }
        }
        catch(\Exception $ex) {
            \Xoxzo::write_log($ex->getMessage());
        }
    }

    public function event_new_customer_note_notification(array $args = array()) {
        $sms = new XoxzoValueSms(Xoxzo::SMS_CUSTOMER_NOTE);
        if(!$sms->enabled())
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

            $user_recipients = (new \XoxzoValueCustomerPhone($order))->sms($sms);
            if(empty($user_recipients)) {
                return;
            }

            foreach($user_recipients as $recipient) {
                $message_template = $sms->payload();
                $message = $sms->format_message($message_template, [
                    "{customer_note}" => $customer_note
                ]);
                $response = new \XoxzoSmsResponse;
                $response->send($recipient, $message, $message, current_filter(), current_filter());
            }
        }
        catch(\Exception $ex) {
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
        $sms = new XoxzoValueSms(Xoxzo::SMS_RESET_PASSWORD);
        if(!$sms->enabled())
            return;

        try {
            if ( !$user_login or !$reset_key ) {
                return;
            }
            $user = get_user_by( 'login', $user_login );

            foreach($sms->user_recipient($user) as $recipient) {
                $message_template = $sms->payload();
                $password_reset_url = esc_url( add_query_arg( array( 'key' => $reset_key ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) );
                $message = $sms->format_message($message_template, [
                    "{username}" => $user_login,
                    "{password_reset_url}" => $password_reset_url,
                ]);
                $stub_message = $sms->format_message($message_template, [
                    "{username}" => $user_login,
                    "{password_reset_url}" => $password_reset_url,
                ]);

                $response = new \XoxzoSmsResponse;
                $response->send($recipient, $message, $stub_message, current_filter(), current_filter());
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
        $sms = new XoxzoValueSms(Xoxzo::SMS_NEW_ACCOUNT);
        if(!$sms->enabled())
            return;

        try {
            if ( ! $customer_id ) {
                return;
            }

            foreach($sms->customer_recipient(new WC_Customer($customer_id)) as $recipient) {
                $message_template = $sms->payload();
                $message = $sms->format_message($message_template, [
                    "{username}" => $new_customer_data["user_login"],
                    "{password}" => $password_generated ? $new_customer_data["user_pass"] : "********",
                ]);
                $stub_message = $sms->format_message($message_template, [
                    "{username}" => $new_customer_data["user_login"],
                    "{password}" => "********",
                ]);

                $response = new \XoxzoSmsResponse;
                $response->send($recipient, $message, $stub_message, current_filter(), current_filter());
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