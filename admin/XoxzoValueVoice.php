<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Wrap relevant information in a ValueObject for a voice notification, initialized by a particular event
 *
 * @since 1.0.0
 */
class XoxzoValueVoice {
    private $event;
    private $enabled;
    private $title;
    private $type;
    private $recipients;
    private $caller;
    private $playback;
    private $tts;
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
        $this->type  = get_option($ids['type']);
        $this->recipients  = $ids['recipients'];
        $this->caller  = $ids['caller'];
        $this->playback  = $ids['playback'];
        $this->tts  = $ids['tts'];
        $this->template  = $ids['template'];
    }

    /**
     * Check the event has voice notification enabled.
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
            Xoxzo::VOICE_NEW,
            Xoxzo::VOICE_CANCELLED,
            Xoxzo::VOICE_FAILED,
            Xoxzo::VOICE_ON_HOLD,
            Xoxzo::VOICE_PROCESSING,
            Xoxzo::VOICE_COMPLETED,
            Xoxzo::VOICE_FULLY_REFUNDED,
            Xoxzo::VOICE_PARTIALLY_REFUNDED,
            Xoxzo::VOICE_LOW_STOCK,
            Xoxzo::VOICE_NO_STOCK,
            Xoxzo::VOICE_ORDER_DETAILS,
            Xoxzo::VOICE_CUSTOMER_NOTE,
            Xoxzo::VOICE_RESET_PASSWORD,
            Xoxzo::VOICE_NEW_ACCOUNT,
        ])) {
            $recipients = get_option($this->recipients);
            $__ = explode(",", $recipients);
            $list = array();
            foreach($__ as $item) {
                $list[] = trim($item);
            }
            return $list;
        }
        return [];
    }

    /**
     * Get the billing phone(empty array if none), from the WP_User object.
     *
     * @since 1.0.0
     *
     * @param WP_User $user
     * @return array
     */
    public function user_recipient(\WP_User $user) {
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
     * Check Text-To-Speech notification is enabled.
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    public function is_tts() {
        if($this->type=='tts') {
            return true;
        }
        return false;
    }

    /**
     * Check Playback notification is enabled.
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    public function is_playback() {
        if($this->type==="playback") {
            return true;
        }
        return false;
    }

    /**
     * Get the payload(the playback mp3 or text message) for sending to recipient(s).
     *
     * Retrieved based on is_tts() and is_playback() result.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function payload() {
        if($this->is_tts()) {
            $message = get_option($this->tts);
            if(trim($message)=="") {
                return trim($this->template);
            }
            else {
                return trim($message);
            }
        }
        else if($this->is_playback()) {
            $message  = get_option($this->playback);
            return $message;
        }
    }

    /**
     * Get the meta key(s) from a list of voice notification event.
     *
     * @since 1.0.0
     *
     * @param string event
     * @return array
     */
    public function get_ids($event) {
        $_ = array(
            Xoxzo::VOICE_NEW => array(
                'enabled' => Xoxzo::NEW__ENABLED__VOICE,
                'title' => Xoxzo::NEW__TITLE__VOICE,
                'type' => Xoxzo::NEW__TYPE__VOICE,
                'recipients' => Xoxzo::NEW__RECIPIENTS__VOICE,
                'caller' => Xoxzo::NEW__CALLER__VOICE,
                'playback' => Xoxzo::NEW__PLAYBACK__VOICE,
                'tts' => Xoxzo::NEW__TTS__VOICE,
                'template' => Xoxzo::MESSAGE_TEMPLATE__NEW__VOICE,
            ),
            Xoxzo::VOICE_CANCELLED => array(
                'enabled' =>  Xoxzo::CANCELLED__ENABLED__VOICE,
                'title' =>  Xoxzo::CANCELLED__TITLE__VOICE,
                'type' =>  Xoxzo::CANCELLED__TYPE__VOICE,
                'recipients' =>  Xoxzo::CANCELLED__RECIPIENTS__VOICE,
                'caller' =>  Xoxzo::CANCELLED__CALLER__VOICE,
                'playback' =>  Xoxzo::CANCELLED__PLAYBACK__VOICE,
                'tts' =>  Xoxzo::CANCELLED__TTS__VOICE,
                'template' => Xoxzo::MESSAGE_TEMPLATE__CANCELLED__VOICE,
            ),
            Xoxzo::VOICE_FAILED => array(
                'enabled' =>  Xoxzo::FAILED__ENABLED__VOICE,
                'title' =>  Xoxzo::FAILED__TITLE__VOICE,
                'type' =>  Xoxzo::FAILED__TYPE__VOICE,
                'recipients' =>  Xoxzo::FAILED__RECIPIENTS__VOICE,
                'caller' =>  Xoxzo::FAILED__CALLER__VOICE,
                'playback' =>  Xoxzo::FAILED__PLAYBACK__VOICE,
                'tts' =>  Xoxzo::FAILED__TTS__VOICE,
                'template' => Xoxzo::MESSAGE_TEMPLATE__FAILED__VOICE,
            ),
            Xoxzo::VOICE_ON_HOLD => array(
                'enabled' =>  Xoxzo::ON_HOLD__ENABLED__VOICE,
                'title' =>  Xoxzo::ON_HOLD__TITLE__VOICE,
                'type' =>  Xoxzo::ON_HOLD__TYPE__VOICE,
                'recipients' =>  Xoxzo::ON_HOLD__RECIPIENTS__VOICE,
                'caller' =>  Xoxzo::ON_HOLD__CALLER__VOICE,
                'playback' =>  Xoxzo::ON_HOLD__PLAYBACK__VOICE,
                'tts' =>  Xoxzo::ON_HOLD__TTS__VOICE,
                'template' => Xoxzo::MESSAGE_TEMPLATE__ON_HOLD__VOICE,
            ),
            Xoxzo::VOICE_PROCESSING => array(
                'enabled' =>  Xoxzo::PROCESSING__ENABLED__VOICE,
                'title' =>  Xoxzo::PROCESSING__TITLE__VOICE,
                'type' =>  Xoxzo::PROCESSING__TYPE__VOICE,
                'recipients' =>  Xoxzo::PROCESSING__RECIPIENTS__VOICE,
                'caller' =>  Xoxzo::PROCESSING__CALLER__VOICE,
                'playback' =>  Xoxzo::PROCESSING__PLAYBACK__VOICE,
                'tts' =>  Xoxzo::PROCESSING__TTS__VOICE,
                'template' => Xoxzo::MESSAGE_TEMPLATE__PROCESSING__VOICE,
            ),
            Xoxzo::VOICE_COMPLETED => array(
                'enabled' =>  Xoxzo::COMPLETED__ENABLED__VOICE,
                'title' =>  Xoxzo::COMPLETED__TITLE__VOICE,
                'type' =>  Xoxzo::COMPLETED__TYPE__VOICE,
                'recipients' =>  Xoxzo::COMPLETED__RECIPIENTS__VOICE,
                'caller' =>  Xoxzo::COMPLETED__CALLER__VOICE,
                'playback' =>  Xoxzo::COMPLETED__PLAYBACK__VOICE,
                'tts' =>  Xoxzo::COMPLETED__TTS__VOICE,
                'template' => Xoxzo::MESSAGE_TEMPLATE__COMPLETED__VOICE,
            ),
            Xoxzo::VOICE_FULLY_REFUNDED => array(
                'enabled' =>  Xoxzo::FULLY_REFUNDED__ENABLED__VOICE,
                'title' =>  Xoxzo::FULLY_REFUNDED__TITLE__VOICE,
                'type' =>  Xoxzo::FULLY_REFUNDED__TYPE__VOICE,
                'recipients' =>  Xoxzo::FULLY_REFUNDED__RECIPIENTS__VOICE,
                'caller' =>  Xoxzo::FULLY_REFUNDED__CALLER__VOICE,
                'playback' =>  Xoxzo::FULLY_REFUNDED__PLAYBACK__VOICE,
                'tts' =>  Xoxzo::FULLY_REFUNDED__TTS__VOICE,
                'template' => Xoxzo::MESSAGE_TEMPLATE__FULLY_REFUNDED__VOICE,
            ),
            Xoxzo::VOICE_PARTIALLY_REFUNDED => array(
                'enabled' =>  Xoxzo::PARTIALLY_REFUNDED__ENABLED__VOICE,
                'title' =>  Xoxzo::PARTIALLY_REFUNDED__TITLE__VOICE,
                'type' =>  Xoxzo::PARTIALLY_REFUNDED__TYPE__VOICE,
                'recipients' =>  Xoxzo::PARTIALLY_REFUNDED__RECIPIENTS__VOICE,
                'caller' =>  Xoxzo::PARTIALLY_REFUNDED__CALLER__VOICE,
                'playback' =>  Xoxzo::PARTIALLY_REFUNDED__PLAYBACK__VOICE,
                'tts' =>  Xoxzo::PARTIALLY_REFUNDED__TTS__VOICE,
                'template' => Xoxzo::MESSAGE_TEMPLATE__PARTIALLY_REFUNDED__VOICE,
            ),
            Xoxzo::VOICE_LOW_STOCK => array(
                'enabled' =>  Xoxzo::LOW_STOCK__ENABLED__VOICE,
                'title' =>  Xoxzo::LOW_STOCK__TITLE__VOICE,
                'type' =>  Xoxzo::LOW_STOCK__TYPE__VOICE,
                'recipients' =>  Xoxzo::LOW_STOCK__RECIPIENTS__VOICE,
                'caller' =>  Xoxzo::LOW_STOCK__CALLER__VOICE,
                'playback' =>  Xoxzo::LOW_STOCK__PLAYBACK__VOICE,
                'tts' =>  Xoxzo::LOW_STOCK__TTS__VOICE,
                'template' => Xoxzo::MESSAGE_TEMPLATE__LOW_STOCK__VOICE,
            ),
            Xoxzo::VOICE_NO_STOCK => array(
                'enabled' =>  Xoxzo::NO_STOCK__ENABLED__VOICE,
                'title' =>  Xoxzo::NO_STOCK__TITLE__VOICE,
                'type' =>  Xoxzo::NO_STOCK__TYPE__VOICE,
                'recipients' =>  Xoxzo::NO_STOCK__RECIPIENTS__VOICE,
                'caller' =>  Xoxzo::NO_STOCK__CALLER__VOICE,
                'playback' =>  Xoxzo::NO_STOCK__PLAYBACK__VOICE,
                'tts' =>  Xoxzo::NO_STOCK__TTS__VOICE,
                'template' => Xoxzo::MESSAGE_TEMPLATE__NO_STOCK__VOICE,
            ),
            Xoxzo::VOICE_ORDER_DETAILS => array(
                'enabled' =>  Xoxzo::ORDER_DETAILS__ENABLED__VOICE,
                'title' =>  Xoxzo::ORDER_DETAILS__TITLE__VOICE,
                'type' =>  Xoxzo::ORDER_DETAILS__TYPE__VOICE,
                'recipients' =>  Xoxzo::ORDER_DETAILS__RECIPIENTS__VOICE,
                'caller' =>  Xoxzo::ORDER_DETAILS__CALLER__VOICE,
                'playback' =>  Xoxzo::ORDER_DETAILS__PLAYBACK__VOICE,
                'tts' =>  Xoxzo::ORDER_DETAILS__TTS__VOICE,
                'template' => Xoxzo::MESSAGE_TEMPLATE__ORDER_DETAILS__VOICE,
            ),
            Xoxzo::VOICE_CUSTOMER_NOTE => array(
                'enabled' =>  Xoxzo::CUSTOMER_NOTE__ENABLED__VOICE,
                'title' =>  Xoxzo::CUSTOMER_NOTE__TITLE__VOICE,
                'type' =>  Xoxzo::CUSTOMER_NOTE__TYPE__VOICE,
                'recipients' =>  Xoxzo::CUSTOMER_NOTE__RECIPIENTS__VOICE,
                'caller' =>  Xoxzo::CUSTOMER_NOTE__CALLER__VOICE,
                'playback' =>  Xoxzo::CUSTOMER_NOTE__PLAYBACK__VOICE,
                'tts' =>  Xoxzo::CUSTOMER_NOTE__TTS__VOICE,
                'template' => Xoxzo::MESSAGE_TEMPLATE__CUSTOMER_NOTE__VOICE,
            ),
            Xoxzo::VOICE_RESET_PASSWORD => array(
                'enabled' =>  Xoxzo::RESET_PASSWORD__ENABLED__VOICE,
                'title' =>  Xoxzo::RESET_PASSWORD__TITLE__VOICE,
                'type' =>  Xoxzo::RESET_PASSWORD__TYPE__VOICE,
                'recipients' =>  Xoxzo::RESET_PASSWORD__RECIPIENTS__VOICE,
                'caller' =>  Xoxzo::RESET_PASSWORD__CALLER__VOICE,
                'playback' =>  Xoxzo::RESET_PASSWORD__PLAYBACK__VOICE,
                'tts' =>  Xoxzo::RESET_PASSWORD__TTS__VOICE,
                'template' => Xoxzo::MESSAGE_TEMPLATE__RESET_PASSWORD__VOICE,
            ),
            Xoxzo::VOICE_NEW_ACCOUNT => array(
                'enabled' =>  Xoxzo::NEW_ACCOUNT__ENABLED__VOICE,
                'title' =>  Xoxzo::NEW_ACCOUNT__TITLE__VOICE,
                'type' =>  Xoxzo::NEW_ACCOUNT__TYPE__VOICE,
                'recipients' =>  Xoxzo::NEW_ACCOUNT__RECIPIENTS__VOICE,
                'caller' =>  Xoxzo::NEW_ACCOUNT__CALLER__VOICE,
                'playback' =>  Xoxzo::NEW_ACCOUNT__PLAYBACK__VOICE,
                'tts' =>  Xoxzo::NEW_ACCOUNT__TTS__VOICE,
                'template' => Xoxzo::MESSAGE_TEMPLATE__NEW_ACCOUNT__VOICE,
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
        '{product_id}' => '',
        '{product_stock}' => '',
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
            '{product_id}' => '',
            '{product_stock}' => '',
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