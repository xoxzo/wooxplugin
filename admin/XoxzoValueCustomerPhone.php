<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit(0);
}

/**
 * ValueObject to make it easier to determine the recipient phone number for sms and voice notification.
 *
 * @since 1.0.0
 */
class XoxzoValueCustomerPhone {

    /**
     * The WC_Order object
     */
    private $order;

    /**
     * Class constructor
     *
     * Initialize using WC_Order object. Needed to check for guest or user account.
     *
     * @since 1.0.0
     *
     * @param WC_Order $order
     */
    public function __construct(\WC_Order $order) {
        $this->order = $order;
    }

    /**
     * Figure out the recipient phone number using $order->get_user() or user billing_phone meta
     *
     * @param XoxzoValueSms $sms
     *
     * @return array
     */
    public function sms(XoxzoValueSms $sms) {
        $order = $this->order;

        $user = null;
        if(!empty($order)) {
            $user = $order->get_user();
        }
        $user_recipients = [];
        /* Customer account, billing phone meta
         * */
        if(isset($user) and !empty($user)) {
            $user_recipients = $sms->user_recipient($user);
            if(empty($user_recipients) and property_exists ($order, "data")) {
                $billing_phone = $order->data['billing']['phone'];
                if(!empty($billing_phone)) {
                    $user_recipients[] = $order->data['billing']['phone'];
                }
            }
        }
        /* Guest. Try to look in order billing information
         * */
        else if(property_exists ($order, "data")) {
            $billing_phone = $order->data['billing']['phone'];
            if(!empty($billing_phone)) {
                $user_recipients[] = $order->data['billing']['phone'];
            }
        }
        return $user_recipients;
    }

    /**
     * Figure out the recipient phone number using $order->get_user() or user billing_phone meta
     *
     * @param XoxzoValueVoice $voice
     *
     * @return array
     */
    public function voice(XoxzoValueVoice $voice) {
        $order = $this->order;

        $user = null;
        if(!empty($order)) {
            $user = $order->get_user();
        }
        $user_recipients = [];
        /* Customer account, billing phone meta
         * */
        if(isset($user) and !empty($user)) {
            $user_recipients = $voice->user_recipient($user);
            if(empty($user_recipients) and property_exists ($order, "data")) {
                $billing_phone = $order->data['billing']['phone'];
                if(!empty($billing_phone)) {
                    $user_recipients[] = $order->data['billing']['phone'];
                }
            }
        }
        /* Guest. Try to look in order billing information
         * */
        else if(property_exists ($order, "data")) {
            $billing_phone = $order->data['billing']['phone'];
            if(!empty($billing_phone)) {
                $user_recipients[] = $order->data['billing']['phone'];
            }
        }
        return $user_recipients;
    }
}