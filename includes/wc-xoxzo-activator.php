<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Wc_Xoxzo
 * @subpackage Wc_Xoxzo/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wc_Xoxzo
 * @subpackage Wc_Xoxzo/includes
 * @author     Your Name <email@example.com>
 */
class Wc_Xoxzo_Activator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $table_status = $wpdb->prefix . "woocommerce_xoxzo_status";
        $table_error = $wpdb->prefix . "woocommerce_xoxzo_error";

        /* Create the call status table if does not exist
         * */
        if(!self::has_table($table_status)) {
            $sql_status_table_statement = self::sql_status_table($table_status, $charset_collate);
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql_status_table_statement );
        }

        if(!self::has_table($table_error)) {
            $sql_error_table_statement = self::sql_error_table($table_error, $charset_collate);
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql_error_table_statement );
        }
    }

    public static function sql_status_table($table_name, $charset_collate) {
        return "CREATE TABLE $table_name (
  id bigint NOT NULL AUTO_INCREMENT,
  notification_type text NOT NULL,
  msgid_callid text NOT NULL,
  cost text NOT NULL,
  duration text NULL,
  event text NOT NULL,
  sender text NOT NULL,
  message text NULL,
  status text NOT NULL,
  caller text NULL,
  recipient text NOT NULL,
  url text NOT NULL,
  start_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  end_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  sent_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  PRIMARY KEY  (id)
) $charset_collate;";
    }

    public static function sql_error_table($table_name, $charset_collate) {
        return "CREATE TABLE $table_name (
  id bigint NOT NULL AUTO_INCREMENT,
  notification_type text NOT NULL,
  event text NOT NULL,
  error_code text NOT NULL,
  error_message text NOT NULL,
  recipient text NOT NULL,
  message text NULL,
  sender text NOT NULL,
  created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  PRIMARY KEY  (id)
) $charset_collate;";
    }

    public static function has_table($table_name)
    {
        global $wpdb;
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
            //table not in database.
            return true;
        }
        return false;
    }
}