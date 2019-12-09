<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit(0);
}

/**
 * Wrap relevant information in a ValueObject for a sms notification, initialized by a particular event
 *
 * @since 1.0.0
 */
class XoxzoValueSms {
    private $event;
    private $enabled;
    private $title;
    private $message;
    private $recipients;
    private $caller;
    private $template;

    /**
     * Class constructor
     *
     * Initialize WordPress meta keys related to an event
     *
     * @since 1.0.0
     */
    public function __construct($event) {
        $this->event;
        $ids = $this->get_ids($event);
        $this->enabled  = $ids['enabled'];
        $this->title  = $ids['title'];
        $this->message  = $ids['message'];
        $this->recipients  = $ids['recipients'];
        $this->template  = $ids['template'];
    }

    /**
     * Check the event has sms notification enabled.
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    public function enabled() {
        $enabled = get_option($this->enabled);
        if($enabled==="yes") {
            return true;
        }
        return false;
    }

    /**
     * Get the caller id set for the event.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function caller() {
        return get_option($this->caller);
    }

    /**
     * Get the list of recipients(empty array if none) set in the settings
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function recipients() {
        if(!in_array($this->event, [
            Xoxzo::SMS_ON_HOLD,
            Xoxzo::SMS_PROCESSING,
            Xoxzo::SMS_COMPLETED,
            Xoxzo::SMS_FULLY_REFUNDED,
            Xoxzo::SMS_PARTIALLY_REFUNDED,
            Xoxzo::SMS_LOW_STOCK,
            Xoxzo::SMS_NO_STOCK,
            Xoxzo::SMS_ORDER_DETAILS,
            Xoxzo::SMS_CUSTOMER_NOTE,
            Xoxzo::SMS_RESET_PASSWORD,
            Xoxzo::SMS_NEW_ACCOUNT,
        ])) {
            $recipients = get_option($this->recipients);
            $__ = explode(",", $recipients);
            $list = array();
            foreach($__ as $item) {
                $list[] = trim($item);
            }
            return $list;
        }
    }

    /**
     * Get the billing phone(empty array if none), from the WP_User object.
     *
     * @since 1.0.0
     *
     * @param WP_User $user
     * @return array
     */
    public function user_recipient(\WP_user $user) {
        $user_id = $user->ID;
        if($user_id) {
            $billing_phone = get_user_meta( $user_id, 'billing_phone', true );
            return array($billing_phone);
        }
        return array();
    }

    /**
     * Get the billing phone(empty array if none), from the WC_Customer object.
     *
     * @since 1.0.0
     *
     * @param WC_Customer $customer
     * @return array
     */
    public function customer_recipient(\WC_Customer $customer) {
        $customer_id = $customer->get_id();
        if($customer_id) {
            $billing_phone = get_user_meta( $customer_id, 'billing_phone', true );
            return array($billing_phone);
        }
        return array();
    }

    /**
     * Get the payload(text message) for sending to recipient(s).
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function payload() {
        $message = get_option($this->message);
        if(trim($message)=="") {
            return trim($this->template);
        }
        else {
            return trim($message);
        }
    }

    /**
     * Get the meta key(s) from a list of sms notification event.
     *
     * @since 1.0.0
     *
     * @param string event
     * @return array
     */
    public function get_ids($event) {
        $_ = array(
            Xoxzo::SMS_NEW => array(
                'enabled' => Xoxzo::NEW__ENABLED__SMS,
                'title' => Xoxzo::NEW__TITLE__SMS,
                'recipients' => Xoxzo::NEW__RECIPIENTS__SMS,
                'message' => Xoxzo::NEW__MESSAGE__SMS,
                'template' => Xoxzo::MESSAGE_TEMPLATE__NEW__SMS,
            ),
            Xoxzo::SMS_CANCELLED => array(
                'enabled' =>  Xoxzo::CANCELLED__ENABLED__SMS,
                'title' =>  Xoxzo::CANCELLED__TITLE__SMS,
                'recipients' =>  Xoxzo::CANCELLED__RECIPIENTS__SMS,
                'message' =>  Xoxzo::CANCELLED__MESSAGE__SMS,
                'template' => Xoxzo::MESSAGE_TEMPLATE__CANCELLED__SMS,
            ),
            Xoxzo::SMS_FAILED => array(
                'enabled' =>  Xoxzo::FAILED__ENABLED__SMS,
                'title' =>  Xoxzo::FAILED__TITLE__SMS,
                'recipients' =>  Xoxzo::FAILED__RECIPIENTS__SMS,
                'message' =>  Xoxzo::FAILED__MESSAGE__SMS,
                'template' => Xoxzo::MESSAGE_TEMPLATE__FAILED__SMS,
            ),
            Xoxzo::SMS_ON_HOLD => array(
                'enabled' =>  Xoxzo::ON_HOLD__ENABLED__SMS,
                'title' =>  Xoxzo::ON_HOLD__TITLE__SMS,
                'recipients' =>  Xoxzo::ON_HOLD__RECIPIENTS__SMS,
                'message' =>  Xoxzo::ON_HOLD__MESSAGE__SMS,
                'template' => Xoxzo::MESSAGE_TEMPLATE__ON_HOLD__SMS,
            ),
            Xoxzo::SMS_PROCESSING => array(
                'enabled' =>  Xoxzo::PROCESSING__ENABLED__SMS,
                'title' =>  Xoxzo::PROCESSING__TITLE__SMS,
                'recipients' =>  Xoxzo::PROCESSING__RECIPIENTS__SMS,
                'message' =>  Xoxzo::PROCESSING__MESSAGE__SMS,
                'template' => Xoxzo::MESSAGE_TEMPLATE__PROCESSING__SMS,
            ),
            Xoxzo::SMS_COMPLETED => array(
                'enabled' =>  Xoxzo::COMPLETED__ENABLED__SMS,
                'title' =>  Xoxzo::COMPLETED__TITLE__SMS,
                'recipients' =>  Xoxzo::COMPLETED__RECIPIENTS__SMS,
                'message' =>  Xoxzo::COMPLETED__MESSAGE__SMS,
                'template' => Xoxzo::MESSAGE_TEMPLATE__COMPLETED__SMS,
            ),
            Xoxzo::SMS_FULLY_REFUNDED => array(
                'enabled' =>  Xoxzo::FULLY_REFUNDED__ENABLED__SMS,
                'title' =>  Xoxzo::FULLY_REFUNDED__TITLE__SMS,
                'recipients' =>  Xoxzo::FULLY_REFUNDED__RECIPIENTS__SMS,
                'message' =>  Xoxzo::FULLY_REFUNDED__MESSAGE__SMS,
                'template' => Xoxzo::MESSAGE_TEMPLATE__FULLY_REFUNDED__SMS,
            ),
            Xoxzo::SMS_PARTIALLY_REFUNDED => array(
                'enabled' =>  Xoxzo::PARTIALLY_REFUNDED__ENABLED__SMS,
                'title' =>  Xoxzo::PARTIALLY_REFUNDED__TITLE__SMS,
                'recipients' =>  Xoxzo::PARTIALLY_REFUNDED__RECIPIENTS__SMS,
                'message' =>  Xoxzo::PARTIALLY_REFUNDED__MESSAGE__SMS,
                'template' => Xoxzo::MESSAGE_TEMPLATE__PARTIALLY_REFUNDED__SMS,
            ),
            Xoxzo::SMS_LOW_STOCK => array(
                'enabled' =>  Xoxzo::LOW_STOCK__ENABLED__SMS,
                'title' =>  Xoxzo::LOW_STOCK__TITLE__SMS,
                'recipients' =>  Xoxzo::LOW_STOCK__RECIPIENTS__SMS,
                'message' =>  Xoxzo::LOW_STOCK__MESSAGE__SMS,
                'template' => Xoxzo::MESSAGE_TEMPLATE__LOW_STOCK__SMS,
            ),
            Xoxzo::SMS_NO_STOCK => array(
                'enabled' =>  Xoxzo::NO_STOCK__ENABLED__SMS,
                'title' =>  Xoxzo::NO_STOCK__TITLE__SMS,
                'recipients' =>  Xoxzo::NO_STOCK__RECIPIENTS__SMS,
                'message' =>  Xoxzo::NO_STOCK__MESSAGE__SMS,
                'template' => Xoxzo::MESSAGE_TEMPLATE__NO_STOCK__SMS,
            ),
            Xoxzo::SMS_ORDER_DETAILS => array(
                'enabled' =>  Xoxzo::ORDER_DETAILS__ENABLED__SMS,
                'title' =>  Xoxzo::ORDER_DETAILS__TITLE__SMS,
                'recipients' =>  Xoxzo::ORDER_DETAILS__RECIPIENTS__SMS,
                'message' =>  Xoxzo::ORDER_DETAILS__MESSAGE__SMS,
                'template' => Xoxzo::MESSAGE_TEMPLATE__ORDER_DETAILS__SMS,
            ),
            Xoxzo::SMS_CUSTOMER_NOTE => array(
                'enabled' =>  Xoxzo::CUSTOMER_NOTE__ENABLED__SMS,
                'title' =>  Xoxzo::CUSTOMER_NOTE__TITLE__SMS,
                'recipients' =>  Xoxzo::CUSTOMER_NOTE__RECIPIENTS__SMS,
                'message' =>  Xoxzo::CUSTOMER_NOTE__MESSAGE__SMS,
                'template' => Xoxzo::MESSAGE_TEMPLATE__CUSTOMER_NOTE__SMS,
            ),
            Xoxzo::SMS_RESET_PASSWORD => array(
                'enabled' =>  Xoxzo::RESET_PASSWORD__ENABLED__SMS,
                'title' =>  Xoxzo::RESET_PASSWORD__TITLE__SMS,
                'recipients' =>  Xoxzo::RESET_PASSWORD__RECIPIENTS__SMS,
                'message' =>  Xoxzo::RESET_PASSWORD__MESSAGE__SMS,
                'template' => Xoxzo::MESSAGE_TEMPLATE__RESET_PASSWORD__SMS,
            ),
            Xoxzo::SMS_NEW_ACCOUNT => array(
                'enabled' =>  Xoxzo::NEW_ACCOUNT__ENABLED__SMS,
                'title' =>  Xoxzo::NEW_ACCOUNT__TITLE__SMS,
                'recipients' =>  Xoxzo::NEW_ACCOUNT__RECIPIENTS__SMS,
                'message' =>  Xoxzo::NEW_ACCOUNT__MESSAGE__SMS,
                'template' => Xoxzo::MESSAGE_TEMPLATE__NEW_ACCOUNT__SMS,
            ),
        );
        return $_[$event];
    }

    /**
     * Replace {placeholder} tag inside a string into actual information. Typically used for payload.
     *
     * @since 1.0.0
     *
     * @param string $template
     * @param array $replacements
     * @return string
     */
    public function format_message( $template, array $replacements = array(
        '{order_date}'   => '',
        '{order_number}' => '',
        '{order_pay_url}' => '',
        '{customer_note}' => '',
        '{product_name}' => '',
        '{product_stock}' => '',
        '{product_id}' => '',
        '{username}' => '',
        '{password}' => '',
        '{password_reset_url}' => '',
        '{site_url}' => '',
        '{site_title}' => ''
    )) {
        $replacements = wp_parse_args($replacements, array(
            '{order_date}'   => '',
            '{order_number}' => '',
            '{order_pay_url}'   => '',
            '{customer_note}' => '',
            '{product_name}' => '',
            '{product_stock}' => '',
            '{product_id}' => '',
            '{username}' => '',
            '{password}' => '',
            '{password_reset_url}' => '',
            '{site_title}' => wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES ),
            '{site_url}' => wp_specialchars_decode( get_option( 'home' ), ENT_QUOTES ),
        ));

        foreach($replacements as $placeholder => $replace) {
            $template = str_replace( $placeholder, $replace, $template );
        }
        return $template;
    }
}