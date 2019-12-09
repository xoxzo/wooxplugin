<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit(0);
}

/**
 * A class that keeps all the important string literals
 *
 * Make it easier to use literally without knowing the strings directly. Usefully in code linting
 *
 * @since 1.0.0
 */
class Xoxzo {

    const PAGE = 'wc-settings';
    const TAB = 'xoxzo';
    const MENU__MAIN = "SMS/Voice";
    const MENU__BASIC_CONFIGURATION = "Basic Configuration";
    const MENU__STATUS = "Status";
    const MENU__SMS_NOTIFICATION = "SMS Notification";
    const MENU__VOICE_NOTIFICATION = "Voice Notification";
    const MENU__STATUS_SMS = "Sms";
    const MENU__STATUS_VOICE = "Voice";
    const MENU__STATUS_ERRORS = "Errors";

    const TEXT_DOMAIN = 'wc-xoxzo';

    const RESPONSE__CUSTOM_EVENT__SMS = self::TAB.'__custom_event__sms';
    const RESPONSE__CUSTOM_EVENT__VOICE = self::TAB.'__custom_event__voice';

    /* Relevant Woocommerce Hooks Used To Signal Events. */
    const HOOK__WOOCOMMERCE__ORDER_STATUS_PENDING_TO_PROCESSING_NOTIFICATION = 'woocommerce_order_status_pending_to_processing_notification';
    const HOOK__WOOCOMMERCE__ORDER_STATUS_PENDING_TO_COMPLETED_NOTIFICATION = 'woocommerce_order_status_pending_to_completed_notification';
    const HOOK__WOOCOMMERCE__ORDER_STATUS_PENDING_TO_ONHOLD_NOTIFICATION = 'woocommerce_order_status_pending_to_on-hold_notification';
    const HOOK__WOOCOMMERCE__ORDER_STATUS_PENDING_TO_FAILED_NOTIFICATION = 'woocommerce_order_status_pending_to_failed_notification';
    const HOOK__WOOCOMMERCE__ORDER_STATUS_FAILED_TO_PROCESSING_NOTIFICATION = 'woocommerce_order_status_failed_to_processing_notification';
    const HOOK__WOOCOMMERCE__ORDER_STATUS_FAILED_TO_COMPLETED_NOTIFICATION = 'woocommerce_order_status_failed_to_completed_notification';
    const HOOK__WOOCOMMERCE__ORDER_STATUS_FAILED_TO_ONHOLD_NOTIFICATION = 'woocommerce_order_status_failed_to_on-hold_notification';
    const HOOK__WOOCOMMERCE__LOW_STOCK_NOTIFICATION = 'woocommerce_low_stock_notification';
    const HOOK__WOOCOMMERCE__NO_STOCK_NOTIFICATION = 'woocommerce_no_stock_notification';
    const HOOK__WOOCOMMERCE__ORDER_STATUS_PROCESSING_TO_CANCELLED_NOTIFICATION = 'woocommerce_order_status_processing_to_cancelled_notification';
    const HOOK__WOOCOMMERCE__ORDER_STATUS_ONHOLD_TO_CANCELLED_NOTIFICATION = 'woocommerce_order_status_on-hold_to_cancelled_notification';
    const HOOK__WOOCOMMERCE__CUSTOMER_CANCELLED_NOTIFICATION = 'woocommerce_cancelled_order';
    const HOOK__WOOCOMMERCE__ORDER_STATUS_ONHOLD_TO_FAILED_NOTIFICATION = 'woocommerce_order_status_on-hold_to_failed_notification';
    const HOOK__WOOCOMMERCE__ORDER_STATUS_ONHOLD_TO_PROCESSING_NOTIFICATION = 'woocommerce_order_status_on-hold_to_processing_notification';
    const HOOK__WOOCOMMERCE__ORDER_STATUS_COMPLETED_NOTIFICATION = 'woocommerce_order_status_completed_notification';
    const HOOK__WOOCOMMERCE__FULLY_REFUNDED_NOTIFICATION = 'woocommerce_order_fully_refunded_notification';
    const HOOK__WOOCOMMERCE__PARTIALLY_REFUNDED_NOTIFICATION = 'woocommerce_order_partially_refunded_notification';
    const HOOK__WOOCOMMERCE__BEFORE_RESEND_ORDER_EMAILS_NOTIFICATION = 'woocommerce_before_resend_order_emails';
    const HOOK__WOOCOMMERCE__NEW_CUSTOMER_NOTE_NOTIFICATION = 'woocommerce_new_customer_note';
    const HOOK__WOOCOMMERCE__RESET_PASSWORD_NOTIFICATION = 'woocommerce_reset_password_notification';
    const HOOK__WOOCOMMERCE__CREATED_CUSTOMER_NOTIFICATION = 'woocommerce_created_customer';

    /* Plugin Defined Hooks.  */
    const HOOK__VOICE__CUSTOM_EVENT_PLAYBACK = 'woocommerce_custom_event_voice_playback_notification';
    const HOOK__VOICE__CUSTOM_EVENT_TTS = 'woocommerce_custom_event_voice_tts_notification';
    const HOOK__SMS__CUSTOM_EVENT = 'woocommerce_custom_event_sms_notification';

    /* Plugin Defined Event Literals For Triggering Voice */
    const VOICE_NEW = 'voice_new_order';
    const VOICE_CANCELLED = 'voice_cancelled_order';
    const VOICE_FAILED = 'voice_failed_order';
    const VOICE_ON_HOLD = 'voice_on_hold_order';
    const VOICE_PROCESSING = 'voice_processing_order';
    const VOICE_COMPLETED = 'voice_completed_order';
    const VOICE_FULLY_REFUNDED = 'voice_fully_refunded_order';
    const VOICE_PARTIALLY_REFUNDED = 'voice_partially_refunded_order';
    const VOICE_LOW_STOCK = 'voice_low_stock';
    const VOICE_NO_STOCK = 'voice_no_stock';
    const VOICE_ORDER_DETAILS = 'voice_order_details';
    const VOICE_CUSTOMER_NOTE = 'voice_customer_note';
    const VOICE_RESET_PASSWORD = 'voice_reset_password';
    const VOICE_NEW_ACCOUNT = 'voice_new_account';

    /* Plugin Defined Event Literals For Triggering Sms */
    const SMS_NEW = 'sms_new_order';
    const SMS_CANCELLED = 'sms_cancelled_order';
    const SMS_FAILED = 'sms_failed_order';
    const SMS_ON_HOLD = 'sms_on_hold_order';
    const SMS_PROCESSING = 'sms_processing_order';
    const SMS_COMPLETED = 'sms_completed_order';
    const SMS_FULLY_REFUNDED = 'sms_fully_refunded_order';
    const SMS_PARTIALLY_REFUNDED = 'sms_partially_refunded_order';
    const SMS_LOW_STOCK = 'sms_low_stock';
    const SMS_NO_STOCK = 'sms_no_stock';
    const SMS_ORDER_DETAILS = 'sms_order_details';
    const SMS_CUSTOMER_NOTE = 'sms_customer_note';
    const SMS_RESET_PASSWORD = 'sms_reset_password';
    const SMS_NEW_ACCOUNT = 'sms_new_account';


    /* Settings Page Most Relevant Ones */
    const ADMIN_SECTION_BASIC = "basic_configuration";
    const ADMIN_SECTION_SMS = "sms";
    const ADMIN_SECTION_VOICE = "voice";
    const ADMIN_SECTION_STATUS_SMS = "sms-status";
    const ADMIN_SECTION_STATUS_VOICE = "voice-status";
    const ADMIN_SECTION_STATUS_ERROR = "error-status";

    /*  Settings To Store WP_ADMIN Configuration And Flag For SMS */
    const SETTING__NEW__SMS = "sms-setting-new-order";
    const SETTING__CANCELLED__SMS = "sms-setting-cancelled-order";
    const SETTING__FAILED__SMS = "sms-setting-failed-order";
    const SETTING__ON_HOLD__SMS = "sms-setting-order-on-hold";
    const SETTING__PROCESSING__SMS = "sms-setting-processing-order";
    const SETTING__COMPLETED__SMS = "sms-setting-completed-order";
    const SETTING__FULLY_REFUNDED__SMS = "sms-setting-fully-refunded-order";
    const SETTING__PARTIALLY_REFUNDED__SMS = "sms-setting-partially-refunded-order";
    const SETTING__LOW_STOCK__SMS = "sms-setting-low-stock";
    const SETTING__NO_STOCK__SMS = "sms-setting-no-stock";
    const SETTING__ORDER_DETAILS__SMS = "sms-setting-order-details";
    const SETTING__CUSTOMER_NOTE__SMS = "sms-setting-customer-note";
    const SETTING__RESET_PASSWORD__SMS = "sms-setting-reset-password";
    const SETTING__NEW_ACCOUNT__SMS = "sms-setting-new-account";
    const SETTING__CUSTOM_EVENT__SMS = "sms-setting-custom-event";

    /*  Settings To Store WP_ADMIN Configuration And Flag For Voice */
    const SETTING__NEW__VOICE = "voice-setting-new-order";
    const SETTING__CANCELLED__VOICE = "voice-setting-cancelled-order";
    const SETTING__FAILED__VOICE = "voice-setting-failed-order";
    const SETTING__ON_HOLD__VOICE = "voice-setting-order-on-hold";
    const SETTING__PROCESSING__VOICE = "voice-setting-processing-order";
    const SETTING__COMPLETED__VOICE = "voice-setting-completed-order";
    const SETTING__FULLY_REFUNDED__VOICE = "voice-setting-fully-refunded-order";
    const SETTING__PARTIALLY_REFUNDED__VOICE = "voice-setting-partially-refunded-order";
    const SETTING__LOW_STOCK__VOICE = "voice-setting-low-stock";
    const SETTING__NO_STOCK__VOICE = "voice-setting-no-stock";
    const SETTING__ORDER_DETAILS__VOICE = "voice-setting-order-details";
    const SETTING__CUSTOMER_NOTE__VOICE = "voice-setting-customer-note";
    const SETTING__RESET_PASSWORD__VOICE = "voice-setting-reset-password";
    const SETTING__NEW_ACCOUNT__VOICE = "voice-setting-new-account";
    const SETTING__CUSTOM_EVENT__VOICE = "voice-setting-custom-event";


    /*  Message Template To Show As Default Message For SMS. Might Need Refactoring To Support MultiLanguage */
    const MESSAGE_TEMPLATE__NEW__SMS = "[{site_title}] New customer order #{order_number} from {order_date}.";
    const MESSAGE_TEMPLATE__CANCELLED__SMS = "[{site_title}] The order #{order_number} from {order_date} was cancelled.";
    const MESSAGE_TEMPLATE__FAILED__SMS = "[{site_title}] The order #{order_number} from {order_date} was not successful.";
    const MESSAGE_TEMPLATE__ON_HOLD__SMS = "[{site_title}] Your order #{order_number} from {order_date} is on-hold until we can confirm payment has been received.";
    const MESSAGE_TEMPLATE__PROCESSING__SMS = "[{site_title}] Your order #{order_number} from {order_date} is being processed.";
    const MESSAGE_TEMPLATE__COMPLETED__SMS = "[{site_title}] Your order #{order_number} from {order_date} is completed.";
    const MESSAGE_TEMPLATE__FULLY_REFUNDED__SMS = "[{site_title}] Your order #{order_number} from {order_date} has been fully refunded.";
    const MESSAGE_TEMPLATE__PARTIALLY_REFUNDED__SMS = "[{site_title}] Your order #{order_number} from {order_date} has been partial refunded.";
    const MESSAGE_TEMPLATE__ORDER_DETAILS__SMS = "[{site_title}] Your order's payment is here {order_pay_url}.";
    const MESSAGE_TEMPLATE__LOW_STOCK__SMS = "[{site_title}] (ID: {product_id}) Product \"{product_name}\" is low of stock. There are {product_stock} left.";
    const MESSAGE_TEMPLATE__NO_STOCK__SMS = "[{site_title}] (ID: {product_id}) Product \"{product_name}\" is out of stock.";
    const MESSAGE_TEMPLATE__CUSTOMER_NOTE__SMS = "[{site_title}] New note: {customer_note}";
    const MESSAGE_TEMPLATE__RESET_PASSWORD__SMS = "[{site_title}] Your password reset link is {password_reset_url}.";
    const MESSAGE_TEMPLATE__NEW_ACCOUNT__SMS = "[{site_title}] Congratulations, you have a new account created. Sign-in now to view all the details.";

    /*  Message Template To Show As Default Message For Voice. Might Need Refactoring To Support MultiLanguage */
    const MESSAGE_TEMPLATE__NEW__VOICE = "[{site_title}] New customer order #{order_number} from {order_date}.";
    const MESSAGE_TEMPLATE__CANCELLED__VOICE = "[{site_title}] The order #{order_number} from {order_date} was cancelled.";
    const MESSAGE_TEMPLATE__FAILED__VOICE = "[{site_title}] The order #{order_number} from {order_date} was not successful.";
    const MESSAGE_TEMPLATE__ON_HOLD__VOICE = "[{site_title}] Your order #{order_number} from {order_date} is on-hold until we can confirm payment has been received.";
    const MESSAGE_TEMPLATE__PROCESSING__VOICE = "[{site_title}] Your order #{order_number} from {order_date} is being processed.";
    const MESSAGE_TEMPLATE__COMPLETED__VOICE = "[{site_title}] Your order #{order_number} from {order_date} is completed.";
    const MESSAGE_TEMPLATE__FULLY_REFUNDED__VOICE = "[{site_title}] Your order #{order_number} from {order_date} has been fully refunded.";
    const MESSAGE_TEMPLATE__PARTIALLY_REFUNDED__VOICE = "[{site_title}] Your order #{order_number} from {order_date} has been partial refunded.";
    const MESSAGE_TEMPLATE__ORDER_DETAILS__VOICE = "[{site_title}] Your order's payment is here {order_pay_url}.";
    const MESSAGE_TEMPLATE__LOW_STOCK__VOICE = "[{site_title}] Product \"{product_name}\" is low of stock. There are {product_stock} left.";
    const MESSAGE_TEMPLATE__NO_STOCK__VOICE = "[{site_title}] Product \"{product_name}\" is out of stock.";
    const MESSAGE_TEMPLATE__CUSTOMER_NOTE__VOICE = "[{site_title}] New note: {customer_note}";
    const MESSAGE_TEMPLATE__RESET_PASSWORD__VOICE = "[{site_title}] Your password reset link is {password_reset_url}.";
    const MESSAGE_TEMPLATE__NEW_ACCOUNT__VOICE = "[{site_title}] Congratulations, you have a new account created. Sign-in now to view all the details.";

    /* The css ids used in WP_ADMIN UI. Relevent when saving the configuration into backend */
    const NEW__ENABLED__SMS = "wc_xoxzo__enabled__"."new_order__sms";
    const NEW__TITLE__SMS = "wc_xoxzo__title__"."new_order__sms";
    const NEW__RECIPIENTS__SMS = "wc_xoxzo__recipients__"."new_order__sms";
    const NEW__MESSAGE__SMS = "wc_xoxzo__message__"."new__order__sms";

    const CANCELLED__ENABLED__SMS = "wc_xoxzo__enabled__"."cancelled_order__sms";
    const CANCELLED__TITLE__SMS = "wc_xoxzo__title__"."cancelled_order__sms";
    const CANCELLED__RECIPIENTS__SMS = "wc_xoxzo__recipients__"."cancelled_order__sms";
    const CANCELLED__MESSAGE__SMS = "wc_xoxzo__message__"."cancelled__order__sms";

    const FAILED__ENABLED__SMS = "wc_xoxzo__enabled__"."failed_order__sms";
    const FAILED__TITLE__SMS = "wc_xoxzo__title__"."failed_order__sms";
    const FAILED__RECIPIENTS__SMS = "wc_xoxzo__recipients__"."failed_order__sms";
    const FAILED__MESSAGE__SMS = "wc_xoxzo__message__"."failed__order__sms";

    const ON_HOLD__ENABLED__SMS = "wc_xoxzo_enabled__"."on_hold_order__sms";
    const ON_HOLD__TITLE__SMS = "wc_xoxzo_title__"."on_hold_order__sms";
    const ON_HOLD__RECIPIENTS__SMS = "wc_xoxzo__recipients__"."on_hold_order__sms";
    const ON_HOLD__MESSAGE__SMS = "wc_xoxzo__message__"."on_hold_order__sms";

    const PROCESSING__ENABLED__SMS = "wc_xoxzo_enabled__"."processing_order__sms";
    const PROCESSING__TITLE__SMS = "wc_xoxzo_title__"."processing_order__sms";
    const PROCESSING__RECIPIENTS__SMS = "wc_xoxzo__recipients__"."processing_order__sms";
    const PROCESSING__MESSAGE__SMS = "wc_xoxzo__message__"."processing_order__sms";

    const COMPLETED__ENABLED__SMS = "wc_xoxzo_enabled__"."completed_order__sms";
    const COMPLETED__TITLE__SMS = "wc_xoxzo_title__"."completed_order__sms";
    const COMPLETED__RECIPIENTS__SMS = "wc_xoxzo__recipients__"."completed_order__sms";
    const COMPLETED__MESSAGE__SMS = "wc_xoxzo__message__"."completed_order__sms";

    const FULLY_REFUNDED__ENABLED__SMS = "wc_xoxzo_enabled__"."fully_refunded__sms";
    const FULLY_REFUNDED__TITLE__SMS = "wc_xoxzo_title__"."fully_refunded__sms";
    const FULLY_REFUNDED__RECIPIENTS__SMS = "wc_xoxzo__recipients__"."fully_refunded__sms";
    const FULLY_REFUNDED__MESSAGE__SMS = "wc_xoxzo__message__"."fully_refunded__sms";

    const PARTIALLY_REFUNDED__ENABLED__SMS = "wc_xoxzo_enabled__"."partially_refunded__sms";
    const PARTIALLY_REFUNDED__TITLE__SMS = "wc_xoxzo_title__"."partially_refunded__sms";
    const PARTIALLY_REFUNDED__RECIPIENTS__SMS = "wc_xoxzo__recipients__"."partially_refunded__sms";
    const PARTIALLY_REFUNDED__MESSAGE__SMS = "wc_xoxzo__message__"."partially_refunded__sms";

    const LOW_STOCK__ENABLED__SMS = "wc_xoxzo_enabled__"."low_stock__sms";
    const LOW_STOCK__TITLE__SMS = "wc_xoxzo_title__"."low_stock__sms";
    const LOW_STOCK__RECIPIENTS__SMS = "wc_xoxzo__recipients__"."low_stock__sms";
    const LOW_STOCK__MESSAGE__SMS = "wc_xoxzo__message__"."low_stock__sms";

    const NO_STOCK__ENABLED__SMS = "wc_xoxzo_enabled__"."no_stock__sms";
    const NO_STOCK__TITLE__SMS = "wc_xoxzo_title__"."no_stock__sms";
    const NO_STOCK__RECIPIENTS__SMS = "wc_xoxzo__recipients__"."no_stock__sms";
    const NO_STOCK__MESSAGE__SMS = "wc_xoxzo__message__"."no_stock__sms";

    const ORDER_DETAILS__ENABLED__SMS = "wc_xoxzo_enabled__"."order_details__sms";
    const ORDER_DETAILS__TITLE__SMS = "wc_xoxzo_title__"."order_details__sms";
    const ORDER_DETAILS__RECIPIENTS__SMS = "wc_xoxzo__recipients__"."order_details__sms";
    const ORDER_DETAILS__MESSAGE__SMS = "wc_xoxzo__message__"."order_details__sms";

    const CUSTOMER_NOTE__ENABLED__SMS = "wc_xoxzo_enabled__"."customer_note__sms";
    const CUSTOMER_NOTE__TITLE__SMS = "wc_xoxzo_title__"."customer_note__sms";
    const CUSTOMER_NOTE__RECIPIENTS__SMS = "wc_xoxzo__recipients__"."customer_note__sms";
    const CUSTOMER_NOTE__MESSAGE__SMS = "wc_xoxzo__message__"."customer_note__sms";

    const RESET_PASSWORD__ENABLED__SMS = "wc_xoxzo_enabled__"."reset_password__sms";
    const RESET_PASSWORD__TITLE__SMS = "wc_xoxzo_title__"."reset_password__sms";
    const RESET_PASSWORD__RECIPIENTS__SMS = "wc_xoxzo__recipients__"."reset_password__sms";
    const RESET_PASSWORD__MESSAGE__SMS = "wc_xoxzo__message__"."reset_password__sms";

    const NEW_ACCOUNT__ENABLED__SMS = "wc_xoxzo_enabled__"."new_account__sms";
    const NEW_ACCOUNT__TITLE__SMS = "wc_xoxzo_title__"."new_account__sms";
    const NEW_ACCOUNT__RECIPIENTS__SMS = "wc_xoxzo__recipients__"."new_account__sms";
    const NEW_ACCOUNT__MESSAGE__SMS = "wc_xoxzo__message__"."new_account__sms";

    const NEW__ENABLED__VOICE = "wc_xoxzo__enabled__"."new_order__voice";
    const NEW__TITLE__VOICE = "wc_xoxzo__title__"."new_order__voice";
    const NEW__TYPE__VOICE = "wc_xoxzo__type__"."new_order__voice";
    const NEW__RECIPIENTS__VOICE = "wc_xoxzo__recipients__"."new_order__voice";
    const NEW__CALLER__VOICE = "wc_xoxzo__caller__"."new_order__voice";
    const NEW__PLAYBACK__VOICE = "wc_xoxzo__playback__"."new_order__voice";
    const NEW__TTS__VOICE = "wc_xoxzo__tts__"."new_order__voice";

    const CANCELLED__ENABLED__VOICE = "wc_xoxzo__enabled__"."cancelled_order__voice";
    const CANCELLED__TITLE__VOICE = "wc_xoxzo__title__"."cancelled_order__voice";
    const CANCELLED__TYPE__VOICE = "wc_xoxzo__type__"."cancelled_order__voice";
    const CANCELLED__RECIPIENTS__VOICE = "wc_xoxzo__recipients__"."cancelled_order__voice";
    const CANCELLED__CALLER__VOICE = "wc_xoxzo__caller__"."cancelled_order__voice";
    const CANCELLED__PLAYBACK__VOICE = "wc_xoxzo__playback__"."cancelled_order__voice";
    const CANCELLED__TTS__VOICE = "wc_xoxzo__tts__"."cancelled_order__voice";

    const FAILED__ENABLED__VOICE = "wc_xoxzo__enabled__"."failed_order__voice";
    const FAILED__TITLE__VOICE = "wc_xoxzo__title__"."failed_order__voice";
    const FAILED__TYPE__VOICE = "wc_xoxzo__type__"."failed_order__voice";
    const FAILED__RECIPIENTS__VOICE = "wc_xoxzo__recipients__"."failed_order__voice";
    const FAILED__CALLER__VOICE = "wc_xoxzo__caller__"."failed_order__voice";
    const FAILED__PLAYBACK__VOICE = "wc_xoxzo__playback__"."failed_order__voice";
    const FAILED__TTS__VOICE = "wc_xoxzo__tts__"."failed_order__voice";

    const ON_HOLD__ENABLED__VOICE = "wc_xoxzo_enabled__"."on_hold_order__voice";
    const ON_HOLD__TITLE__VOICE = "wc_xoxzo_title__"."on_hold_order__voice";
    const ON_HOLD__TYPE__VOICE = "wc_xoxzo__type__"."on_hold_order__voice";
    const ON_HOLD__RECIPIENTS__VOICE = "wc_xoxzo__recipients__"."on_hold_order__voice";
    const ON_HOLD__CALLER__VOICE = "wc_xoxzo__caller__"."on_hold_order__voice";
    const ON_HOLD__PLAYBACK__VOICE = "wc_xoxzo__playback__"."on_hold_order__voice";
    const ON_HOLD__TTS__VOICE = "wc_xoxzo__tts__"."on_hold_order__voice";

    const PROCESSING__ENABLED__VOICE = "wc_xoxzo_enabled__"."processing_order__voice";
    const PROCESSING__TITLE__VOICE = "wc_xoxzo_title__"."processing_order__voice";
    const PROCESSING__TYPE__VOICE = "wc_xoxzo__type__"."processing_order__voice";
    const PROCESSING__RECIPIENTS__VOICE = "wc_xoxzo__recipients__"."processing_order__voice";
    const PROCESSING__CALLER__VOICE = "wc_xoxzo__caller__"."processing_order__voice";
    const PROCESSING__PLAYBACK__VOICE = "wc_xoxzo__playback__"."processing_order__voice";
    const PROCESSING__TTS__VOICE = "wc_xoxzo__tts__"."processing_order__voice";

    const COMPLETED__ENABLED__VOICE = "wc_xoxzo_enabled__"."completed_order__voice";
    const COMPLETED__TITLE__VOICE = "wc_xoxzo_title__"."completed_order__voice";
    const COMPLETED__TYPE__VOICE = "wc_xoxzo__type__"."completed_order__voice";
    const COMPLETED__RECIPIENTS__VOICE = "wc_xoxzo__recipients__"."completed_order__voice";
    const COMPLETED__CALLER__VOICE = "wc_xoxzo__caller__"."completed_order__voice";
    const COMPLETED__PLAYBACK__VOICE = "wc_xoxzo__playback__"."completed_order__voice";
    const COMPLETED__TTS__VOICE = "wc_xoxzo__tts__"."completed_order__voice";

    const FULLY_REFUNDED__ENABLED__VOICE = "wc_xoxzo_enabled__"."fully_refunded__voice";
    const FULLY_REFUNDED__TITLE__VOICE = "wc_xoxzo_title__"."fully_refunded__voice";
    const FULLY_REFUNDED__TYPE__VOICE = "wc_xoxzo__type__"."fully_refunded__voice";
    const FULLY_REFUNDED__RECIPIENTS__VOICE = "wc_xoxzo__recipients__"."fully_refunded__voice";
    const FULLY_REFUNDED__CALLER__VOICE = "wc_xoxzo__caller__"."fully_refunded__voice";
    const FULLY_REFUNDED__PLAYBACK__VOICE = "wc_xoxzo__playback__"."fully_refunded__voice";
    const FULLY_REFUNDED__TTS__VOICE = "wc_xoxzo__tts__"."fully_refunded__voice";

    const PARTIALLY_REFUNDED__ENABLED__VOICE = "wc_xoxzo_enabled__"."partially_refunded__voice";
    const PARTIALLY_REFUNDED__TITLE__VOICE = "wc_xoxzo_title__"."partially_refunded__voice";
    const PARTIALLY_REFUNDED__TYPE__VOICE = "wc_xoxzo__type__"."partially_refunded__voice";
    const PARTIALLY_REFUNDED__RECIPIENTS__VOICE = "wc_xoxzo__recipients__"."partially_refunded__voice";
    const PARTIALLY_REFUNDED__CALLER__VOICE = "wc_xoxzo__caller__"."partially_refunded__voice";
    const PARTIALLY_REFUNDED__PLAYBACK__VOICE = "wc_xoxzo__playback__"."partially_refunded__voice";
    const PARTIALLY_REFUNDED__TTS__VOICE = "wc_xoxzo__tts__"."partially_refunded__voice";

    const LOW_STOCK__ENABLED__VOICE = "wc_xoxzo_enabled__"."low_stock__voice";
    const LOW_STOCK__TITLE__VOICE = "wc_xoxzo_title__"."low_stock__voice";
    const LOW_STOCK__TYPE__VOICE = "wc_xoxzo__type__"."low_stock__voice";
    const LOW_STOCK__RECIPIENTS__VOICE = "wc_xoxzo__recipients__"."low_stock__voice";
    const LOW_STOCK__CALLER__VOICE = "wc_xoxzo__caller__"."low_stock__voice";
    const LOW_STOCK__PLAYBACK__VOICE = "wc_xoxzo__playback__"."low_stock__voice";
    const LOW_STOCK__TTS__VOICE = "wc_xoxzo__tts__"."low_stock__voice";

    const NO_STOCK__ENABLED__VOICE = "wc_xoxzo_enabled__"."no_stock__voice";
    const NO_STOCK__TITLE__VOICE = "wc_xoxzo_title__"."no_stock__voice";
    const NO_STOCK__TYPE__VOICE = "wc_xoxzo__type__"."no_stock__voice";
    const NO_STOCK__RECIPIENTS__VOICE = "wc_xoxzo__recipients__"."no_stock__voice";
    const NO_STOCK__CALLER__VOICE = "wc_xoxzo__caller__"."no_stock__voice";
    const NO_STOCK__PLAYBACK__VOICE = "wc_xoxzo__playback__"."no_stock__voice";
    const NO_STOCK__TTS__VOICE = "wc_xoxzo__tts__"."no_stock__voice";

    const ORDER_DETAILS__ENABLED__VOICE = "wc_xoxzo_enabled__"."order_details__voice";
    const ORDER_DETAILS__TITLE__VOICE = "wc_xoxzo_title__"."order_details__voice";
    const ORDER_DETAILS__TYPE__VOICE = "wc_xoxzo__type__"."order_details__voice";
    const ORDER_DETAILS__RECIPIENTS__VOICE = "wc_xoxzo__recipients__"."order_details__voice";
    const ORDER_DETAILS__CALLER__VOICE = "wc_xoxzo__caller__"."order_details__voice";
    const ORDER_DETAILS__PLAYBACK__VOICE = "wc_xoxzo__playback__"."order_details__voice";
    const ORDER_DETAILS__TTS__VOICE = "wc_xoxzo__tts__"."order_details__voice";

    const CUSTOMER_NOTE__ENABLED__VOICE = "wc_xoxzo_enabled__"."customer_note__voice";
    const CUSTOMER_NOTE__TITLE__VOICE = "wc_xoxzo_title__"."customer_note__voice";
    const CUSTOMER_NOTE__TYPE__VOICE = "wc_xoxzo__type__"."customer_note__voice";
    const CUSTOMER_NOTE__RECIPIENTS__VOICE = "wc_xoxzo__recipients__"."customer_note__voice";
    const CUSTOMER_NOTE__CALLER__VOICE = "wc_xoxzo__caller__"."customer_note__voice";
    const CUSTOMER_NOTE__PLAYBACK__VOICE = "wc_xoxzo__playback__"."customer_note__voice";
    const CUSTOMER_NOTE__TTS__VOICE = "wc_xoxzo__tts__"."customer_note__voice";

    const RESET_PASSWORD__ENABLED__VOICE = "wc_xoxzo_enabled__"."reset_password__voice";
    const RESET_PASSWORD__TITLE__VOICE = "wc_xoxzo_title__"."reset_password__voice";
    const RESET_PASSWORD__TYPE__VOICE = "wc_xoxzo__type__"."reset_password__voice";
    const RESET_PASSWORD__RECIPIENTS__VOICE = "wc_xoxzo__recipients__"."reset_password__voice";
    const RESET_PASSWORD__CALLER__VOICE = "wc_xoxzo__caller__"."reset_password__voice";
    const RESET_PASSWORD__PLAYBACK__VOICE = "wc_xoxzo__playback__"."reset_password__voice";
    const RESET_PASSWORD__TTS__VOICE = "wc_xoxzo__tts__"."reset_password__voice";

    const NEW_ACCOUNT__ENABLED__VOICE = "wc_xoxzo_enabled__"."new_account__voice";
    const NEW_ACCOUNT__TITLE__VOICE = "wc_xoxzo_title__"."new_account__voice";
    const NEW_ACCOUNT__TYPE__VOICE = "wc_xoxzo__type__"."new_account__voice";
    const NEW_ACCOUNT__RECIPIENTS__VOICE = "wc_xoxzo__recipients__"."new_account__voice";
    const NEW_ACCOUNT__CALLER__VOICE = "wc_xoxzo__caller__"."new_account__voice";
    const NEW_ACCOUNT__PLAYBACK__VOICE = "wc_xoxzo__playback__"."new_account__voice";
    const NEW_ACCOUNT__TTS__VOICE = "wc_xoxzo__tts__"."new_account__voice";

    /* Table Column Description For SMS Notifications */
    const DESCRIPTION__NEW__SMS = "New order will trigger the sms to be sent for chosen recipient(s) when a new order is received."
    ."<br><br><strong>Triggers</strong>"
    ."<br>- Pending to processing/completed/on-hold"
    ."<br>- Failed to processing/completed/on-hold";
    const DESCRIPTION__CANCELLED__SMS = "Cancelled order will trigger the sms to be sent for chosen recipient(s) when orders have been marked cancelled. Send to recipient when customer cancel from frontend, or to customer when cancelled from admin page."
    ."<br><br><strong>Triggers</strong>"
    ."<br>- Processing to cancelled"
    ."<br>- On-hold to cancelled"
    ."<br>- Pending to cancelled (Customer Only - My Account Page)";
    const DESCRIPTION__FAILED__SMS = "Failed order will trigger the sms to be sent for chosen recipient(s) when orders have been marked failed."
    ."<br><br><strong>Triggers</strong>"
    ."<br>- On-hold to failed"
    ."<br>- Pending to failed";
    const DESCRIPTION__ON_HOLD__SMS = "This sms is sent for customers containing order details after an order is placed on-hold."
    ."<br><br><strong>Triggers</strong>"
    ."<br>- Pending to on-hold"
    ."<br>- Failed to on-hold";
    const DESCRIPTION__PROCESSING__SMS = "This sms is sent for customers containing order details after payment."
    ."<br><br><strong>Triggers</strong>"
    ."<br>- Failed to processing"
    ."<br>- On-hold to processing"
    ."<br>- Pending to processing";
    const DESCRIPTION__COMPLETED__SMS = "Order complete sms are sent to customers when their orders are marked completed and usually indicate that their orders have been shipped."
    ."<br><br><strong>Triggers</strong>"
    ."<br>- Order status completed";
    const DESCRIPTION__FULLY_REFUNDED__SMS = "Order fully refunded sms are sent to customers when their orders are fully refunded.";
    const DESCRIPTION__PARTIALLY_REFUNDED__SMS = "Order partially refunded are sent to customers when their orders are partially refunded.";
    const DESCRIPTION__LOW_STOCK__SMS = "Low stock of a product will trigger the sms to be sent for chosen recipient(s).";
    const DESCRIPTION__NO_STOCK__SMS = "No stock of a product will trigger the sms to be sent for chosen recipient(s).";
    const DESCRIPTION__ORDER_DETAILS__SMS = "Order details sms are sent to customers containing their order information and payment links."
    ."<br><br><strong>Triggers</strong>"
    ."<br>- Resending order information email";
    const DESCRIPTION__CUSTOMER_NOTE__SMS = "When new customer note is added from order backend page.";
    const DESCRIPTION__RESET_PASSWORD__SMS = "Customer \"reset password\" sms are sent when customers reset their passwords.";
    const DESCRIPTION__NEW_ACCOUNT__SMS = "Customer \"new account\" sms sent to the customer when a customer signs up via checkout or account pages. (Only if there is phone no)";

    /* Table Column Description For Voice Notifications */
    const DESCRIPTION__NEW__VOICE = "New order will trigger the tts/playback to be played for chosen recipient(s) when a new order is received."
    ."<br><br><strong>Triggers</strong>"
    ."<br>- Pending to processing/completed/on-hold"
    ."<br>- Failed to processing/completed/on-hold";
    const DESCRIPTION__CANCELLED__VOICE = "Cancelled order will trigger the tts/playback to be played for chosen recipient(s) when orders have been marked cancelled."
    ."<br><br><strong>Triggers</strong>"
    ."<br>- Processing to cancelled"
    ."<br>- On-hold to cancelled";
    const DESCRIPTION__FAILED__VOICE = "Failed order will trigger the tts/playback to be played for chosen recipient(s) when orders have been marked failed."
    ."<br><br><strong>Triggers</strong>"
    ."<br>- On-hold to failed"
    ."<br>- Pending to failed";
    const DESCRIPTION__ON_HOLD__VOICE = "This tts/playback is played for customers containing order details after an order is placed on-hold."
    ."<br><br><strong>Triggers</strong>"
    ."<br>- Pending to on-hold"
    ."<br>- Failed to on-hold";
    const DESCRIPTION__PROCESSING__VOICE = "This tts/playback is played for customers containing order details after payment."
    ."<br><br><strong>Triggers</strong>"
    ."<br>- Failed to processing"
    ."<br>- On-hold to processing"
    ."<br>- Pending to processing";
    const DESCRIPTION__COMPLETED__VOICE = "Order complete tts/playback are sent to customers when their orders are marked completed and usually indicate that their orders have been shipped."
    ."<br><br><strong>Triggers</strong>"
    ."<br>- Order status completed";
    const DESCRIPTION__FULLY_REFUNDED__VOICE =  "Order fully refunded tts/playback are played to customers when their orders are fully refunded.";
    const DESCRIPTION__PARTIALLY_REFUNDED__VOICE = "Order partially refunded tts/playback are played to customers when their orders are partially refunded.";
    const DESCRIPTION__LOW_STOCK__VOICE = "Low stock of a product will trigger the tts/playback to be played for chosen recipient(s).";
    const DESCRIPTION__NO_STOCK__VOICE = "No stock of a product will trigger the tts/playback to be played for chosen recipient(s).";
    const DESCRIPTION__ORDER_DETAILS__VOICE = "Order details tts/playback is played to customers containing their order information and payment links."
    ."<br><br><strong>Triggers</strong>"
    ."<br>- Resending order information email";
    const DESCRIPTION__CUSTOMER_NOTE__VOICE = "When new customer note is added from order backend page.";
    const DESCRIPTION__RESET_PASSWORD__VOICE = "Customer \"reset password\" tts/playback are played when customers reset their passwords.";
    const DESCRIPTION__NEW_ACCOUNT__VOICE = "Customer \"new account\" tts/playback are played to the customer when a customer signs up via checkout or account pages. (Only if there is phone no)";


    public function table_name__status($prefix=true) {
        if($prefix) {
            global $wpdb;
            return $wpdb->prefix."woocommerce_xoxzo_status";
        }
        return "woocommerce_xoxzo_status";
    }

    public function table_name__error($prefix=true) {
        if($prefix) {
            global $wpdb;
            return $wpdb->prefix."woocommerce_xoxzo_error";
        }
        return "woocommerce_xoxzo_error";
    }

    public static function write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }

    public static function parse_event_name($event) {
        if(in_array($event, array(
            'new_order__woocommerce_order_status_pending_to_processing_notification',
            'new_order__woocommerce_order_status_pending_to_completed_notification',
            'new_order__woocommerce_order_status_pending_to_on-hold_notification',
            'new_order__woocommerce_order_status_failed_to_processing_notification',
            'new_order__woocommerce_order_status_failed_to_completed_notification',
            'new_order__woocommerce_order_status_failed_to_on-hold_notification',
        ))) {
            return self::parse_event_readable($event, array('new_order__woocommerce_order_status_', '_notification'));
        }
        else if(in_array($event, array(
            'woocommerce_low_stock_notification',
            'woocommerce_no_stock_notification'
        ))) {
            return self::parse_event_readable($event, array('woocommerce_', '_notification'));
        }
        else if(in_array($event, array(
            'woocommerce_order_status_processing_to_cancelled_notification',
            'woocommerce_order_status_on-hold_to_cancelled_notification',
        ))) {
            return self::parse_event_readable($event, array('woocommerce_order_status_', '_notification'));
        }
        else if(in_array($event, array(
            'woocommerce_order_status_processing_to_cancelled_notification_backend',
            'woocommerce_order_status_on-hold_to_cancelled_notification_backend',
        ))) {
            return self::parse_event_readable($event, array('woocommerce_order_status_', '_notification_backend')).' - From Backend';
        }
        else if(in_array($event, array(
            'woocommerce_order_status_processing_to_cancelled_notification_frontend',
            'woocommerce_order_status_on-hold_to_cancelled_notification_frontend',
        ))) {
            return self::parse_event_readable($event, array('woocommerce_order_status_', '_notification_frontend')).' - From Frontend';
        }
        else if(in_array($event, array(
            'woocommerce_order_status_pending_to_failed_notification',
            'woocommerce_order_status_on-hold_to_failed_notification'
        ))) {
            return self::parse_event_readable($event, array('woocommerce_order_status_', '_notification'));
        }
        else if(in_array($event, array(
            'woocommerce_order_status_pending_to_failed_notification_backend',
            'woocommerce_order_status_on-hold_to_failed_notification_backend'
        ))) {
            return self::parse_event_readable($event, array('woocommerce_order_status_', '_notification_backend')).' - From Backend';
        }
        else if(in_array($event, array(
            'woocommerce_order_status_pending_to_failed_notification_frontend',
            'woocommerce_order_status_on-hold_to_failed_notification_frontend',
        ))) {
            return self::parse_event_readable($event, array('woocommerce_order_status_', '_notification_frontend')).' - From Frontend';
        }
        else if(in_array($event, array(
            'woocommerce_cancelled_order',
            'woocommerce_cancelled_order_frontend',
        ))) {
            return 'Customer '.self::parse_event_readable($event, array('woocommerce_'));
        }
        else if(in_array($event, array(
            'woocommerce_order_status_pending_to_on-hold_notification',
            'woocommerce_order_status_failed_to_on-hold_notification'
        ))) {
            return self::parse_event_readable($event, array('woocommerce_order_status_', '_notification'));
        }
        else if(in_array($event, array(
            'woocommerce_order_status_failed_to_processing_notification',
            'woocommerce_order_status_on-hold_to_processing_notification',
            'woocommerce_order_status_pending_to_processing_notification'
        ))) {
            return self::parse_event_readable($event, array('woocommerce_order_status_', '_notification'));
        }
        else if(in_array($event, array(
            'woocommerce_order_status_completed_notification'
        ))) {
            return self::parse_event_readable($event, array('woocommerce_order_status_', '_notification'));
        }
        else if(in_array($event, array(
            'woocommerce_order_fully_refunded_notification'
        ))) {
            return self::parse_event_readable($event, array('woocommerce_order_', '_notification'));
        }
        else if(in_array($event, array(
            'woocommerce_order_partially_refunded_notification'
        ))) {
            return self::parse_event_readable($event, array('woocommerce_order_', '_notification'));
        }
        else if(in_array($event, array(
            'woocommerce_before_resend_order_emails'
        ))) {
            return self::parse_event_readable($event, array('woocommerce_before_', '_emails'));
        }
        else if(in_array($event, array(
            'woocommerce_new_customer_note'
        ))) {
            return self::parse_event_readable($event, array('woocommerce_new_'));
        }
        else if(in_array($event, array(
            'woocommerce_reset_password_notification'
        ))) {
            return self::parse_event_readable($event, array('woocommerce_', "_notification"));
        }
        else if(in_array($event, array(
            'woocommerce_created_customer'
        ))) {
            return self::parse_event_readable($event, array('woocommerce_'));
        }
        else if(in_array($event, array(
            \Xoxzo::HOOK__SMS__CUSTOM_EVENT
        ))) {
            return self::parse_event_readable($event, array('woocommerce_', '_sms_notification'));
        }
        else if(in_array($event, array(
            \Xoxzo::HOOK__VOICE__CUSTOM_EVENT_TTS
        ))) {
            return self::parse_event_readable($event, array('woocommerce_', '_voice_tts_notification'));
        }
        else if(in_array($event, array(
            \Xoxzo::HOOK__VOICE__CUSTOM_EVENT_PLAYBACK
        ))) {
            return self::parse_event_readable($event, array('woocommerce_', '_voice_playback_notification'));
        }
    }

    public static function parse_event_readable($status, $tokens) {
        $_ = '';
        foreach($tokens as $i =>$token) {
            if($i==0) {
                $_ = str_replace($token, '', $status);
                continue;
            }
            $_ = str_replace($token, '', $_);
        }
        return ucwords(implode(" ", explode("_", $_)));
    }
}