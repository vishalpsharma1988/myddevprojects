<?php

/**
 * @link       https://corephp.com
 * @since      1.0.0
 *
 * @package    Mkd_Builder
 * @subpackage Mkd_Builder/includes
 * @author     Core PHP <support@corephp.com>
 */


/**
 * Controls Tables
 */
class Wmr_Client_Tables
{

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Initialize the class
     *
     * @since     1.0.0
     */
    public function __construct()
    {
        $this->create_table();
        $this->alter_table();
    }

     /**
    *** setup the table
     */
    public static function init_table()
    {

        // // If the single instance hasn't been set, set it now.
        // if (null == self::$instance) {
        //     self::$instance = new self;
        // }

        // return self::$instance;


    }

    /**
    *** Create table method
     */
    public function create_table()
    {

      global $wpdb;

    $client_table_name = $wpdb->prefix . 'wmr_client';
    $site_report_table_name = $wpdb->prefix . 'wmr_client_site_report';

    $charset_collate = $wpdb->get_charset_collate();

    $client_sql = "CREATE TABLE $client_table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        client_name tinytext NOT NULL,
        client_email varchar(55) DEFAULT '' NOT NULL,
        client_website varchar(55) DEFAULT '' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";


    $site_report_sql = "CREATE TABLE $site_report_table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        client_id bigint(20) UNSIGNED NOT NULL,
        maintenance_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        wordpress varchar(55) DEFAULT '' NOT NULL,
        plugins varchar(55) DEFAULT '' NOT NULL,
        themes varchar(55) DEFAULT '' NOT NULL,
        php_upgrade varchar(55) DEFAULT '' NOT NULL,
        notes LONGTEXT,
        status varchar(55) DEFAULT '' NOT NULL,
        PRIMARY KEY  (id),
        FOREIGN KEY (client_id) REFERENCES $client_table_name(id)

    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $client_sql );
    dbDelta( $site_report_sql );
    }

    /**
     * Handle AJAX: Frontend Example
     *
     * @since    1.0.0
     */
    public function alter_table()
    {

        
    }

}