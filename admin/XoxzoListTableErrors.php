<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit(0);
}

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class XoxzoListTableErrors extends \WP_List_Table {

    /** Class constructor */
    public function __construct() {

        $this->table_name = (new \Xoxzo)->table_name__error();
        parent::__construct( [
            'singular' => __( 'Errors', \Xoxzo::TEXT_DOMAIN ), //singular name of the listed records
            'plural'   => __( 'Errors', \Xoxzo::TEXT_DOMAIN ), //plural name of the listed records
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
    public function column_default( $item, $column_name ) {
        switch($column_name) {
            case 'notification_type':
                return ucwords($item[$column_name]);
            case 'event':
                return \Xoxzo::parse_event_name($item[$column_name]);
            case 'error_message':
                $_ = '';
                foreach(json_decode($item[$column_name]) as $name => $message) {
                    if(is_array($message)) {
                        foreach($message as $messagep) {
                            $_ = $_. ucwords(implode(" ", explode("_", $name))) . ": ". $messagep . "<br>";
                        }
                    }
                    else {
                        $_ = $_. ucwords(implode(" ", explode("_", $name))) . ": ". $message . "<br>";
                    }
                }
                return $_;
            default:
                return $item[$column_name];
        }
    }

    /**
     * Columns to make sortable.
     *
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'notification_type' => array( 'notification_type', false ),
            'event' => array( 'event', false ),
            'error_code' => array( 'error_code', false ),
            'error_message' => array( 'error_message', false ),
            'recipient' => array( 'recipient', false ),
            'sender' => array( 'sender', false ),
            'created_at' => array( 'created_at', false )
        );
        return $sortable_columns;
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

        $table_name = (new \Xoxzo)->table_name__error();
        $sql = "SELECT * FROM ".$table_name;
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
            'notification_type' => __( 'Notification Type', \Xoxzo::TEXT_DOMAIN ),
            'event'      => __( 'Event', \Xoxzo::TEXT_DOMAIN ),
            'error_code'      => __( 'Error Code', \Xoxzo::TEXT_DOMAIN ),
            'error_message'      => __( 'Error Message', \Xoxzo::TEXT_DOMAIN ),
            'recipient'      => __( 'Recipient', \Xoxzo::TEXT_DOMAIN ),
            'message'      => __( 'Message', \Xoxzo::TEXT_DOMAIN ),
            'sender'    => __( 'Sender', \Xoxzo::TEXT_DOMAIN ),
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
     * Returns the count of records in the database.
     *
     * @return null|string
     */
    public static function record_count() {
        global $wpdb;
        $table_name = (new \Xoxzo)->table_name__error();
        $count = $wpdb->get_var( "SELECT COUNT(id) FROM {$table_name} WHERE 1 = 1;");
        return absint( $count );
    }
}