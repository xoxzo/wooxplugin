<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit(0);
}

class XoxzoAdminSettingOptions {

    public static function get($section) {
        if(in_array($section, [Xoxzo::ADMIN_SECTION_BASIC, ""])) {
            return self::section_basic();
        }
        else if($section===Xoxzo::SETTING__CUSTOM_EVENT__SMS) {
            return self::sms__custom_event();
        }
        else if($section===Xoxzo::SETTING__NEW__SMS) {
            return self::sms__new();
        }
        else if($section===Xoxzo::SETTING__CANCELLED__SMS) {
            return self::sms__cancelled();
        }
        else if($section===Xoxzo::SETTING__FAILED__SMS) {
            return self::sms__failed();
        }
        else if($section===Xoxzo::SETTING__ON_HOLD__SMS) {
            return self::sms__on_hold();
        }
        else if($section===Xoxzo::SETTING__PROCESSING__SMS) {
            return self::sms__processing();
        }
        else if($section===Xoxzo::SETTING__COMPLETED__SMS) {
            return self::sms__completed();
        }
        else if($section===Xoxzo::SETTING__FULLY_REFUNDED__SMS) {
            return self::sms__fully_refunded();
        }
        else if($section===Xoxzo::SETTING__PARTIALLY_REFUNDED__SMS) {
            return self::sms__partially_refunded();
        }
        else if($section===Xoxzo::SETTING__LOW_STOCK__SMS) {
            return self::sms__low_stock();
        }
        else if($section===Xoxzo::SETTING__NO_STOCK__SMS) {
            return self::sms__no_stock();
        }
        else if($section===Xoxzo::SETTING__ORDER_DETAILS__SMS) {
            return self::sms__order_detail();
        }
        else if($section===Xoxzo::SETTING__CUSTOMER_NOTE__SMS) {
            return self::sms__customer_note();
        }
        else if($section===Xoxzo::SETTING__RESET_PASSWORD__SMS) {
            return self::sms__reset_password();
        }
        else if($section===Xoxzo::SETTING__NEW_ACCOUNT__SMS) {
            return self::sms__new_account();
        }
        else if($section===Xoxzo::SETTING__CUSTOM_EVENT__VOICE) {
            return self::voice__custom_event();
        }
        else if($section===Xoxzo::SETTING__NEW__VOICE) {
            return self::voice__new();
        }
        else if($section===Xoxzo::SETTING__CANCELLED__VOICE) {
            return self::voice__cancelled();
        }
        else if($section===Xoxzo::SETTING__FAILED__VOICE) {
            return self::voice__failed();
        }
        else if($section===Xoxzo::SETTING__ON_HOLD__VOICE) {
            return self::voice__on_hold();
        }
        else if($section===Xoxzo::SETTING__PROCESSING__VOICE) {
            return self::voice__processing();
        }
        else if($section===Xoxzo::SETTING__COMPLETED__VOICE) {
            return self::voice__completed();
        }
        else if($section===Xoxzo::SETTING__FULLY_REFUNDED__VOICE) {
            return self::voice__fully_refunded();
        }
        else if($section===Xoxzo::SETTING__PARTIALLY_REFUNDED__VOICE) {
            return self::voice__partially_refunded();
        }
        else if($section===Xoxzo::SETTING__LOW_STOCK__VOICE) {
            return self::voice__low_stock();
        }
        else if($section===Xoxzo::SETTING__NO_STOCK__VOICE) {
            return self::voice__no_stock();
        }
        else if($section===Xoxzo::SETTING__ORDER_DETAILS__VOICE) {
            return self::voice__order_detail();
        }
        else if($section===Xoxzo::SETTING__CUSTOMER_NOTE__VOICE) {
            return self::voice__customer_note();
        }
        else if($section===Xoxzo::SETTING__RESET_PASSWORD__VOICE) {
            return self::voice__reset_password();
        }
        else if($section===Xoxzo::SETTING__NEW_ACCOUNT__VOICE) {
            return self::voice__new_account();
        }
    }

    private static function section_basic() {
        return array(
            array(
                'title'         => __( 'API Authentication', Xoxzo::TEXT_DOMAIN ),
                'type'          => 'title',
                'desc'          => sprintf( __( 'Can\'t find your API key? <a href="%s" target="_blank">Click here to see how to find it</a>.', 'woocommerce' ), wp_nonce_url( "https://blog.xoxzo.com/en/2017/10/31/sending-your-first-sms" ) ),
                'id'            => 'api_option',
            ),
            array(
                'title'         => __( 'SID name', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Login to your xoxzo account, and find the SID under "Account > API Users". If it is empty, you need to create an API User.', Xoxzo::TEXT_DOMAIN ),
                'id'            => 'woocommerce_xoxzo_sid',
                'placeholder'   => '(Field Required)',
                'type'          => 'text',
                'default'       => esc_attr( get_option( 'woocommerce_xoxzo_sid' ) ),
                'autoload'      => false,
                'desc_tip'      => true,
            ),
            array(
                'title'         => __( 'Auth Token', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Login to your xoxzo account, and find the \'Auth Token\' under "Account > API Users". If it is empty, you need to create an API User.', Xoxzo::TEXT_DOMAIN ),
                'id'            => 'woocommerce_xoxzo_auth_token',
                'placeholder'   => '(Field Required)',
                'type'          => 'password',
                'default'       => str_pad("", strlen(get_option( 'woocommerce_xoxzo_auth_token' )), "*", STR_PAD_RIGHT),
                'autoload'      => false,
                'desc_tip'      => true,
            ),
            array(
                'title'         => __( 'Sender ID (Only for sms)', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Sender id for your sms. Defaults to \'Xoxzo\'', Xoxzo::TEXT_DOMAIN ),
                'id'            => 'woocommerce_xoxzo_sender_id',
                'placeholder'   => 'Default: Xoxzo1',
                'type'          => 'text',
                'default'       => esc_attr( get_option( 'woocommerce_xoxzo_sender_id' ) ),
                'autoload'      => false,
                'desc_tip'      => true,
            ),
            array(
                'type' => 'sectionend',
                'id'   => 'xoxzo_options',
            ),
        );
    }

    private static function sms__custom_event() {
        return array(
            array(
                'title' => __( 'Sms: custom message', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Customize a message and immediately send to recipient(s).',
            ),
            array(
                'title'    => __( 'Recipient(s)', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The recipient\'s phone no.', Xoxzo::TEXT_DOMAIN ),
                'type'     => 'text',
                'placeholder'  => '+60123456789,+6019876543',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Add the message your want to send. Defaults to placeholder.', Xoxzo::TEXT_DOMAIN ),
                'type'     => 'textarea_custom',
                'placeholder' => 'Hello World!',
                'default' => 'Hello World!',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function sms__new() {
        return array(
            array(
                'title' => __( 'New order', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'New order will trigger the sms to be sent for chosen recipient(s) when a new order is received.',
                'id'    => Xoxzo::NEW__TITLE__SMS,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::NEW__ENABLED__SMS,
                'default'       =>  get_option(Xoxzo::NEW__ENABLED__SMS) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'    => __( 'Recipient(s)', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The recipient\'s phone no.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::NEW__RECIPIENTS__SMS,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::NEW__RECIPIENTS__SMS ) ),
                'placeholder'  => '+60123456789,+6019876543',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Add the message your want to send. Defaults to placeholder.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::NEW__MESSAGE__SMS,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__NEW__SMS,
                'default' => Xoxzo::MESSAGE_TEMPLATE__NEW__SMS,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function sms__cancelled() {
        return array(
            array(
                'title' => __( 'Cancelled order', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Cancelled order will trigger the sms to be sent for chosen recipient(s) when orders have been marked cancelled.',
                'id'    => Xoxzo::CANCELLED__TITLE__SMS,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::CANCELLED__ENABLED__SMS,
                'default'       =>  get_option(Xoxzo::CANCELLED__ENABLED__SMS) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'    => __( 'Recipient(s)', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The recipient\'s phone no.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::CANCELLED__RECIPIENTS__SMS,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::CANCELLED__RECIPIENTS__SMS ) ),
                'placeholder'  => '+60123456789,+6019876543',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Add the message your want to send. Defaults to placeholder.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::CANCELLED__MESSAGE__SMS,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__CANCELLED__SMS,
                'default' => Xoxzo::MESSAGE_TEMPLATE__CANCELLED__SMS,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function sms__failed() {
        return array(
            array(
                'title' => __( 'Failed order', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Failed order will trigger the sms to be sent for chosen recipient(s) when orders have been marked failed.',
                'id'    => Xoxzo::FAILED__TITLE__SMS,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::FAILED__ENABLED__SMS,
                'default'       =>  get_option(Xoxzo::FAILED__ENABLED__SMS) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'    => __( 'Recipient(s)', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The recipient\'s phone no.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::FAILED__RECIPIENTS__SMS,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::FAILED__RECIPIENTS__SMS ) ),
                'placeholder'  => '+60123456789,+6019876543',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Add the message your want to send. Defaults to placeholder.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::FAILED__MESSAGE__SMS,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__FAILED__SMS,
                'default' => Xoxzo::MESSAGE_TEMPLATE__FAILED__SMS,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function sms__on_hold() {
        return array(
            array(
                'title' => __( 'On-hold order', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'This sms is sent for customers containing order details after an order is placed on-hold.',
                'id'    => Xoxzo::ON_HOLD__TITLE__SMS,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::ON_HOLD__ENABLED__SMS,
                'default'       =>  get_option(Xoxzo::ON_HOLD__ENABLED__SMS) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'    => __( 'Message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Add the message your want to send. Defaults to placeholder.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::ON_HOLD__MESSAGE__SMS,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__ON_HOLD__SMS,
                'default' => Xoxzo::MESSAGE_TEMPLATE__ON_HOLD__SMS,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function sms__processing() {
        return array(
            array(
                'title' => __( 'Processing order', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'This sms is sent for customers containing order details after payment.',
                'id'    => Xoxzo::PROCESSING__TITLE__SMS,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::PROCESSING__ENABLED__SMS,
                'default'       =>  get_option(Xoxzo::PROCESSING__ENABLED__SMS) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'    => __( 'Message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Add the message your want to send. Defaults to placeholder.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::PROCESSING__MESSAGE__SMS,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__PROCESSING__SMS,
                'default' => Xoxzo::MESSAGE_TEMPLATE__PROCESSING__SMS,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function sms__completed() {
        return array(
            array(
                'title' => __( 'Completed order', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Order complete sms are sent to customers when their orders are marked completed and usually indicate that their orders have been shipped.',
                'id'    => Xoxzo::COMPLETED__TITLE__SMS,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::COMPLETED__ENABLED__SMS,
                'default'       =>  get_option(Xoxzo::COMPLETED__ENABLED__SMS) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'    => __( 'Message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Add the message your want to send. Defaults to placeholder.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::COMPLETED__MESSAGE__SMS,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__COMPLETED__SMS,
                'default' => Xoxzo::MESSAGE_TEMPLATE__COMPLETED__SMS,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function sms__fully_refunded() {
        return array(
            array(
                'title' => __( 'Fully refunded order', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Order fully refunded sms are sent to customers when their orders are fully refunded.',
                'id'    => Xoxzo::FULLY_REFUNDED__TITLE__SMS,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::FULLY_REFUNDED__ENABLED__SMS,
                'default'       =>  get_option(Xoxzo::FULLY_REFUNDED__ENABLED__SMS) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'    => __( 'Message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Add the message your want to send. Defaults to placeholder.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::FULLY_REFUNDED__MESSAGE__SMS,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__FULLY_REFUNDED__SMS,
                'default' => Xoxzo::MESSAGE_TEMPLATE__FULLY_REFUNDED__SMS,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function sms__partially_refunded() {
        return array(
            array(
                'title' => __( 'Partially refunded order', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Order partially refunded are sent to customers when their orders are partially refunded.',
                'id'    => Xoxzo::PARTIALLY_REFUNDED__TITLE__SMS,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::PARTIALLY_REFUNDED__ENABLED__SMS,
                'default'       =>  get_option(Xoxzo::PARTIALLY_REFUNDED__ENABLED__SMS) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'    => __( 'Message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Add the message your want to send. Defaults to placeholder.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::PARTIALLY_REFUNDED__MESSAGE__SMS,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__PARTIALLY_REFUNDED__SMS,
                'default' => Xoxzo::MESSAGE_TEMPLATE__PARTIALLY_REFUNDED__SMS,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function sms__low_stock() {
        return array(
            array(
                'title' => __( 'Low stock', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Low stock of a product will trigger the sms to be sent for chosen recipient(s).',
                'id'    => Xoxzo::LOW_STOCK__TITLE__SMS,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::LOW_STOCK__ENABLED__SMS,
                'default'       =>  get_option(Xoxzo::LOW_STOCK__ENABLED__SMS) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'    => __( 'Recipient(s)', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The recipient\'s phone no.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::LOW_STOCK__RECIPIENTS__SMS,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::LOW_STOCK__RECIPIENTS__SMS ) ),
                'placeholder'  => '+60123456789,+6019876543',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Add the message your want to send. Defaults to placeholder.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::LOW_STOCK__MESSAGE__SMS,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__LOW_STOCK__SMS,
                'default' => Xoxzo::MESSAGE_TEMPLATE__LOW_STOCK__SMS,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function sms__no_stock() {
        return array(
            array(
                'title' => __( 'No stock', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'No stock of a product will trigger the sms to be sent for chosen recipient(s).',
                'id'    => Xoxzo::NO_STOCK__TITLE__SMS,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::NO_STOCK__ENABLED__SMS,
                'default'       =>  get_option(Xoxzo::NO_STOCK__ENABLED__SMS) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'    => __( 'Recipient(s)', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The recipient\'s phone no.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::NO_STOCK__RECIPIENTS__SMS,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::NO_STOCK__RECIPIENTS__SMS ) ),
                'placeholder'  => '+60123456789,+6019876543',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Add the message your want to send. Defaults to placeholder.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::NO_STOCK__MESSAGE__SMS,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__NO_STOCK__SMS,
                'default' => Xoxzo::MESSAGE_TEMPLATE__NO_STOCK__SMS,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function sms__order_detail() {
        return array(
            array(
                'title' => __( 'Order details', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Order details sms are sent to customers containing their order information and payment links.',
                'id'    => Xoxzo::ORDER_DETAILS__TITLE__SMS,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::ORDER_DETAILS__ENABLED__SMS,
                'default'       =>  get_option(Xoxzo::ORDER_DETAILS__ENABLED__SMS) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'    => __( 'Message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Add the message your want to send. Defaults to placeholder.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::ORDER_DETAILS__MESSAGE__SMS,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__ORDER_DETAILS__SMS,
                'default' => Xoxzo::MESSAGE_TEMPLATE__ORDER_DETAILS__SMS,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function sms__customer_note() {
        return array(
            array(
                'title' => __( 'Customer note', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Customer note sms are sent to customer when you add a note to an order.',
                'id'    => Xoxzo::CUSTOMER_NOTE__TITLE__SMS,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::CUSTOMER_NOTE__ENABLED__SMS,
                'default'       =>  get_option(Xoxzo::CUSTOMER_NOTE__ENABLED__SMS) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'    => __( 'Message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Add the message your want to send. Defaults to placeholder.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::CUSTOMER_NOTE__MESSAGE__SMS,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__CUSTOMER_NOTE__SMS,
                'default' => Xoxzo::MESSAGE_TEMPLATE__CUSTOMER_NOTE__SMS,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function sms__reset_password() {
        return array(
            array(
                'title' => __( 'Reset password', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Customer "reset password" sms are sent when customers reset their passwords.',
                'id'    => Xoxzo::RESET_PASSWORD__TITLE__SMS,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::RESET_PASSWORD__ENABLED__SMS,
                'default'       =>  get_option(Xoxzo::RESET_PASSWORD__ENABLED__SMS) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'    => __( 'Message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Add the message your want to send. Defaults to placeholder.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::RESET_PASSWORD__MESSAGE__SMS,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__RESET_PASSWORD__SMS,
                'default' => Xoxzo::MESSAGE_TEMPLATE__RESET_PASSWORD__SMS,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );;
    }

    private static function sms__new_account() {
        return array(
            array(
                'title' => __( 'New account', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Customer "new account" sms sent to the customer when a customer signs up via checkout or account pages.',
                'id'    => Xoxzo::NEW_ACCOUNT__TITLE__SMS,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::NEW_ACCOUNT__ENABLED__SMS,
                'default'       =>  get_option(Xoxzo::NEW_ACCOUNT__ENABLED__SMS) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'    => __( 'Message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Add the message your want to send. Defaults to placeholder.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::NEW_ACCOUNT__MESSAGE__SMS,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__NEW_ACCOUNT__SMS,
                'default' => Xoxzo::MESSAGE_TEMPLATE__NEW_ACCOUNT__SMS,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function voice__custom_event() {
        return array(
            array(
                'title' => __( 'Voice: custom message', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Customize a message and immediately send to recipient(s).',
            ),
            array(
                'title'     => __( 'Type', Xoxzo::TEXT_DOMAIN ),
                'name'      => 'type',
                'desc'      => __( 'Choose the notification type you will want this event to trigger', Xoxzo::TEXT_DOMAIN ),
                'class'     => 'wc-notification-select',
                'type'      => 'select',
                'options'  => array(
                    'tts'   => __( 'TTS (Text To Speech)', Xoxzo::TEXT_DOMAIN ),
                    'playback'  => __( 'Audio Playback', Xoxzo::TEXT_DOMAIN ),
                ),
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Caller', Xoxzo::TEXT_DOMAIN ),
                'name'     => 'caller',
                'desc'     => __( 'The caller, required by Xoxzo', Xoxzo::TEXT_DOMAIN ),
                'type'     => 'text',
                'placeholder'  => '+60123456789 (Required)',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Recipient(s)', Xoxzo::TEXT_DOMAIN ),
                'name'     => 'recipients',
                'desc'     => __( 'The recipient\'s phone no.', Xoxzo::TEXT_DOMAIN ),
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::NEW__RECIPIENTS__VOICE ) ),
                'placeholder'  => '+60123456789,+6019876543',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Playback MP3 location', Xoxzo::TEXT_DOMAIN ),
                'name'     => 'playback',
                'desc'     => __( 'The location of the mp3 to be played. (Must be public link)', Xoxzo::TEXT_DOMAIN ),
                'type'     => 'textarea',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'TTS message', Xoxzo::TEXT_DOMAIN ),
                'name'     => 'tts',
                'desc'     => __( 'Xoxzo\'s TTS service will automatically convert this into audio', Xoxzo::TEXT_DOMAIN ),
                'type'     => 'textarea_custom',
                'placeholder' => 'Hello World!',
                'default' => 'Hello World!',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function voice__new() {
        return array(
            array(
                'title' => __( 'New order', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'New order will trigger the tts/playback to be played for chosen recipient(s) when a new order is received.',
                'id'    => Xoxzo::NEW__TITLE__VOICE,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::NEW__ENABLED__VOICE,
                'default'       =>  get_option(Xoxzo::NEW__ENABLED__VOICE) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'     => __( 'Type', Xoxzo::TEXT_DOMAIN ),
                'desc'      => __( 'Choose the notification type you will want this event to trigger', Xoxzo::TEXT_DOMAIN ),
                'id'        => Xoxzo::NEW__TYPE__VOICE,
                'class'     => 'wc-notification-select',
                'default'   => get_option(Xoxzo::NEW__TYPE__VOICE),
                'type'      => 'select',
                'options'  => array(
                    'tts'   => __( 'TTS (Text To Speech)', Xoxzo::TEXT_DOMAIN ),
                    'playback'  => __( 'Audio Playback', Xoxzo::TEXT_DOMAIN ),
                ),
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Caller', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The caller, required by Xoxzo', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::NEW__CALLER__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::NEW__CALLER__VOICE ) ),
                'placeholder'  => '+60123456789 (Required)',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Recipient(s)', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The recipient\'s phone no.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::NEW__RECIPIENTS__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::NEW__RECIPIENTS__VOICE ) ),
                'placeholder'  => '+60123456789,+6019876543',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Playback MP3 location', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The location of the mp3 to be played. (Must be public link)', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::NEW__PLAYBACK__VOICE,
                'type'     => 'textarea',
                'default'  => esc_attr( get_option( Xoxzo::NEW__PLAYBACK__VOICE ) ),
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'TTS message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Xoxzo\'s TTS service will automatically convert this into audio', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::NEW__TTS__VOICE,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__NEW__VOICE,
                'default' => Xoxzo::MESSAGE_TEMPLATE__NEW__VOICE,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function voice__cancelled() {
        return array(
            array(
                'title' => __( 'Cancelled order', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Cancelled order will trigger the tts/playback to be played for chosen recipient(s) when orders have been marked cancelled.',
                'id'    => Xoxzo::CANCELLED__TITLE__VOICE,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::CANCELLED__ENABLED__VOICE,
                'default'       =>  get_option(Xoxzo::CANCELLED__ENABLED__VOICE) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'     => __( 'Type', Xoxzo::TEXT_DOMAIN ),
                'desc'      => __( 'Choose the notification type you will want this event to trigger', Xoxzo::TEXT_DOMAIN ),
                'id'        => Xoxzo::CANCELLED__TYPE__VOICE,
                'class'     => 'wc-notification-select',
                'default'   => get_option(Xoxzo::CANCELLED__TYPE__VOICE),
                'type'      => 'select',
                'options'  => array(
                    'tts'   => __( 'TTS (Text To Speech)', Xoxzo::TEXT_DOMAIN ),
                    'playback'  => __( 'Audio Playback', Xoxzo::TEXT_DOMAIN ),
                ),
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Caller', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The caller, required by Xoxzo', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::CANCELLED__CALLER__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::CANCELLED__CALLER__VOICE ) ),
                'placeholder'  => '+60123456789 (Required)',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Recipient(s)', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The recipient\'s phone no.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::CANCELLED__RECIPIENTS__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::CANCELLED__RECIPIENTS__VOICE ) ),
                'placeholder'  => '+60123456789,+6019876543',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Playback MP3 location', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The location of the mp3 to be played. (Must be public link)', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::CANCELLED__PLAYBACK__VOICE,
                'type'     => 'textarea',
                'default'  => esc_attr( get_option( Xoxzo::CANCELLED__PLAYBACK__VOICE ) ),
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'TTS message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Xoxzo\'s TTS service will automatically convert this into audio', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::CANCELLED__TTS__VOICE,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__CANCELLED__VOICE,
                'default' => Xoxzo::MESSAGE_TEMPLATE__CANCELLED__VOICE,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function voice__failed() {
        return array(
            array(
                'title' => __( 'Failed order', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Failed order will trigger the tts/playback to be played for chosen recipient(s) when orders have been marked failed.',
                'id'    => Xoxzo::FAILED__TITLE__VOICE,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::FAILED__ENABLED__VOICE,
                'default'       =>  get_option(Xoxzo::FAILED__ENABLED__VOICE) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'     => __( 'Type', Xoxzo::TEXT_DOMAIN ),
                'desc'      => __( 'Choose the notification type you will want this event to trigger', Xoxzo::TEXT_DOMAIN ),
                'id'        => Xoxzo::FAILED__TYPE__VOICE,
                'class'     => 'wc-notification-select',
                'default'   => get_option(Xoxzo::FAILED__TYPE__VOICE),
                'type'      => 'select',
                'options'  => array(
                    'tts'   => __( 'TTS (Text To Speech)', Xoxzo::TEXT_DOMAIN ),
                    'playback'  => __( 'Audio Playback', Xoxzo::TEXT_DOMAIN ),
                ),
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Caller', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The caller, required by Xoxzo', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::FAILED__CALLER__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::FAILED__CALLER__VOICE ) ),
                'placeholder'  => '+60123456789 (Required)',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Recipient(s)', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The recipient\'s phone no.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::FAILED__RECIPIENTS__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::FAILED__RECIPIENTS__VOICE ) ),
                'placeholder'  => '+60123456789,+6019876543',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Playback MP3 location', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The location of the mp3 to be played. (Must be public link)', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::FAILED__PLAYBACK__VOICE,
                'type'     => 'textarea',
                'default'  => esc_attr( get_option( Xoxzo::FAILED__PLAYBACK__VOICE ) ),
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'TTS message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Xoxzo\'s TTS service will automatically convert this into audio', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::FAILED__TTS__VOICE,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__FAILED__VOICE,
                'default' => Xoxzo::MESSAGE_TEMPLATE__FAILED__VOICE,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function voice__on_hold() {
        return array(
            array(
                'title' => __( 'On-hold order', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'This tts/playback is played for customers containing order details after an order is placed on-hold.',
                'id'    => Xoxzo::ON_HOLD__TITLE__VOICE,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::ON_HOLD__ENABLED__VOICE,
                'default'       =>  get_option(Xoxzo::ON_HOLD__ENABLED__VOICE) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'     => __( 'Type', Xoxzo::TEXT_DOMAIN ),
                'desc'      => __( 'Choose the notification type you will want this event to trigger', Xoxzo::TEXT_DOMAIN ),
                'id'        => Xoxzo::ON_HOLD__TYPE__VOICE,
                'class'     => 'wc-notification-select',
                'default'   => get_option(Xoxzo::ON_HOLD__TYPE__VOICE),
                'type'      => 'select',
                'options'  => array(
                    'tts'   => __( 'TTS (Text To Speech)', Xoxzo::TEXT_DOMAIN ),
                    'playback'  => __( 'Audio Playback', Xoxzo::TEXT_DOMAIN ),
                ),
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Caller', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The caller, required by Xoxzo', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::ON_HOLD__CALLER__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::ON_HOLD__CALLER__VOICE ) ),
                'placeholder'  => '+60123456789 (Required)',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Playback MP3 location', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The location of the mp3 to be played. (Must be public link)', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::ON_HOLD__PLAYBACK__VOICE,
                'type'     => 'textarea',
                'default'  => esc_attr( get_option( Xoxzo::ON_HOLD__PLAYBACK__VOICE ) ),
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'TTS message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Xoxzo\'s TTS service will automatically convert this into audio', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::ON_HOLD__TTS__VOICE,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__ON_HOLD__VOICE,
                'default' => Xoxzo::MESSAGE_TEMPLATE__ON_HOLD__VOICE,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function voice__processing() {
        return array(
            array(
                'title' => __( 'Processing order', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'This tts/playback is played for customers containing order details after payment.',
                'id'    => Xoxzo::PROCESSING__TITLE__VOICE,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::PROCESSING__ENABLED__VOICE,
                'default'       =>  get_option(Xoxzo::PROCESSING__ENABLED__VOICE) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'     => __( 'Type', Xoxzo::TEXT_DOMAIN ),
                'desc'      => __( 'Choose the notification type you will want this event to trigger', Xoxzo::TEXT_DOMAIN ),
                'id'        => Xoxzo::PROCESSING__TYPE__VOICE,
                'class'     => 'wc-notification-select',
                'default'   => get_option(Xoxzo::PROCESSING__TYPE__VOICE),
                'type'      => 'select',
                'options'  => array(
                    'tts'   => __( 'TTS (Text To Speech)', Xoxzo::TEXT_DOMAIN ),
                    'playback'  => __( 'Audio Playback', Xoxzo::TEXT_DOMAIN ),
                ),
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Caller', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The caller, required by Xoxzo', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::PROCESSING__CALLER__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::PROCESSING__CALLER__VOICE ) ),
                'placeholder'  => '+60123456789 (Required)',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Playback MP3 location', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The location of the mp3 to be played. (Must be public link)', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::PROCESSING__PLAYBACK__VOICE,
                'type'     => 'textarea',
                'default'  => esc_attr( get_option( Xoxzo::PROCESSING__PLAYBACK__VOICE ) ),
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'TTS message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Xoxzo\'s TTS service will automatically convert this into audio', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::PROCESSING__TTS__VOICE,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__PROCESSING__VOICE,
                'default' => Xoxzo::MESSAGE_TEMPLATE__PROCESSING__VOICE,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function voice__completed() {
        return array(
            array(
                'title' => __( 'Completed order', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Order complete tts/playback are sent to customers when their orders are marked completed and usually indicate that their orders have been shipped.',
                'id'    => Xoxzo::COMPLETED__TITLE__VOICE,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::COMPLETED__ENABLED__VOICE,
                'default'       =>  get_option(Xoxzo::COMPLETED__ENABLED__VOICE) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'     => __( 'Type', Xoxzo::TEXT_DOMAIN ),
                'desc'      => __( 'Choose the notification type you will want this event to trigger', Xoxzo::TEXT_DOMAIN ),
                'id'        => Xoxzo::COMPLETED__TYPE__VOICE,
                'class'     => 'wc-notification-select',
                'default'   => get_option(Xoxzo::COMPLETED__TYPE__VOICE),
                'type'      => 'select',
                'options'  => array(
                    'tts'   => __( 'TTS (Text To Speech)', Xoxzo::TEXT_DOMAIN ),
                    'playback'  => __( 'Audio Playback', Xoxzo::TEXT_DOMAIN ),
                ),
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Caller', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The caller, required by Xoxzo', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::COMPLETED__CALLER__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::COMPLETED__CALLER__VOICE ) ),
                'placeholder'  => '+60123456789 (Required)',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Playback MP3 location', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The location of the mp3 to be played. (Must be public link)', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::COMPLETED__PLAYBACK__VOICE,
                'type'     => 'textarea',
                'default'  => esc_attr( get_option( Xoxzo::COMPLETED__PLAYBACK__VOICE ) ),
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'TTS message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Xoxzo\'s TTS service will automatically convert this into audio', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::COMPLETED__TTS__VOICE,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__COMPLETED__VOICE,
                'default' => Xoxzo::MESSAGE_TEMPLATE__COMPLETED__VOICE,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function voice__fully_refunded() {
        return array(
            array(
                'title' => __( 'Fully refunded order', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Order fully refunded tts/playback are played to customers when their orders are fully refunded.',
                'id'    => Xoxzo::FULLY_REFUNDED__TITLE__VOICE,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::FULLY_REFUNDED__ENABLED__VOICE,
                'default'       =>  get_option(Xoxzo::FULLY_REFUNDED__ENABLED__VOICE) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'     => __( 'Type', Xoxzo::TEXT_DOMAIN ),
                'desc'      => __( 'Choose the notification type you will want this event to trigger', Xoxzo::TEXT_DOMAIN ),
                'id'        => Xoxzo::FULLY_REFUNDED__TYPE__VOICE,
                'class'     => 'wc-notification-select',
                'default'   => get_option(Xoxzo::FULLY_REFUNDED__TYPE__VOICE),
                'type'      => 'select',
                'options'  => array(
                    'tts'   => __( 'TTS (Text To Speech)', Xoxzo::TEXT_DOMAIN ),
                    'playback'  => __( 'Audio Playback', Xoxzo::TEXT_DOMAIN ),
                ),
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Caller', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The caller, required by Xoxzo', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::FULLY_REFUNDED__CALLER__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::FULLY_REFUNDED__CALLER__VOICE ) ),
                'placeholder'  => '+60123456789 (Required)',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Playback MP3 location', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The location of the mp3 to be played. (Must be public link)', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::FULLY_REFUNDED__PLAYBACK__VOICE,
                'type'     => 'textarea',
                'default'  => esc_attr( get_option( Xoxzo::FULLY_REFUNDED__PLAYBACK__VOICE ) ),
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'TTS message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Xoxzo\'s TTS service will automatically convert this into audio', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::FULLY_REFUNDED__TTS__VOICE,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__FULLY_REFUNDED__VOICE,
                'default' => Xoxzo::MESSAGE_TEMPLATE__FULLY_REFUNDED__VOICE,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function voice__partially_refunded() {
        return array(
            array(
                'title' => __( 'Partially refunded order', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Order partially refunded tts/playback are played to customers when their orders are partially refunded.',
                'id'    => Xoxzo::PARTIALLY_REFUNDED__TITLE__VOICE,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::PARTIALLY_REFUNDED__ENABLED__VOICE,
                'default'       =>  get_option(Xoxzo::PARTIALLY_REFUNDED__ENABLED__VOICE) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'     => __( 'Type', Xoxzo::TEXT_DOMAIN ),
                'desc'      => __( 'Choose the notification type you will want this event to trigger', Xoxzo::TEXT_DOMAIN ),
                'id'        => Xoxzo::PARTIALLY_REFUNDED__TYPE__VOICE,
                'class'     => 'wc-notification-select',
                'default'   => get_option(Xoxzo::PARTIALLY_REFUNDED__TYPE__VOICE),
                'type'      => 'select',
                'options'  => array(
                    'tts'   => __( 'TTS (Text To Speech)', Xoxzo::TEXT_DOMAIN ),
                    'playback'  => __( 'Audio Playback', Xoxzo::TEXT_DOMAIN ),
                ),
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Caller', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The caller, required by Xoxzo', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::PARTIALLY_REFUNDED__CALLER__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::PARTIALLY_REFUNDED__CALLER__VOICE ) ),
                'placeholder'  => '+60123456789 (Required)',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Playback MP3 location', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The location of the mp3 to be played. (Must be public link)', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::PARTIALLY_REFUNDED__PLAYBACK__VOICE,
                'type'     => 'textarea',
                'default'  => esc_attr( get_option( Xoxzo::PARTIALLY_REFUNDED__PLAYBACK__VOICE ) ),
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'TTS message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Xoxzo\'s TTS service will automatically convert this into audio', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::PARTIALLY_REFUNDED__TTS__VOICE,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__PARTIALLY_REFUNDED__VOICE,
                'default' => Xoxzo::MESSAGE_TEMPLATE__PARTIALLY_REFUNDED__VOICE,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function voice__low_stock() {
        return array(
            array(
                'title' => __( 'Low stock', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Low stock of a product will trigger the tts/playback to be played for chosen recipient(s).',
                'id'    => Xoxzo::LOW_STOCK__TITLE__VOICE,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::LOW_STOCK__ENABLED__VOICE,
                'default'       =>  get_option(Xoxzo::LOW_STOCK__ENABLED__VOICE) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'     => __( 'Type', Xoxzo::TEXT_DOMAIN ),
                'desc'      => __( 'Choose the notification type you will want this event to trigger', Xoxzo::TEXT_DOMAIN ),
                'id'        => Xoxzo::LOW_STOCK__TYPE__VOICE,
                'class'     => 'wc-notification-select',
                'default'   => get_option(Xoxzo::LOW_STOCK__TYPE__VOICE),
                'type'      => 'select',
                'options'  => array(
                    'tts'   => __( 'TTS (Text To Speech)', Xoxzo::TEXT_DOMAIN ),
                    'playback'  => __( 'Audio Playback', Xoxzo::TEXT_DOMAIN ),
                ),
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Caller', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The caller, required by Xoxzo', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::LOW_STOCK__CALLER__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::LOW_STOCK__CALLER__VOICE ) ),
                'placeholder'  => '+60123456789 (Required)',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Recipient(s)', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The recipient\'s phone no.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::LOW_STOCK__RECIPIENTS__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::LOW_STOCK__RECIPIENTS__VOICE ) ),
                'placeholder'  => '+60123456789,+6019876543',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Playback MP3 location', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The location of the mp3 to be played. (Must be public link)', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::LOW_STOCK__PLAYBACK__VOICE,
                'type'     => 'textarea',
                'default'  => esc_attr( get_option( Xoxzo::LOW_STOCK__PLAYBACK__VOICE ) ),
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'TTS message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Xoxzo\'s TTS service will automatically convert this into audio', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::LOW_STOCK__TTS__VOICE,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__LOW_STOCK__VOICE,
                'default' => Xoxzo::MESSAGE_TEMPLATE__LOW_STOCK__VOICE,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function voice__no_stock() {
        return array(
            array(
                'title' => __( 'No stock', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'No stock of a product will trigger the tts/playback to be played for chosen recipient(s).',
                'id'    => Xoxzo::NO_STOCK__TITLE__VOICE,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::NO_STOCK__ENABLED__VOICE,
                'default'       =>  get_option(Xoxzo::NO_STOCK__ENABLED__VOICE) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'     => __( 'Type', Xoxzo::TEXT_DOMAIN ),
                'desc'      => __( 'Choose the notification type you will want this event to trigger', Xoxzo::TEXT_DOMAIN ),
                'id'        => Xoxzo::NO_STOCK__TYPE__VOICE,
                'class'     => 'wc-notification-select',
                'default'   => get_option(Xoxzo::NO_STOCK__TYPE__VOICE),
                'type'      => 'select',
                'options'  => array(
                    'tts'   => __( 'TTS (Text To Speech)', Xoxzo::TEXT_DOMAIN ),
                    'playback'  => __( 'Audio Playback', Xoxzo::TEXT_DOMAIN ),
                ),
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Caller', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The caller, required by Xoxzo', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::NO_STOCK__CALLER__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::NO_STOCK__CALLER__VOICE ) ),
                'placeholder'  => '+60123456789 (Required)',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Recipient(s)', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The recipient\'s phone no.', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::NO_STOCK__RECIPIENTS__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::NO_STOCK__RECIPIENTS__VOICE ) ),
                'placeholder'  => '+60123456789,+6019876543',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Playback MP3 location', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The location of the mp3 to be played. (Must be public link)', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::NO_STOCK__PLAYBACK__VOICE,
                'type'     => 'textarea',
                'default'  => esc_attr( get_option( Xoxzo::NO_STOCK__PLAYBACK__VOICE ) ),
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'TTS message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Xoxzo\'s TTS service will automatically convert this into audio', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::NO_STOCK__TTS__VOICE,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__NO_STOCK__VOICE,
                'default' => Xoxzo::MESSAGE_TEMPLATE__NO_STOCK__VOICE,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function voice__order_detail() {
        return array(
            array(
                'title' => __( 'Order details', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Order details tts/playback is played to customers containing their order information and payment links.',
                'id'    => Xoxzo::ORDER_DETAILS__TITLE__VOICE,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::ORDER_DETAILS__ENABLED__VOICE,
                'default'       =>  get_option(Xoxzo::ORDER_DETAILS__ENABLED__VOICE) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'     => __( 'Type', Xoxzo::TEXT_DOMAIN ),
                'desc'      => __( 'Choose the notification type you will want this event to trigger', Xoxzo::TEXT_DOMAIN ),
                'id'        => Xoxzo::ORDER_DETAILS__TYPE__VOICE,
                'class'     => 'wc-notification-select',
                'default'   => get_option(Xoxzo::ORDER_DETAILS__TYPE__VOICE),
                'type'      => 'select',
                'options'  => array(
                    'tts'   => __( 'TTS (Text To Speech)', Xoxzo::TEXT_DOMAIN ),
                    'playback'  => __( 'Audio Playback', Xoxzo::TEXT_DOMAIN ),
                ),
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Caller', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The caller, required by Xoxzo', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::ORDER_DETAILS__CALLER__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::ORDER_DETAILS__CALLER__VOICE ) ),
                'placeholder'  => '+60123456789 (Required)',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Playback MP3 location', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The location of the mp3 to be played. (Must be public link)', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::ORDER_DETAILS__PLAYBACK__VOICE,
                'type'     => 'textarea',
                'default'  => esc_attr( get_option( Xoxzo::ORDER_DETAILS__PLAYBACK__VOICE ) ),
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'TTS message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Xoxzo\'s TTS service will automatically convert this into audio', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::ORDER_DETAILS__TTS__VOICE,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__ORDER_DETAILS__VOICE,
                'default' => Xoxzo::MESSAGE_TEMPLATE__ORDER_DETAILS__VOICE,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function voice__customer_note() {
        return array(
            array(
                'title' => __( 'Customer note', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Customer note tts/playback are played when you add a note to an order.',
                'id'    => Xoxzo::CUSTOMER_NOTE__TITLE__VOICE,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::CUSTOMER_NOTE__ENABLED__VOICE,
                'default'       =>  get_option(Xoxzo::CUSTOMER_NOTE__ENABLED__VOICE) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'     => __( 'Type', Xoxzo::TEXT_DOMAIN ),
                'desc'      => __( 'Choose the notification type you will want this event to trigger', Xoxzo::TEXT_DOMAIN ),
                'id'        => Xoxzo::CUSTOMER_NOTE__TYPE__VOICE,
                'class'     => 'wc-notification-select',
                'default'   => get_option(Xoxzo::CUSTOMER_NOTE__TYPE__VOICE),
                'type'      => 'select',
                'options'  => array(
                    'tts'   => __( 'TTS (Text To Speech)', Xoxzo::TEXT_DOMAIN ),
                    'playback'  => __( 'Audio Playback', Xoxzo::TEXT_DOMAIN ),
                ),
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Caller', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The caller, required by Xoxzo', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::CUSTOMER_NOTE__CALLER__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::CUSTOMER_NOTE__CALLER__VOICE ) ),
                'placeholder'  => '+60123456789 (Required)',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Playback MP3 location', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The location of the mp3 to be played. (Must be public link)', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::CUSTOMER_NOTE__PLAYBACK__VOICE,
                'type'     => 'textarea',
                'default'  => esc_attr( get_option( Xoxzo::CUSTOMER_NOTE__PLAYBACK__VOICE ) ),
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'TTS message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Xoxzo\'s TTS service will automatically convert this into audio', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::CUSTOMER_NOTE__TTS__VOICE,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__CUSTOMER_NOTE__VOICE,
                'default' => Xoxzo::MESSAGE_TEMPLATE__CUSTOMER_NOTE__VOICE,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function voice__reset_password() {
        return array(
            array(
                'title' => __( 'Reset password', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Customer "reset password" tts/playback are played when customers reset their passwords.	',
                'id'    => Xoxzo::RESET_PASSWORD__TITLE__VOICE,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::RESET_PASSWORD__ENABLED__VOICE,
                'default'       =>  get_option(Xoxzo::RESET_PASSWORD__ENABLED__VOICE) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'     => __( 'Type', Xoxzo::TEXT_DOMAIN ),
                'desc'      => __( 'Choose the notification type you will want this event to trigger', Xoxzo::TEXT_DOMAIN ),
                'id'        => Xoxzo::RESET_PASSWORD__TYPE__VOICE,
                'class'     => 'wc-notification-select',
                'default'   => get_option(Xoxzo::RESET_PASSWORD__TYPE__VOICE),
                'type'      => 'select',
                'options'  => array(
                    'tts'   => __( 'TTS (Text To Speech)', Xoxzo::TEXT_DOMAIN ),
                    'playback'  => __( 'Audio Playback', Xoxzo::TEXT_DOMAIN ),
                ),
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Caller', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The caller, required by Xoxzo', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::RESET_PASSWORD__CALLER__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::RESET_PASSWORD__CALLER__VOICE ) ),
                'placeholder'  => '+60123456789 (Required)',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Playback MP3 location', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The location of the mp3 to be played. (Must be public link)', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::RESET_PASSWORD__PLAYBACK__VOICE,
                'type'     => 'textarea',
                'default'  => esc_attr( get_option( Xoxzo::RESET_PASSWORD__PLAYBACK__VOICE ) ),
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'TTS message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Xoxzo\'s TTS service will automatically convert this into audio', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::RESET_PASSWORD__TTS__VOICE,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__RESET_PASSWORD__VOICE,
                'default' => Xoxzo::MESSAGE_TEMPLATE__RESET_PASSWORD__VOICE,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }

    private static function voice__new_account() {
        return array(
            array(
                'title' => __( 'New account', Xoxzo::TEXT_DOMAIN ),
                'type'  => 'title',
                'desc'  => 'Customer "new account" tts/playback are played to the customer when a customer signs up via checkout or account pages.	',
                'id'    => Xoxzo::NEW_ACCOUNT__TITLE__VOICE,
            ),
            array(
                'title'         => __( 'Enable/Disable', Xoxzo::TEXT_DOMAIN ),
                'desc'          => __( 'Enable this notification', Xoxzo::TEXT_DOMAIN ),
                'id'            => Xoxzo::NEW_ACCOUNT__ENABLED__VOICE,
                'default'       =>  get_option(Xoxzo::NEW_ACCOUNT__ENABLED__VOICE) === 'yes' ? 'yes' : 'no',
                'type'          => 'checkbox',
            ),
            array(
                'title'     => __( 'Type', Xoxzo::TEXT_DOMAIN ),
                'desc'      => __( 'Choose the notification type you will want this event to trigger', Xoxzo::TEXT_DOMAIN ),
                'id'        => Xoxzo::NEW_ACCOUNT__TYPE__VOICE,
                'class'     => 'wc-notification-select',
                'default'   => get_option(Xoxzo::NEW_ACCOUNT__TYPE__VOICE),
                'type'      => 'select',
                'options'  => array(
                    'tts'   => __( 'TTS (Text To Speech)', Xoxzo::TEXT_DOMAIN ),
                    'playback'  => __( 'Audio Playback', Xoxzo::TEXT_DOMAIN ),
                ),
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Caller', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The caller, required by Xoxzo', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::NEW_ACCOUNT__CALLER__VOICE,
                'type'     => 'text',
                'default'  => esc_attr( get_option( Xoxzo::NEW_ACCOUNT__CALLER__VOICE ) ),
                'placeholder'  => '+60123456789 (Required)',
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'Playback MP3 location', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'The location of the mp3 to be played. (Must be public link)', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::NEW_ACCOUNT__PLAYBACK__VOICE,
                'type'     => 'textarea',
                'default'  => esc_attr( get_option( Xoxzo::NEW_ACCOUNT__PLAYBACK__VOICE ) ),
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'title'    => __( 'TTS message', Xoxzo::TEXT_DOMAIN ),
                'desc'     => __( 'Xoxzo\'s TTS service will automatically convert this into audio', Xoxzo::TEXT_DOMAIN ),
                'id'       => Xoxzo::NEW_ACCOUNT__TTS__VOICE,
                'type'     => 'textarea_custom',
                'placeholder' => Xoxzo::MESSAGE_TEMPLATE__NEW_ACCOUNT__VOICE,
                'default' => Xoxzo::MESSAGE_TEMPLATE__NEW_ACCOUNT__VOICE,
                'autoload' => false,
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
            ),
        );
    }
}