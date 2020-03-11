<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit(0);
}

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class XoxzoListTableVoice extends \WP_List_Table {

    protected static $table_name_without_prefix = "woocommerce_xoxzo_status";
    protected $text_domain = "wc-xoxzo";

    /** Class constructor */
    public function __construct() {

        $this->menu_slug = "wc-settings";
        global $wpdb;
        $this->table_name = $wpdb->prefix."woocommerce_xoxzo_status";

        parent::__construct( [
            'singular' => __( 'Voice status', $this->text_domain ), //singular name of the listed records
            'plural'   => __( 'Voice status', $this->text_domain ), //plural name of the listed records
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
    public function column_default($item, $column_name) {
        switch($column_name) {
            case 'event':
                return \Xoxzo::parse_event_name($item[$column_name]);
            case 'start_time':
                if($item[$column_name]==="0000-00-00 00:00:00") {
                    return "-";
                }
                else {
                    return $item[$column_name];
                }
            case "end_time":
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
            '<input type="checkbox" name="bulk-voice-refresh[]" value="%s" />', $item["id"]
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
            'start_time' => array( 'start_time', false ),
            'end_time' => array( 'end_time', false ),
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
            'bulk-voice-refresh' => 'Refresh',
        ];
        return $actions;
    }

    /**
     * Returns the count of records in the database.
     *
     * @return null|string
     */
    public static function record_count() {
        global $wpdb;
        $table_name = $wpdb->prefix.self::$table_name_without_prefix;

        $count = $wpdb->get_var( "SELECT COUNT(id) FROM {$table_name} WHERE 1 = 1 AND notification_type='voice';");
        return absint( $count );
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

        $sql = "SELECT * FROM ".$wpdb->prefix.self::$table_name_without_prefix." WHERE notification_type='voice'";

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
            'msgid_callid'      => __( 'Call Id', $this->text_domain ),
            'cost'      => __( 'Cost', $this->text_domain ),
            'event'      => __( 'Event', $this->text_domain ),
            'recipient'      => __( 'Recipient', $this->text_domain ),
            'message'      => __( 'Message', $this->text_domain ),
            'status'    => __( 'Status', $this->text_domain ),
            'start_time' => __( 'Start Time', $this->text_domain ),
            'end_time' => __( 'End Time', $this->text_domain ),
            'created_at' => __( 'Created At', $this->text_domain ),
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
        if(!isset($_POST['bulk-voice-refresh']) or esc_attr(empty($_POST['bulk-voice-refresh']))) {
            return;
        }
        if(!in_array($current_action, ['bulk-voice-refresh']) or !is_array($_POST[$current_action])) {
            return;
        }
        // verify the nonce from response.
//        if ( ! wp_verify_nonce( esc_attr( $_REQUEST['_wpnonce'] ), 'wc_refresh_sms_status' ) ) {
//            die( 'Go get a life script kiddies' );
//        }

        if ( $current_action=='bulk-voice-refresh') {
            $list_of_ids = sanitize_text_field($_POST['bulk-voice-refresh']);
            foreach($list_of_ids as $i => $id){
                $list_of_ids[$i] = is_numeric($id) ? intval($id) : 0;
            }

            global $wpdb;
            $sql = "SELECT id, url FROM ".$wpdb->prefix.self::$table_name_without_prefix." WHERE notification_type='voice' AND id IN (".implode(",", $list_of_ids).")";

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

            $curl_arr = array();
            $master = curl_multi_init();
            for($i = 0; $i < $node_count; $i++)  {
                $url =$urls[$i];
                $curl_arr[$i] = curl_init($url);
                curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_arr[$i], CURLOPT_USERPWD, get_option("woocommerce_xoxzo_sid").":".get_option("woocommerce_xoxzo_auth_token"));
                curl_setopt($curl_arr[$i], CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                
                curl_multi_add_handle($master, $curl_arr[$i]);
            }

            do {
                curl_multi_exec($master,$running);
            }
            while($running > 0);

            $results = [];
            for($i = 0; $i < $node_count; $i++)  {
                $results[] = curl_multi_getcontent  ( $curl_arr[$i]  );
            }

            foreach($results as $result) {
                $data = json_decode($result);
                $wpdb->update(
                    $wpdb->prefix.self::$table_name_without_prefix,
                    array(
                        "sender" => $data->sender,
                        "cost" => $data->cost,
                        "status" => $data->status,
                        "recipient" => $data->recipient,
                        "start_time" => $data->start_time,
                        "end_time" => $data->end_time,
                        "duration" => $data->duration,
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
                admin_url('admin.php')
            );
            wp_redirect(
                $redirect_url
            );
            exit(0);
        }
    }
}
