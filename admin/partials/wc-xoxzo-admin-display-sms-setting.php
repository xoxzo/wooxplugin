<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit(0);
}

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

$sms_notifications = array(
    array(
        "id" => Xoxzo::SETTING__NEW__SMS,
        "name" => "<strong style='font-size:large;'>New order</strong>".
            "<br><br><strong>Recipient(s)</strong>".
            "<br>".$recipient_list(Xoxzo::NEW__RECIPIENTS__SMS),
        "description" => Xoxzo::DESCRIPTION__NEW__SMS,
        "enabled" => get_option(Xoxzo::NEW__ENABLED__SMS) === 'yes'
            ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
    ),
    array(
        "id" => Xoxzo::SETTING__CANCELLED__SMS,
        "name" => "<strong style='font-size:large;'>Cancelled order</strong>".
            "<br><br><strong>Recipient(s)</strong>".
            "<br>".$recipient_list(Xoxzo::CANCELLED__RECIPIENTS__SMS).
            "<br>AND<br>Customer Phone OR Order Billing Phone",
        "description" => Xoxzo::DESCRIPTION__CANCELLED__SMS,
        "enabled" => get_option(Xoxzo::CANCELLED__ENABLED__SMS) === 'yes'
            ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
    ),
    array(
        "id" => Xoxzo::SETTING__FAILED__SMS,
        "name" => "<strong style='font-size:large;'>Failed order</strong>".
            "<br><br><strong>Recipient(s)</strong>".
            "<br>".$recipient_list(Xoxzo::FAILED__RECIPIENTS__SMS),
        "description" => Xoxzo::DESCRIPTION__FAILED__SMS,
        "enabled" => get_option(Xoxzo::FAILED__ENABLED__SMS) === 'yes'
            ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
    ),
    array(
        "id" => Xoxzo::SETTING__ON_HOLD__SMS,
        "name" => "<strong style='font-size:large;'>Order on-hold</strong>".
            "<br><br><strong>Recipient(s)</strong>".
            "<br>Customer Phone OR Order Billing Phone",
        "description" => Xoxzo::DESCRIPTION__ON_HOLD__SMS,
        "recipient" => "Customer(of the order)",
        "enabled" => get_option(Xoxzo::ON_HOLD__ENABLED__SMS) === 'yes'
            ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
    ),
    array(
        "id" => Xoxzo::SETTING__PROCESSING__SMS,
        "name" => "<strong style='font-size:large;'>Processing order</strong>".
            "<br><br><strong>Recipient(s)</strong>".
            "<br>Customer Phone OR Order Billing Phone",
        "description" => Xoxzo::DESCRIPTION__PROCESSING__SMS,
        "recipient" => "Customer(of the order)",
        "enabled" => get_option(Xoxzo::PROCESSING__ENABLED__SMS) === 'yes'
            ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
    ),
    array(
        "id" => Xoxzo::SETTING__COMPLETED__SMS,
        "name" => "<strong style='font-size:large;'>Completed order</strong>".
            "<br><br><strong>Recipient(s)</strong>".
            "<br>Customer Phone OR Order Billing Phone",
        "description" => Xoxzo::DESCRIPTION__COMPLETED__SMS,
        "recipient" => "Customer(of the order)",
        "enabled" => get_option(Xoxzo::COMPLETED__ENABLED__SMS) === 'yes'
            ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
    ),
    array(
        "id" => Xoxzo::SETTING__FULLY_REFUNDED__SMS,
        "name" => "<strong style='font-size:large;'>Fully refunded order</strong>".
            "<br><br><strong>Recipient(s)</strong>".
            "<br>Customer Phone OR Order Billing Phone",
        "description" => Xoxzo::DESCRIPTION__FULLY_REFUNDED__SMS,
        "recipient" => "Customer(of the order)",
        "enabled" => get_option(Xoxzo::FULLY_REFUNDED__ENABLED__SMS) === 'yes'
            ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
    ),
    array(
        "id" => Xoxzo::SETTING__PARTIALLY_REFUNDED__SMS,
        "name" => "<strong style='font-size:large;'>Partially refunded order</strong>".
            "<br><br><strong>Recipient(s)</strong>".
            "<br>Customer Phone OR Order Billing Phone",
        "description" => Xoxzo::DESCRIPTION__PARTIALLY_REFUNDED__SMS,
        "recipient" => "Customer(of the order)",
        "enabled" => get_option(Xoxzo::PARTIALLY_REFUNDED__ENABLED__SMS) === 'yes'
            ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
    ),
    array(
        "id" => Xoxzo::SETTING__LOW_STOCK__SMS,
        "name" => "<strong style='font-size:large;'>Low stock</strong>".
            "<br><br><strong>Recipient(s)</strong>".
            "<br>".$recipient_list(Xoxzo::LOW_STOCK__RECIPIENTS__SMS),
        "description" => Xoxzo::DESCRIPTION__LOW_STOCK__SMS,
        "recipient" => "Customer(of the order)",
        "enabled" => get_option(Xoxzo::LOW_STOCK__ENABLED__SMS) === 'yes'
            ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
    ),
    array(
        "id" => Xoxzo::SETTING__NO_STOCK__SMS,
        "name" => "<strong style='font-size:large;'>No stock</strong>".
            "<br><br><strong>Recipient(s)</strong>".
            "<br>".$recipient_list(Xoxzo::NO_STOCK__RECIPIENTS__SMS),
        "description" => Xoxzo::DESCRIPTION__NO_STOCK__SMS,
        "recipient" => "Customer(of the order)",
        "enabled" => get_option(Xoxzo::NO_STOCK__ENABLED__SMS) === 'yes'
            ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
    ),
    array(
        "id" => Xoxzo::SETTING__ORDER_DETAILS__SMS,
        "name" => "<strong style='font-size:large;'>Order details</strong>".
            "<br><br><strong>Recipient(s)</strong>".
            "<br>Customer Phone OR Order Billing Phone",
        "description" => Xoxzo::DESCRIPTION__ORDER_DETAILS__SMS,
        "recipient" => "Customer(of the order)",
        "enabled" => get_option(Xoxzo::ORDER_DETAILS__ENABLED__SMS) === 'yes'
            ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
    ),
    array(
        "id" => Xoxzo::SETTING__CUSTOMER_NOTE__SMS,
        "name" => "<strong style='font-size:large;'>Customer note</strong>".
            "<br><br><strong>Recipient(s)</strong>".
            "<br>Customer Phone OR Order Billing Phone",
        "description" => Xoxzo::DESCRIPTION__CUSTOMER_NOTE__SMS,
        "recipient" => "Customer(of the order)",
        "enabled" => get_option(Xoxzo::CUSTOMER_NOTE__ENABLED__SMS) === 'yes'
            ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
    ),
    array(
        "id" => Xoxzo::SETTING__RESET_PASSWORD__SMS,
        "name" => "<strong style='font-size:large;'>Reset password</strong>".
            "<br><br><strong>Recipient(s)</strong>".
            "<br>Customer's Phone",
        "description" => Xoxzo::DESCRIPTION__RESET_PASSWORD__SMS,
        "recipient" => "Customer(of the order)",
        "enabled" => get_option(Xoxzo::RESET_PASSWORD__ENABLED__SMS) === 'yes'
            ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
    ),
    array(
        "id" => Xoxzo::SETTING__NEW_ACCOUNT__SMS,
        "name" => "<strong style='font-size:large;'>New account</strong>".
            "<br><br><strong>Recipient(s)</strong>".
            "<br>Customer's Phone",
        "description" => Xoxzo::DESCRIPTION__NEW_ACCOUNT__SMS,
        "recipient" => "Customer(of the order)",
        "enabled" => get_option(Xoxzo::NEW_ACCOUNT__ENABLED__SMS) === 'yes'
            ? '<span class="status-enabled tips">Yes</span>' : '<span class="status-disabled tips">No</span>',
    ),
);
hidden_fields("sms");
?>
<h2>
    <?php _e( 'Sms Notification', Xoxzo::TEXT_DOMAIN); ?>
    <a href="<?php echo admin_url( 'admin.php?page='.Xoxzo::PAGE.'&tab='.Xoxzo::TAB.'&section='.Xoxzo::SETTING__CUSTOM_EVENT__SMS); ?>" class="page-title-action">
        <?php esc_html_e( 'Send Custom Message', Xoxzo::TEXT_DOMAIN); ?>
    </a>
</h2>
<div id="api_option-description">
    <p>Sms notifications sent from Xoxzo are listed below. Click on an 'Edit' to configure it.</p>
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
            foreach ( $sms_notifications as $notification ) {
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