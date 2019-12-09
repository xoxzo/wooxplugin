<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit(0);
}

$notification_type = function($id=0) {
    if(empty($id)) {
        return "[NONE]";
    }
    $type=get_option($id);
    return ucwords(esc_attr(trim($type)));
};
$recipient_list = function($id) {
    $recipients=get_option($id);
    $message = "";
    if(empty($recipients)) {
        $message="[NONE]";
    } else {
        $_ = explode(",", $recipients);
        foreach($_ as $i => $item) {
            if($i>0)
                $message = $message . ", ".esc_attr(trim($item));
            else
                $message = esc_attr(trim($item));
        }
    }
    return $message;
};
hidden_fields("voice");
?>

<h2>
    <?php _e( 'Voice Notification', Xoxzo::TEXT_DOMAIN ); ?>
    <a href="<?php echo admin_url( 'admin.php?page='.Xoxzo::PAGE.'&tab='.Xoxzo::TAB.'&section='.Xoxzo::SETTING__CUSTOM_EVENT__VOICE); ?>" class="page-title-action">
        <?php esc_html_e( 'Send Custom Message', Xoxzo::TEXT_DOMAIN ); ?>
    </a>
</h2>
<div id="api_option-description">
    <p>Voice notifications sent from Xoxzo are listed below. Click on an 'Edit' to configure it.</p>
</div>
<tr valign="top">
    <td class="wc_payment_gateways_wrapper" colspan="2">
        <table class="wc_gateways widefat" cellspacing="0" aria-describedby="payment_gateways_options-description">
            <thead>
            <tr>
                <?php
                foreach ( array(
                              'status'      => __( 'Enabled', \Xoxzo::TEXT_DOMAIN ),
                              'name'        => __( 'Name', \Xoxzo::TEXT_DOMAIN ),
                              'description' => __( 'Description', \Xoxzo::TEXT_DOMAIN ),
                              'action'      => '',
                          ) as $key => $column ) {
                    echo '<th class="' . esc_attr( $key ) . '">' . esc_html( $column ) . '</th>';
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            $voice_notifications = array(
                array(
                    "id" => Xoxzo::SETTING__NEW__VOICE,
                    "name" => "<strong style='font-size:large;'>New order</strong>".
                        "<br><br><strong>Selected Type:</strong>".
                        "<br>". (
                        get_option(Xoxzo::NEW__ENABLED__VOICE) === 'yes' ?
                            $notification_type(Xoxzo::NEW__TYPE__VOICE) :
                            $notification_type(0)
                        ).
                        "<br><br><strong>Recipient(s)</strong>".
                        "<br>".$recipient_list(Xoxzo::NEW__RECIPIENTS__VOICE),
                    "description" => Xoxzo::DESCRIPTION__NEW__VOICE,
                    "enabled" => get_option(Xoxzo::NEW__ENABLED__VOICE) === 'yes'
                        ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
                ),
                array(
                    "id" => Xoxzo::SETTING__CANCELLED__VOICE,
                    "name" => "<strong style='font-size:large;'>Cancelled order</strong>".
                        "<br><br><strong>Selected Type:</strong>".
                        "<br>". (
                        get_option(Xoxzo::CANCELLED__ENABLED__VOICE) === 'yes' ?
                            $notification_type(Xoxzo::CANCELLED__TYPE__VOICE) :
                            $notification_type(0)
                        ).
                        "<br><br><strong>Recipient(s)</strong>".
                        "<br>".$recipient_list(Xoxzo::CANCELLED__RECIPIENTS__VOICE),
                    "description" => Xoxzo::DESCRIPTION__CANCELLED__VOICE,
                    "enabled" => get_option(Xoxzo::CANCELLED__ENABLED__VOICE) === 'yes'
                        ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
                ),
                array(
                    "id" => Xoxzo::SETTING__FAILED__VOICE,
                    "name" => "<strong style='font-size:large;'>Failed order</strong>".
                        "<br><br><strong>Selected Type:</strong>".
                        "<br>". (
                        get_option(Xoxzo::FAILED__ENABLED__VOICE) === 'yes' ?
                            $notification_type(Xoxzo::FAILED__TYPE__VOICE) :
                            $notification_type(0)
                        ).
                        "<br><br><strong>Recipient(s)</strong>".
                        "<br>".$recipient_list(Xoxzo::FAILED__RECIPIENTS__VOICE),
                    "description" => Xoxzo::DESCRIPTION__FAILED__VOICE,
                    "enabled" => get_option(Xoxzo::FAILED__ENABLED__VOICE) === 'yes'
                        ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
                ),
                array(
                    "id" => Xoxzo::SETTING__ON_HOLD__VOICE,
                    "name" => "<strong style='font-size:large;'>Order on-hold</strong>".
                        "<br><br><strong>Selected Type:</strong>".
                        "<br>". (
                        get_option(Xoxzo::ON_HOLD__ENABLED__VOICE) === 'yes' ?
                            $notification_type(Xoxzo::ON_HOLD__TYPE__VOICE) :
                            $notification_type(0)
                        ).
                        "<br><br><strong>Recipient(s)</strong>".
                        "<br>Customer Phone OR Order Billing Phone",
                    "description" => Xoxzo::DESCRIPTION__ON_HOLD__VOICE,
                    "recipient" => "Customer(of the order)",
                    "enabled" => get_option(Xoxzo::ON_HOLD__ENABLED__VOICE) === 'yes'
                        ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
                ),
                array(
                    "id" => Xoxzo::SETTING__PROCESSING__VOICE,
                    "name" => "<strong style='font-size:large;'>Processing order</strong>".
                        "<br><br><strong>Selected Type:</strong>".
                        "<br>". (
                        get_option(Xoxzo::PROCESSING__ENABLED__VOICE) === 'yes' ?
                            $notification_type(Xoxzo::PROCESSING__TYPE__VOICE) :
                            $notification_type(0)
                        ).
                        "<br><br><strong>Recipient(s)</strong>".
                        "<br>Customer Phone OR Order Billing Phone",
                    "description" => Xoxzo::DESCRIPTION__PROCESSING__VOICE,
                    "recipient" => "Customer(of the order)",
                    "enabled" => get_option(Xoxzo::PROCESSING__ENABLED__VOICE) === 'yes'
                        ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
                ),
                array(
                    "id" => Xoxzo::SETTING__COMPLETED__VOICE,
                    "name" => "<strong style='font-size:large;'>Completed order</strong>".
                        "<br><br><strong>Selected Type:</strong>".
                        "<br>". (
                        get_option(Xoxzo::COMPLETED__ENABLED__VOICE) === 'yes' ?
                            $notification_type(Xoxzo::COMPLETED__TYPE__VOICE) :
                            $notification_type(0)
                        ).
                        "<br><br><strong>Recipient(s)</strong>".
                        "<br>Customer Phone OR Order Billing Phone",
                    "description" => Xoxzo::DESCRIPTION__COMPLETED__VOICE,
                    "recipient" => "Customer(of the order)",
                    "enabled" => get_option(Xoxzo::COMPLETED__ENABLED__VOICE) === 'yes'
                        ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
                ),
                array(
                    "id" => Xoxzo::SETTING__FULLY_REFUNDED__VOICE,
                    "name" => "<strong style='font-size:large;'>Fully refunded order</strong>".
                        "<br><br><strong>Selected Type:</strong>".
                        "<br>". (
                        get_option(Xoxzo::FULLY_REFUNDED__ENABLED__VOICE) === 'yes' ?
                            $notification_type(Xoxzo::FULLY_REFUNDED__TYPE__VOICE) :
                            $notification_type(0)
                        ).
                        "<br><br><strong>Recipient(s)</strong>".
                        "<br>Customer Phone OR Order Billing Phone",
                    "description" => Xoxzo::DESCRIPTION__FULLY_REFUNDED__VOICE,
                    "recipient" => "Customer(of the order)",
                    "enabled" => get_option(Xoxzo::FULLY_REFUNDED__ENABLED__VOICE) === 'yes'
                        ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
                ),
                array(
                    "id" => Xoxzo::SETTING__PARTIALLY_REFUNDED__VOICE,
                    "name" => "<strong style='font-size:large;'>Partially refunded order</strong>".
                        "<br><br><strong>Selected Type:</strong>".
                        "<br>". (
                        get_option(Xoxzo::PARTIALLY_REFUNDED__ENABLED__VOICE) === 'yes' ?
                            $notification_type(Xoxzo::PARTIALLY_REFUNDED__TYPE__VOICE) :
                            $notification_type(0)
                        ).
                        "<br><br><strong>Recipient(s)</strong>".
                        "<br>Customer Phone OR Order Billing Phone",
                    "description" => Xoxzo::DESCRIPTION__PARTIALLY_REFUNDED__VOICE,
                    "recipient" => "Customer(of the order)",
                    "enabled" => get_option(Xoxzo::PARTIALLY_REFUNDED__ENABLED__VOICE) === 'yes'
                        ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
                ),
                array(
                    "id" => Xoxzo::SETTING__LOW_STOCK__VOICE,
                    "name" => "<strong style='font-size:large;'>Low stock</strong>".
                        "<br><br><strong>Selected Type:</strong>".
                        "<br>". (
                        get_option(Xoxzo::LOW_STOCK__ENABLED__VOICE) === 'yes' ?
                            $notification_type(Xoxzo::LOW_STOCK__TYPE__VOICE) :
                            $notification_type(0)
                        ).
                        "<br><br><strong>Recipient(s)</strong>".
                        "<br>".$recipient_list(Xoxzo::LOW_STOCK__RECIPIENTS__VOICE),
                    "description" => Xoxzo::DESCRIPTION__LOW_STOCK__VOICE,
                    "recipient" => "Customer(of the order)",
                    "enabled" => get_option(Xoxzo::LOW_STOCK__ENABLED__VOICE) === 'yes'
                        ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
                ),
                array(
                    "id" => Xoxzo::SETTING__NO_STOCK__VOICE,
                    "name" => "<strong style='font-size:large;'>No stock</strong>".
                        "<br><br><strong>Selected Type:</strong>".
                        "<br>". (
                        get_option(Xoxzo::NO_STOCK__ENABLED__VOICE) === 'yes' ?
                            $notification_type(Xoxzo::NO_STOCK__TYPE__VOICE) :
                            $notification_type(0)
                        ).
                        "<br><br><strong>Recipient(s)</strong>".
                        "<br>".$recipient_list(Xoxzo::NO_STOCK__RECIPIENTS__VOICE),
                    "description" => Xoxzo::DESCRIPTION__NO_STOCK__VOICE,
                    "recipient" => "Customer(of the order)",
                    "enabled" => get_option(Xoxzo::NO_STOCK__ENABLED__VOICE) === 'yes'
                        ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
                ),
                array(
                    "id" => Xoxzo::SETTING__ORDER_DETAILS__VOICE,
                    "name" => "<strong style='font-size:large;'>Order details</strong>".
                        "<br><br><strong>Selected Type:</strong>".
                        "<br>". (
                        get_option(Xoxzo::ORDER_DETAILS__ENABLED__VOICE) === 'yes' ?
                            $notification_type(Xoxzo::ORDER_DETAILS__TYPE__VOICE) :
                            $notification_type(0)
                        ).
                        "<br><br><strong>Recipient(s)</strong>".
                        "<br>Customer Phone OR Order Billing Phone",
                    "description" => Xoxzo::DESCRIPTION__ORDER_DETAILS__VOICE,
                    "recipient" => "Customer(of the order)",
                    "enabled" => get_option(Xoxzo::ORDER_DETAILS__ENABLED__VOICE) === 'yes'
                        ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
                ),
                array(
                    "id" => Xoxzo::SETTING__CUSTOMER_NOTE__VOICE,
                    "name" => "<strong style='font-size:large;'>Customer note</strong>".
                        "<br><br><strong>Selected Type:</strong>".
                        "<br>". (
                        get_option(Xoxzo::CUSTOMER_NOTE__ENABLED__VOICE) === 'yes' ?
                            $notification_type(Xoxzo::CUSTOMER_NOTE__TYPE__VOICE) :
                            $notification_type(0)
                        ).
                        "<br><br><strong>Recipient(s)</strong>".
                        "<br>Customer Phone OR Order Billing Phone",
                    "description" => Xoxzo::DESCRIPTION__CUSTOMER_NOTE__VOICE,
                    "recipient" => "Customer(of the order)",
                    "enabled" => get_option(Xoxzo::CUSTOMER_NOTE__ENABLED__VOICE) === 'yes'
                        ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
                ),
                array(
                    "id" => Xoxzo::SETTING__RESET_PASSWORD__VOICE,
                    "name" => "<strong style='font-size:large;'>Reset password</strong>".
                        "<br><br><strong>Selected Type:</strong>".
                        "<br>". (
                        get_option(Xoxzo::RESET_PASSWORD__ENABLED__VOICE) === 'yes' ?
                            $notification_type(Xoxzo::RESET_PASSWORD__TYPE__VOICE) :
                            $notification_type(0)
                        ).
                        "<br><br><strong>Recipient(s)</strong>".
                        "<br>Customer's Phone",
                    "description" => Xoxzo::DESCRIPTION__RESET_PASSWORD__VOICE,
                    "recipient" => "Customer(of the order)",
                    "enabled" => get_option(Xoxzo::RESET_PASSWORD__ENABLED__VOICE) === 'yes'
                        ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
                ),
                array(
                    "id" => Xoxzo::SETTING__NEW_ACCOUNT__VOICE,
                    "name" => "<strong style='font-size:large;'>New account</strong>".
                        "<br><br><strong>Selected Type:</strong>".
                        "<br>". (
                        get_option(Xoxzo::NEW_ACCOUNT__ENABLED__VOICE) === 'yes' ?
                            $notification_type(Xoxzo::NEW_ACCOUNT__TYPE__VOICE) :
                            $notification_type(0)
                        ).
                        "<br><br><strong>Recipient(s)</strong>".
                        "<br>Customer's Phone",
                    "description" => Xoxzo::DESCRIPTION__NEW_ACCOUNT__VOICE,
                    "recipient" => "Customer(of the order)",
                    "enabled" => get_option(Xoxzo::NEW_ACCOUNT__ENABLED__VOICE) === 'yes'
                        ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
                ),
            );

            foreach ( $voice_notifications as $notification ) {

                echo '<tr data-gateway_id="' . esc_attr( $notification["id"] ) . '">';

                foreach ( array(
                              'status'      => __( 'Enabled', \Xoxzo::TEXT_DOMAIN ),
                              'name'        => __( 'Name', \Xoxzo::TEXT_DOMAIN ),
                              'description' => __( 'Description', \Xoxzo::TEXT_DOMAIN ),
                              'action'      => '',
                          ) as $key => $column ) {
                    $width = '';

                    if ( in_array( $key, array( 'sort', 'status', 'action' ), true ) ) {
                        $width = '1%';
                    }
                    echo '<td class="' . esc_attr( $key ) . '" width="' . esc_attr( $width ) . '">';
                    switch ( $key ) {
                        case 'name':
                            echo '<span class="wc-payment-gateway-method-name">' . wp_kses_post( $notification['name'] ) . '</span>';
                            break;
                        case 'description':
                            echo wp_kses_post( $notification['description'] );
                            break;
                        case 'action':
                            echo '<a class="button alignright" href="' . esc_url( admin_url( 'admin.php?page='.Xoxzo::PAGE.'&tab='.Xoxzo::TAB.'&section=' . strtolower( $notification['id']) ) ) . '">' . esc_html__( 'Edit', \Xoxzo::TEXT_DOMAIN ) . '</a>';
                            break;
                        case 'status':
                            echo $notification['enabled'];
                            break;
                    }
                    echo '</td>';
                }
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    </td>
</tr>
<style>
    .submit {
        display:none;
    }
</style>