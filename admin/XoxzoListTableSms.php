<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit(0);
}

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class XoxzoListTableSms extends \WP_List_Table {

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct( [
            'singular' => __( 'SMS status', \Xoxzo::TEXT_DOMAIN ), //singular name of the listed records
            'plural'   => __( 'SMS status', \Xoxzo::TEXT_DOMAIN ), //plural name of the listed records
            'ajax'     => false //should this table support ajax?
        ] );
    }

    /**
     * Render a column when no column specific method exists.
     *
     * @param array $item
     * @param string $column_name
     *
     * @return mixed
     */
    public function column_default($item, $column_name){
        switch($column_name) {
            case 'event':
                return \Xoxzo::parse_event_name($item[$column_name]);
            case "sent_time":
                if($item[$column_name]==="0000-00-00 00:00:00") {
                    return "-";
                }
                else {
                    return $item[$column_name];
                }
            default:
                return $item[$column_name];
        }
    }

    /**
     * Render the bulk edit checkbox
     *
     * @param array $item
     *
     * @return string
     */
    public function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="bulk-sms-refresh[]" value="%s" />', $item["id"]
        );
    }

    /**
     * Columns to make sortable.
     *
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'msgid_callid' => array( 'msgid_callid', false ),
            'status' => array( 'status', false ),
            'created_at' => array( 'created_at', false ),
            'sent_time' => array( 'sent_time', false ),
        );

        return $sortable_columns;
    }

    /**
     * Returns an associative array containing the bulk action
     *
     * @return array
     */
    public function get_bulk_actions() {
        $actions = [
            'bulk-sms-refresh' => 'Refresh',
        ];
        return $actions;
    }

    /**
     * Retrieve xoxzo statuses data from the database
     *
     * @param int $per_page
     * @param int $page_number
     *
     * @return mixed
     */
    public static function get_statuses( $per_page = 20, $page_number = 1 ) {

        global $wpdb;

        $table_name = (new \Xoxzo)->table_name__status();
        $sql = "SELECT * FROM ".$table_name." WHERE notification_type='sms'";

        if ( ! empty( $_REQUEST['orderby'] ) ) {
            $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
            $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' DESC';
        }
        else {
            $sql .= ' ORDER BY created_at DESC';
        }
        $sql .= " LIMIT $per_page";
        $sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;


        $result = $wpdb->get_results( $sql, 'ARRAY_A' );

        return $result;
    }

    /**
     *  Associative array of columns
     *
     * @return array
     */
    public function get_columns() {
        $columns = [
            'cb'      => '<input type="checkbox" />',
            'msgid_callid'      => __( 'Msgid', \Xoxzo::TEXT_DOMAIN ),
            'cost'      => __( 'Cost', \Xoxzo::TEXT_DOMAIN ),
            'event'      => __( 'Event', \Xoxzo::TEXT_DOMAIN ),
            'sender'      => __( 'Sender Id', \Xoxzo::TEXT_DOMAIN ),
            'recipient'      => __( 'Recipient', \Xoxzo::TEXT_DOMAIN ),
            'message'      => __( 'Message', \Xoxzo::TEXT_DOMAIN ),
            'status'    => __( 'Status', \Xoxzo::TEXT_DOMAIN ),
            'sent_time' => __( 'Sent Time', \Xoxzo::TEXT_DOMAIN ),
            'created_at' => __( 'Created At', \Xoxzo::TEXT_DOMAIN ),
        ];
        return $columns;
    }

    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items() {

        /*$this->get_column_info();*/
        $this->_column_headers = array(
            $this->get_columns(),
            array(),
            $this->get_sortable_columns()
        );
        $this->process_bulk_action();

        $per_page     = $this->get_items_per_page( 'status_per_page', 20 );
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();

        $this->set_pagination_args( [
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page'    => $per_page //WE have to determine how many items to show on a page
        ] );
        $this->items = self::get_statuses( $per_page, $current_page );
    }

    /**
     * Process bulk actions.
     */
    public function process_bulk_action() {
        //Detect when a bulk action is being triggered...
        $current_action = $this->current_action();
        if(!isset($_POST['bulk-sms-refresh']) or empty($_POST['bulk-sms-refresh'])) {
            return;
        }
        if(!in_array($current_action, ['bulk-sms-refresh']) or !is_array($_POST[$current_action])) {
            return;
        }
        // verify the nonce from response.
//        if ( ! wp_verify_nonce( esc_attr( $_REQUEST['_wpnonce'] ), 'wc_refresh_sms_status' ) ) {
//            die( 'Go get a life script kiddies' );
//        }

        if ( $current_action=='bulk-sms-refresh') {
            $list_of_ids = sanitize_text_field($_POST['bulk-sms-refresh']);
            foreach($list_of_ids as $i => $id){
                $list_of_ids[$i] = is_numeric($id) ? intval($id) : 0;
            }

            global $wpdb;
            $table_name = (new \Xoxzo)->table_name__status();
            $sql = "SELECT id, url FROM ".$table_name." WHERE notification_type='sms' AND id IN (".implode(",", $list_of_ids).")";

            $urls = [];
            $cache = [];
            foreach($wpdb->get_results( $sql, 'ARRAY_A' ) as $result) {
                $cache[$result['url']] = $result['id'];
                $urls[] = $result['url'];
            }

            $node_count = count($urls);
            if($node_count==0) {
                $redirect_url = add_query_arg(
                    array(
                        'section' => sanitize_text_field($_POST['section']),
                        'page' => sanitize_text_field($_POST['page']),
                        'tab' => sanitize_text_field($_POST['tab']),
                        'paged' => sanitize_text_field($_POST['paged']),
                    ),
                    admin_url( 'admin.php' )
                );
                wp_redirect(
                    $redirect_url
                );
                exit(0);
            }


                
        $encodedAuth = base64_encode(get_option("woocommerce_xoxzo_sid").":".get_option("woocommerce_xoxzo_auth_token"));

        $response = wp_remote_request( $url,
            array(
                "headers" => array(
                    "Authorization" => "Basic ".$encodedAuth
                ),
                "method" => "GET",
            )
        );

    
        $results = json_decode($response['body'], true);

            $table_name = (new \Xoxzo)->table_name__status();
            foreach($results as $result) {
                $data = json_decode($result);
                $wpdb->update(
                    $table_name,
                    array(
                        "sender" => $data->sender,
                        "cost" => $data->cost,
                        "status" => $data->status,
                        "recipient" => $data->recipient,
                        "sent_time" => $data->sent_time,
                    ),
                    array(
                        'id' => $cache[$data->url]
                    )
                );
            }

            $redirect_url = add_query_arg(
                array(
                    'section' => sanitize_text_field($_POST['section']),
                    'page' => sanitize_text_field($_POST['page']),
                    'tab' => sanitize_text_field($_POST['tab']),
                    'paged' => sanitize_text_field($_POST['paged']),
                ),
                admin_url( 'admin.php' )   
            );
            wp_redirect(
                $redirect_url
            );
            exit(0);
        }
    }

    /**
     * Returns the count of records in the database.
     *
     * @return null|string
     */
    public static function record_count() {
        global $wpdb;
        $table_name = (new \Xoxzo)->table_name__status();
        $count = $wpdb->get_var( "SELECT COUNT(id) FROM {$table_name} WHERE 1 = 1 AND notification_type='sms';");
        return absint( $count );
    }
}
