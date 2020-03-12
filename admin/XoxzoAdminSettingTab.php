<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit(0);
}

/**
 * SMS/Voice Tab in Woocommerce.
 */
class XoxzoAdminSettingTab {

    private $label;

    /**
     * Constructor.
     */
    public function __construct() {

        $this->id = Xoxzo::TAB;
        $this->label = __( Xoxzo::MENU__MAIN, Xoxzo::TEXT_DOMAIN );

        add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 50 );
        add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );
        add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
        add_action( 'woocommerce_settings_save_xoxzo', array( $this, 'save' ) );

        add_action( 'woocommerce_admin_field_textarea_custom', function ( $value ) {

            if ( ! isset( $value['id'] ) ) {
                $value['id'] = '';
            }
            if ( ! isset( $value['title'] ) ) {
                $value['title'] = isset( $value['name'] ) ? $value['name'] : '';
            }
            if ( ! isset( $value['class'] ) ) {
                $value['class'] = '';
            }
            if ( ! isset( $value['css'] ) ) {
                $value['css'] = '';
            }
            if ( ! isset( $value['default'] ) ) {
                $value['default'] = '';
            }
            if ( ! isset( $value['desc'] ) ) {
                $value['desc'] = '';
            }
            if ( ! isset( $value['desc_tip'] ) ) {
                $value['desc_tip'] = false;
            }
            if ( ! isset( $value['placeholder'] ) ) {
                $value['placeholder'] = '';
            }
            if ( ! isset( $value['suffix'] ) ) {
                $value['suffix'] = '';
            }

            // Custom attribute handling.
            $custom_attributes = array();

            if ( ! empty( $value['custom_attributes'] ) && is_array( $value['custom_attributes'] ) ) {
                foreach ( $value['custom_attributes'] as $attribute => $attribute_value ) {
                    $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
                }
            }

            // Description handling.
            $field_description = \WC_Admin_Settings::get_field_description( $value );
            $description       = $field_description['description'];
            $tooltip_html      = $field_description['tooltip_html'];

            $option_value = get_option( $value['id'] );
            if(empty($option_value)) {
                $option_value = $value['default'];
            }

            ?>
            <tr valign="top">
                <th scope="row" class="titledesc">
                    <label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?> <?php echo $tooltip_html; // WPCS: XSS ok. ?></label>
                </th>
                <td class="forminp forminp-<?php echo esc_attr( sanitize_title( $value['type'] ) ); ?>">
                    <?php echo $description; // WPCS: XSS ok. ?>

                    <textarea
                            name="<?php echo esc_attr( $value['id'] ); ?>"
                            id="<?php echo esc_attr( $value['id'] ); ?>"
                            style="<?php echo esc_attr( $value['css'] ); ?>"
                            class="<?php echo esc_attr( $value['class'] ); ?>"
                            placeholder="<?php echo esc_attr( $value['placeholder'] ); ?>"
                        <?php echo implode( ' ', $custom_attributes ); // WPCS: XSS ok. ?>
                    ><?php echo esc_textarea( $option_value ); // WPCS: XSS ok. ?></textarea>
                </td>
            </tr>
            <?php
        } );
    }

    /**
     * Add this page to settings.
     *
     * @param array $pages Existing pages.
     * @return array|mixed
     */
    public function add_settings_page($pages) {
        $pages[$this->id] = __( Xoxzo::MENU__MAIN, Xoxzo::TAB );
        return $pages;
    }

    /**
     * Output sections.
     */
    public function output_sections()
    {
        global $current_section;

        $sections = $this->get_sections();

        if(in_array($current_section, array(
            Xoxzo::ADMIN_SECTION_SMS,
            Xoxzo::SETTING__NEW__SMS,
            Xoxzo::SETTING__CANCELLED__SMS,
            Xoxzo::SETTING__FAILED__SMS,
            Xoxzo::SETTING__ON_HOLD__SMS,
            Xoxzo::SETTING__PROCESSING__SMS,
            Xoxzo::SETTING__COMPLETED__SMS,
            Xoxzo::SETTING__FULLY_REFUNDED__SMS,
            Xoxzo::SETTING__PARTIALLY_REFUNDED__SMS,
            Xoxzo::SETTING__LOW_STOCK__SMS,
            Xoxzo::SETTING__NO_STOCK__SMS,
            Xoxzo::SETTING__ORDER_DETAILS__SMS,
            Xoxzo::SETTING__CUSTOMER_NOTE__SMS,
            Xoxzo::SETTING__RESET_PASSWORD__SMS,
            Xoxzo::SETTING__NEW_ACCOUNT__SMS,
            Xoxzo::SETTING__CUSTOM_EVENT__SMS,
        ))) {
            $sms = true;
        }
        else {
            $sms = false;
        }

        if(in_array($current_section, array(
            Xoxzo::ADMIN_SECTION_VOICE,
            Xoxzo::SETTING__NEW__VOICE,
            Xoxzo::SETTING__CANCELLED__VOICE,
            Xoxzo::SETTING__FAILED__VOICE,
            Xoxzo::SETTING__ON_HOLD__VOICE,
            Xoxzo::SETTING__PROCESSING__VOICE,
            Xoxzo::SETTING__COMPLETED__VOICE,
            Xoxzo::SETTING__FULLY_REFUNDED__VOICE,
            Xoxzo::SETTING__PARTIALLY_REFUNDED__VOICE,
            Xoxzo::SETTING__LOW_STOCK__VOICE,
            Xoxzo::SETTING__NO_STOCK__VOICE,
            Xoxzo::SETTING__ORDER_DETAILS__VOICE,
            Xoxzo::SETTING__CUSTOMER_NOTE__VOICE,
            Xoxzo::SETTING__RESET_PASSWORD__VOICE,
            Xoxzo::SETTING__NEW_ACCOUNT__VOICE,
            Xoxzo::SETTING__CUSTOM_EVENT__VOICE,
        ))) {
            $voice = true;
        }
        else {
            $voice = false;
        }

        $class = 'class="current"';
        $empty = '';

        $url1 = admin_url( 'admin.php?page=' . Xoxzo::PAGE . '&tab=' . Xoxzo::TAB . '&section=' . Xoxzo::ADMIN_SECTION_BASIC );
        $url2 = admin_url( 'admin.php?page=' . Xoxzo::PAGE . '&tab=' . Xoxzo::TAB . '&section=' . Xoxzo::ADMIN_SECTION_STATUS_SMS );
        $url3 = admin_url( 'admin.php?page=' . Xoxzo::PAGE . '&tab=' . Xoxzo::TAB . '&section=' . Xoxzo::ADMIN_SECTION_SMS );
        $url4 = admin_url( 'admin.php?page=' . Xoxzo::PAGE . '&tab=' . Xoxzo::TAB . '&section=' . Xoxzo::ADMIN_SECTION_VOICE );

        echo '<ul class="subsubsub">';

        echo "<li><a href=\"{$url1}\"" . (in_array($current_section, [Xoxzo::ADMIN_SECTION_BASIC, ""]) ? $class : $empty) . ">{$sections["basic_configuration"]}</a></li>"
            ."| <li><a href=\"{$url2}\"" . ((in_array($current_section, [Xoxzo::ADMIN_SECTION_STATUS_SMS, Xoxzo::ADMIN_SECTION_STATUS_VOICE, Xoxzo::ADMIN_SECTION_STATUS_ERROR])) ? $class : $empty) . ">{$sections["sms-status"]}</a> </li>"
            ."| <li><a href=\"{$url3}\"" . (($sms) ? $class : $empty) . ">{$sections["sms"]}</a> </li>"
            ."| <li><a href=\"{$url4}\"" . (($voice) ? $class : $empty) . ">{$sections["voice"]}</a> </li>";

        echo '</ul><br class="clear" />';
    }

    /**
     * Output the settings.
     */
    public function output() {

        global $current_section;

        function hidden_fields($setting_page_id) {
            echo '<input type="hidden" name="section" value="'.$setting_page_id.'" />';
            echo '<input type="hidden" name="page" value="'.Xoxzo::PAGE.'"/>';
            echo '<input type="hidden" name="tab" value="'.Xoxzo::TAB.'" />';
        }

        if($current_section===Xoxzo::SETTING__CUSTOM_EVENT__SMS) {
            ob_start();
            require_once WC_XOXZO_PLUGIN_DIR. "/admin/partials/wc-xoxzo-admin-display-sms-custom-event.php";
            $contents =  ob_get_clean();
            echo $contents;
        }
        else if($current_section===Xoxzo::SETTING__CUSTOM_EVENT__VOICE) {
            ob_start();
            require_once WC_XOXZO_PLUGIN_DIR. "/admin/partials/wc-xoxzo-admin-display-voice-custom-event.php";
            $contents =  ob_get_clean();
            echo $contents;
        }
        else if(in_array($current_section, [
                Xoxzo::SETTING__NEW__SMS,
                Xoxzo::SETTING__CANCELLED__SMS,
                Xoxzo::SETTING__FAILED__SMS,
                Xoxzo::SETTING__ON_HOLD__SMS,
                Xoxzo::SETTING__PROCESSING__SMS,
                Xoxzo::SETTING__COMPLETED__SMS,
                Xoxzo::SETTING__FULLY_REFUNDED__SMS,
                Xoxzo::SETTING__PARTIALLY_REFUNDED__SMS,
                Xoxzo::SETTING__LOW_STOCK__SMS,
                Xoxzo::SETTING__NO_STOCK__SMS,
                Xoxzo::SETTING__ORDER_DETAILS__SMS,
                Xoxzo::SETTING__CUSTOMER_NOTE__SMS,
                Xoxzo::SETTING__RESET_PASSWORD__SMS,
                Xoxzo::SETTING__NEW_ACCOUNT__SMS,
        ])) {
            hidden_fields($current_section);
            WC_Admin_Settings::output_fields( XoxzoAdminSettingOptions::get($current_section) );
        }
        else if(in_array($current_section, [
            Xoxzo::SETTING__NEW__VOICE,
            Xoxzo::SETTING__CANCELLED__VOICE,
            Xoxzo::SETTING__FAILED__VOICE,
            Xoxzo::SETTING__ON_HOLD__VOICE,
            Xoxzo::SETTING__PROCESSING__VOICE,
            Xoxzo::SETTING__COMPLETED__VOICE,
            Xoxzo::SETTING__FULLY_REFUNDED__VOICE,
            Xoxzo::SETTING__PARTIALLY_REFUNDED__VOICE,
            Xoxzo::SETTING__LOW_STOCK__VOICE,
            Xoxzo::SETTING__NO_STOCK__VOICE,
            Xoxzo::SETTING__ORDER_DETAILS__VOICE,
            Xoxzo::SETTING__CUSTOMER_NOTE__VOICE,
            Xoxzo::SETTING__RESET_PASSWORD__VOICE,
            Xoxzo::SETTING__NEW_ACCOUNT__VOICE,
        ])) {
            hidden_fields($current_section);
            WC_Admin_Settings::output_fields( XoxzoAdminSettingOptions::get($current_section) );
        }
        else if(in_array($current_section, [Xoxzo::ADMIN_SECTION_BASIC, ""])) {
            hidden_fields($current_section);
            WC_Admin_Settings::output_fields( XoxzoAdminSettingOptions::get(Xoxzo::ADMIN_SECTION_BASIC) );
        }
        else if($current_section===Xoxzo::ADMIN_SECTION_SMS) {
            ob_start();
            require_once WC_XOXZO_PLUGIN_DIR. "/admin/partials/wc-xoxzo-admin-display-sms-setting.php";
            $contents =  ob_get_clean();
            echo $contents;
        }
        else if($current_section===Xoxzo::ADMIN_SECTION_VOICE) {
            ob_start();
            require_once WC_XOXZO_PLUGIN_DIR. "/admin/partials/wc-xoxzo-admin-display-voice-setting.php";
            $contents =  ob_get_clean();
            echo $contents;
        }
        else if($current_section===Xoxzo::ADMIN_SECTION_STATUS_SMS) {

            $GLOBALS["hide_save_button"] = true;

            echo '<h2>' . esc_html__( 'Status - SMS', Xoxzo::TEXT_DOMAIN ) . '</h2>';

            if ( \XoxzoListTableSms::record_count() > 0 ) {
                $table_list = new \XoxzoListTableSms;
                $table_list->prepare_items();

                echo '<input type="hidden" name="page" value="'.Xoxzo::PAGE.'" />';
                echo '<input type="hidden" name="tab" value="'.Xoxzo::TAB.'" />';
                echo '<input type="hidden" name="section" value="'.Xoxzo::ADMIN_SECTION_STATUS_SMS.'" />';

                add_filter( "views_woocommerce_page_wc-settings", function($views) {
                    return array(
                        Xoxzo::ADMIN_SECTION_STATUS_SMS => Xoxzo::MENU__STATUS_SMS ,
                        Xoxzo::ADMIN_SECTION_STATUS_VOICE => Xoxzo::MENU__STATUS_VOICE,
                        Xoxzo::ADMIN_SECTION_STATUS_ERROR => Xoxzo::MENU__STATUS_ERRORS,
                    );
                });
                ?>
                <ul class="subsubsub">
                    <li><a href="<?php echo admin_url( 'admin.php' ); ?>?page=<?php echo Xoxzo::PAGE;?>&amp;tab=<?php echo Xoxzo::TAB;?>&amp;section=<?php echo Xoxzo::ADMIN_SECTION_STATUS_SMS?>" class="current">SMS</a></li>
                    |
                    <li><a href="<?php echo admin_url( 'admin.php' ); ?>?page=<?php echo Xoxzo::PAGE;?>&amp;tab=<?php echo Xoxzo::TAB;?>&amp;section=<?php echo Xoxzo::ADMIN_SECTION_STATUS_VOICE?>">Voice</a> </li>
                    |
                    <li><a href="<?php echo admin_url( 'admin.php' ); ?>?page=<?php echo Xoxzo::PAGE;?>&amp;tab=<?php echo Xoxzo::TAB;?>&amp;section==<?php echo Xoxzo::ADMIN_SECTION_STATUS_ERROR?>">Errors</a> </li>
                </ul>
                <br class="clear">
                <?php
                $table_list->display();
            }
            else {
                ?>
                <ul class="subsubsub">
                    <li><a href="<?php echo admin_url( 'admin.php' ); ?>?page=<?php echo Xoxzo::PAGE;?>&amp;tab=<?php echo Xoxzo::TAB;?>&amp;section=<?php echo Xoxzo::ADMIN_SECTION_STATUS_SMS?>" class="current">SMS</a></li>
                    |
                    <li><a href="<?php echo admin_url( 'admin.php' ); ?>?page=<?php echo Xoxzo::PAGE;?>&amp;tab=<?php echo Xoxzo::TAB;?>&amp;section=<?php echo Xoxzo::ADMIN_SECTION_STATUS_VOICE?>">Voice</a> </li>
                    |
                    <li><a href="<?php echo admin_url( 'admin.php' ); ?>?page=<?php echo Xoxzo::PAGE;?>&amp;tab=<?php echo Xoxzo::TAB;?>&amp;section==<?php echo Xoxzo::ADMIN_SECTION_STATUS_ERROR?>">Errors</a> </li>
                </ul>
                <br class="clear">
                <div class="woocommerce-BlankState woocommerce-BlankState--api">
                <h2 class="woocommerce-BlankState-message"><?php esc_html_e( 'No calls found at the moment.', 'woocommerce' ); ?></h2>
                <style type="text/css">
                    #posts-filter .wp-list-table,
                    #posts-filter .tablenav.top,
                    .tablenav.bottom .actions {
                        display: none;
                    }
                </style>
                <?php
            }
        }
        else if($current_section===Xoxzo::ADMIN_SECTION_STATUS_VOICE) {

            $GLOBALS["hide_save_button"] = true;

            echo '<h2>' . esc_html__( 'Status - Voice', Xoxzo::TEXT_DOMAIN ) . '</h2>';

            if ( \XoxzoListTableVoice::record_count() > 0 ) {
                $table_list = new \XoxzoListTableVoice();
                $table_list->prepare_items();

                echo '<input type="hidden" name="page" value="'.Xoxzo::PAGE.'" />';
                echo '<input type="hidden" name="tab" value="'.Xoxzo::TAB.'" />';
                echo '<input type="hidden" name="section" value="'.Xoxzo::ADMIN_SECTION_STATUS_VOICE.'" />';

                add_filter( "views_woocommerce_page_wc-settings", function($views) {
                    return array(
                        Xoxzo::ADMIN_SECTION_STATUS_SMS => Xoxzo::MENU__STATUS_SMS ,
                        Xoxzo::ADMIN_SECTION_STATUS_VOICE => Xoxzo::MENU__STATUS_VOICE,
                        Xoxzo::ADMIN_SECTION_STATUS_ERROR => Xoxzo::MENU__STATUS_ERRORS,
                    );
                });
                ?>
                <ul class="subsubsub">
                    <li><a href="<?php echo admin_url( 'admin.php' ); ?>?page=<?php echo Xoxzo::PAGE;?>&amp;tab=<?php echo Xoxzo::TAB;?>&amp;section=<?php echo Xoxzo::ADMIN_SECTION_STATUS_SMS?>">SMS</a></li>
                    |
                    <li><a href="<?php echo admin_url( 'admin.php' ); ?>?page=<?php echo Xoxzo::PAGE;?>&amp;tab=<?php echo Xoxzo::TAB;?>&amp;section=<?php echo Xoxzo::ADMIN_SECTION_STATUS_VOICE?>" class="current">Voice</a> </li>
                    |
                    <li><a href="<?php echo admin_url( 'admin.php' ); ?>?page=<?php echo Xoxzo::PAGE;?>&amp;tab=<?php echo Xoxzo::TAB;?>&amp;section==<?php echo Xoxzo::ADMIN_SECTION_STATUS_ERROR?>">Errors</a> </li>
                </ul>
                <br class="clear">
                <?php
                $table_list->display();
            }
            else {
                ?>
                <ul class="subsubsub">
                    <li><a href="<?php echo admin_url( 'admin.php' ); ?>?page=<?php echo Xoxzo::PAGE;?>&amp;tab=<?php echo Xoxzo::TAB;?>&amp;section=<?php echo Xoxzo::ADMIN_SECTION_STATUS_SMS?>">SMS</a></li>
                    |
                    <li><a href="<?php echo admin_url( 'admin.php' ); ?>?page=<?php echo Xoxzo::PAGE;?>&amp;tab=<?php echo Xoxzo::TAB;?>&amp;section=<?php echo Xoxzo::ADMIN_SECTION_STATUS_VOICE?>" class="current">Voice</a> </li>
                    |
                    <li><a href="<?php echo admin_url( 'admin.php' ); ?>?page=<?php echo Xoxzo::PAGE;?>&amp;tab=<?php echo Xoxzo::TAB;?>&amp;section==<?php echo Xoxzo::ADMIN_SECTION_STATUS_ERROR?>">Errors</a> </li>
                </ul>
                <br class="clear">
                <div class="woocommerce-BlankState woocommerce-BlankState--api">
                <h2 class="woocommerce-BlankState-message"><?php esc_html_e( 'No calls found at the moment.', 'woocommerce' ); ?></h2>
                <style type="text/css">
                    #posts-filter .wp-list-table,
                    #posts-filter .tablenav.top,
                    .tablenav.bottom .actions {
                        display: none;
                    }
                </style>
                <?php
            }
        }
        else if($current_section===Xoxzo::ADMIN_SECTION_STATUS_ERROR) {

            $GLOBALS["hide_save_button"] = true;

            echo '<h2>' . esc_html__( 'Status - Errors', Xoxzo::TEXT_DOMAIN ) . '</h2>';

            if ( \XoxzoListTableErrors::record_count() > 0 ) {
                $table_list = new \XoxzoListTableErrors();
                $table_list->prepare_items();

                echo '<input type="hidden" name="page" value="'.Xoxzo::PAGE.'" />';
                echo '<input type="hidden" name="tab" value="'.Xoxzo::TAB.'" />';
                echo '<input type="hidden" name="section" value="'.Xoxzo::ADMIN_SECTION_STATUS_ERROR.'" />';

                add_filter( "views_woocommerce_page_wc-settings", function($views) {
                    return array(
                        Xoxzo::ADMIN_SECTION_STATUS_SMS => Xoxzo::MENU__STATUS_SMS ,
                        Xoxzo::ADMIN_SECTION_STATUS_VOICE => Xoxzo::MENU__STATUS_VOICE,
                        Xoxzo::ADMIN_SECTION_STATUS_ERROR => Xoxzo::MENU__STATUS_ERRORS,
                    );
                });
                ?>
                <ul class="subsubsub">
                    <li><a href="<?php echo admin_url( 'admin.php' ); ?>?page=<?php echo Xoxzo::PAGE;?>&amp;tab=<?php echo Xoxzo::TAB;?>&amp;section=<?php echo Xoxzo::ADMIN_SECTION_STATUS_SMS?>">SMS</a></li>
                    |
                    <li><a href="<?php echo admin_url( 'admin.php' ); ?>?page=<?php echo Xoxzo::PAGE;?>&amp;tab=<?php echo Xoxzo::TAB;?>&amp;section=<?php echo Xoxzo::ADMIN_SECTION_STATUS_VOICE?>">Voice</a> </li>
                    |
                    <li><a href="<?php echo admin_url( 'admin.php' ); ?>?page=<?php echo Xoxzo::PAGE;?>&amp;tab=<?php echo Xoxzo::TAB;?>&amp;section==<?php echo Xoxzo::ADMIN_SECTION_STATUS_ERROR?>" class="current">Errors</a> </li>
                </ul>
                <br class="clear">
                <?php
                $table_list->display();
            }
            else {
                ?>
                <ul class="subsubsub">
                    <li><a href="<?php echo admin_url( 'admin.php' ); ?>?page=<?php echo Xoxzo::PAGE;?>&amp;tab=<?php echo Xoxzo::TAB;?>&amp;section=<?php echo Xoxzo::ADMIN_SECTION_STATUS_SMS?>">SMS</a></li>
                    |
                    <li><a href="<?php echo admin_url( 'admin.php' ); ?>?page=<?php echo Xoxzo::PAGE;?>&amp;tab=<?php echo Xoxzo::TAB;?>&amp;section=<?php echo Xoxzo::ADMIN_SECTION_STATUS_VOICE?>">Voice</a> </li>
                    |
                    <li><a href="<?php echo admin_url( 'admin.php' ); ?>?page=<?php echo Xoxzo::PAGE;?>&amp;tab=<?php echo Xoxzo::TAB;?>&amp;section==<?php echo Xoxzo::ADMIN_SECTION_STATUS_ERROR?>" class="current">Errors</a> </li>
                </ul>
                <br class="clear">
                <div class="woocommerce-BlankState woocommerce-BlankState--api">
                <h2 class="woocommerce-BlankState-message"><?php esc_html_e( 'No calls found at the moment.', 'woocommerce' ); ?></h2>
                <style type="text/css">
                    #posts-filter .wp-list-table,
                    #posts-filter .tablenav.top,
                    .tablenav.bottom .actions {
                        display: none;
                    }
                </style>
                <?php
            }
        }
    }

    /**
     * Save settings.
     */
    public function save() {

        global $current_section;

        if(in_array($current_section, [
            Xoxzo::ADMIN_SECTION_BASIC,
            Xoxzo::ADMIN_SECTION_SMS,
            Xoxzo::ADMIN_SECTION_VOICE,
            Xoxzo::SETTING__NEW__SMS,
            Xoxzo::SETTING__CANCELLED__SMS,
            Xoxzo::SETTING__FAILED__SMS,
            Xoxzo::SETTING__ON_HOLD__SMS,
            Xoxzo::SETTING__PROCESSING__SMS,
            Xoxzo::SETTING__COMPLETED__SMS,
            Xoxzo::SETTING__FULLY_REFUNDED__SMS,
            Xoxzo::SETTING__PARTIALLY_REFUNDED__SMS,
            Xoxzo::SETTING__LOW_STOCK__SMS,
            Xoxzo::SETTING__NO_STOCK__SMS,
            Xoxzo::SETTING__ORDER_DETAILS__SMS,
            Xoxzo::SETTING__CUSTOMER_NOTE__SMS,
            Xoxzo::SETTING__RESET_PASSWORD__SMS,
            Xoxzo::SETTING__NEW_ACCOUNT__SMS,
            Xoxzo::SETTING__NEW__VOICE,
            Xoxzo::SETTING__CANCELLED__VOICE,
            Xoxzo::SETTING__FAILED__VOICE,
            Xoxzo::SETTING__ON_HOLD__VOICE,
            Xoxzo::SETTING__PROCESSING__VOICE,
            Xoxzo::SETTING__COMPLETED__VOICE,
            Xoxzo::SETTING__FULLY_REFUNDED__VOICE,
            Xoxzo::SETTING__PARTIALLY_REFUNDED__VOICE,
            Xoxzo::SETTING__LOW_STOCK__VOICE,
            Xoxzo::SETTING__NO_STOCK__VOICE,
            Xoxzo::SETTING__ORDER_DETAILS__VOICE,
            Xoxzo::SETTING__CUSTOMER_NOTE__VOICE,
            Xoxzo::SETTING__RESET_PASSWORD__VOICE,
            Xoxzo::SETTING__NEW_ACCOUNT__VOICE
        ])) {
            woocommerce_update_options( XoxzoAdminSettingOptions::get($current_section) );
        }
        else if($current_section===Xoxzo::SETTING__CUSTOM_EVENT__SMS) {
            (new XoxzoSmsResponse)->send_custom_event();
        }
        else if($current_section===Xoxzo::SETTING__CUSTOM_EVENT__VOICE) {
            (new XoxzoVoiceResponse)->send_custom_event();
        }
    }

    /**
     * Get sections.
     *
     * @return array
     */
    public function get_sections() {
        $sections = [
            Xoxzo::ADMIN_SECTION_BASIC  => __( Xoxzo::MENU__BASIC_CONFIGURATION, Xoxzo::TEXT_DOMAIN ),
            Xoxzo::ADMIN_SECTION_SMS  => __( Xoxzo::MENU__SMS_NOTIFICATION, Xoxzo::TEXT_DOMAIN ),
            Xoxzo::ADMIN_SECTION_VOICE  => __( Xoxzo::MENU__VOICE_NOTIFICATION, Xoxzo::TEXT_DOMAIN ),
            Xoxzo::ADMIN_SECTION_STATUS_SMS  => __( Xoxzo::MENU__STATUS, Xoxzo::TEXT_DOMAIN ),
            Xoxzo::ADMIN_SECTION_STATUS_VOICE  => __( Xoxzo::MENU__STATUS, Xoxzo::TEXT_DOMAIN ),
            Xoxzo::ADMIN_SECTION_STATUS_ERROR  => __( Xoxzo::MENU__STATUS, Xoxzo::TEXT_DOMAIN ),
        ];
        return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
    }
}