<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/vishalpsharma1988
 * @since      1.0.0
 *
 * @package    Wmr
 * @subpackage Wmr/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wmr
 * @subpackage Wmr/admin
 * @author     vishal sharma <vishalpsharma1988@gmail.com>
 */

class Wmr_Data_Query{

     // Class property to hold the global $wpdb object
     private $wpdb;

     public function __construct() {
         global $wpdb;
         // Assign the global $wpdb to the class property
         $this->wpdb = $wpdb;
     }

    public function my_custom_list_table_get_item( $id ) {

        $client_table =  $this->wpdb->prefix . 'wmr_client';
        $client_site_report_table =  $this->wpdb->prefix . 'wmr_client_site_report';
        $data =  $this->wpdb->get_row(
             "SELECT * FROM {$client_table} INNER JOIN {$client_site_report_table} ON {$client_table}.id=$client_site_report_table.client_id WHERE {$client_table}.id=$id ");
             include_once( plugin_dir_path( __FILE__ ) . '/partials/wmr-client-display.php' );

    // Update the data in the database
    if ( isset( $_POST['submit'] ) ) {

            $client_name  = sanitize_text_field( $_POST['client_name'] );
            $client_email = sanitize_email( $_POST['client_email'] );
            $client_website = esc_url_raw( $_POST['client_website'] );
            $client_id = sanitize_text_field( $_POST['client_id'] );
            $maintenance_date = esc_attr( $_POST['maintenance_date'] );
            $wordpress = isset($_POST['wordpress']) ? sanitize_key($_POST['wordpress']) : 'false';
            $plugins = isset($_POST['plugins']) ? sanitize_key($_POST['plugins']) : 'false';
            $themes = isset($_POST['themes']) ? sanitize_key($_POST['themes']) : 'false';
            $php_upgrade = isset($_POST['php_upgrade']) ? sanitize_key($_POST['php_upgrade']) : 'false';
            $notes = sanitize_textarea_field( $_POST['notes'] );
            $status = sanitize_textarea_field( $_POST['options']['status'] );
       //  echo "<pre>"; print_r($_POST);

        $updated = $this->my_custom_list_table_update_item( $id, $client_id, $client_name, $client_email, $maintenance_date, $client_website, $wordpress, $plugins, $themes, $php_upgrade, $notes, $status);
            if ($updated !== false) {
                wp_redirect( admin_url( 'admin.php?page=wmr_report' ) );
                exit;
            } else {
                // Redirect with a failure message
                wp_redirect(add_query_arg('update', 'failure', $_SERVER['REQUEST_URI']));
                exit;
            }
        }
    }
    function my_custom_list_table_update_item( $id, $client_id, $client_name, $client_email, $maintenance_date, $client_website, $wordpress, $plugins, $themes, $php_upgrade, $notes, $status ) {
     //   echo $status; die();
        $client_table =  $this->wpdb->prefix . 'wmr_client';
        $client_site_report_table =  $this->wpdb->prefix . 'wmr_client_site_report';
        $currentTime = date('H:i:s');
     //   echo $status; die();
        $query = "
            UPDATE $client_table c
            INNER JOIN $client_site_report_table cr ON c.id = cr.client_id
            SET 
                c.client_name = %s,
                c.client_email = %s,
                c.client_website = %s,
                cr.maintenance_date = %s,
                cr.wordpress = %s,
                cr.plugins = %s,
                cr.themes = %s,
                cr.php_upgrade = %s,
                cr.notes = %s,
                cr.status = %s
            WHERE c.id = %d
        ";

        $updated =  $this->wpdb->query(
            $this->wpdb->prepare(
                    $query,
                    $client_name,
                    $client_email,
                    $client_website,
                    $maintenance_date . ' ' . $currentTime,
                    $wordpress,
                    $plugins,
                    $themes,
                    $php_upgrade,
                    $notes,
                    $status,
                    $id
                )
        );
        // Check if the update was successful
        if ($updated !== false) {
            // Redirect with a success message
        wp_redirect( admin_url( 'admin.php?page=wmr_report' ) );
            exit;
        } else {
            wp_redirect(add_query_arg('update', 'failure', $_SERVER['REQUEST_URI']));
            exit;
        }
    
}

function my_custom_list_table_delete_item( $id ) {

    //   echo $id; die();

    $client_id = $id; // Replace this with the actual ID

    // Table names
    $client_table =  $this->wpdb->prefix . 'wmr_client';
    $client_site_report_table =  $this->wpdb->prefix . 'wmr_client_site_report';

    // Delete from the child table first
    $deleted_details =  $this->wpdb->delete(
    $client_site_report_table, // Table name
    array('client_id' => $client_id), // Where clause
    array('%d') // Data format (integer)
    );

    if ($deleted_details !== false) {
        // If deletion from the child table was successful, delete from the parent table
        $deleted_client = $this->wpdb->delete(
            $client_table, // Table name
            array('id' => $client_id), // Where clause
            array('%d') // Data format (integer)
    );
    
    } else {
        echo 'Error: Record could not be deleted from the client details table.';
    }

}

function my_custom_list_table_delete_all_item() {

  // Table names
  $client_table =  $this->wpdb->prefix . 'wmr_client';
  $client_site_report_table =  $this->wpdb->prefix . 'wmr_client_site_report';
  $client_ids_to_delete  = isset( $_REQUEST['element'] ) ? $_REQUEST['element'] : array();
 //echo"<pre>"; print_r($client_ids_to_delete);
  if (is_array($client_ids_to_delete)) {
    foreach ($client_ids_to_delete as $c_id) {
        // Sanitize and delete item
        $deleted_client_site_report_table =  $this->wpdb->delete($client_site_report_table, array('client_id' => $c_id), array('%d'));
    }
  }

  if ($deleted_client_site_report_table !== false) {

    if (is_array($client_ids_to_delete)) {
        foreach ($client_ids_to_delete as $id) {
            // Sanitize and delete item
            $deleted_client_table = $this->wpdb->delete($client_table, array('id' => $id), array('%d'));
        }
      }

} 
if ($deleted_client_table !== false) {
    // Redirect with a success message
wp_redirect( admin_url( 'admin.php?page=wmr_report' ) );
    exit;
} else {
    wp_redirect(add_query_arg('update', 'failure', $_SERVER['REQUEST_URI']));
    exit;
}
    
}


function create_client_record() {
    
    include_once( plugin_dir_path( __FILE__ ) . '/partials/wmr-client-add.php' );

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_client'])) {

        $client_name  = sanitize_text_field( $_POST['client_name'] );
        $client_email = sanitize_email( $_POST['client_email'] );
        $client_website = esc_url_raw( $_POST['client_website'] );
        $maintenance_date = sanitize_text_field( $_POST['maintenance_date'] );
        $currentTime = date('H:i:s');
        $wordpress = isset($_POST['wordpress']) ? sanitize_key($_POST['wordpress']) : 'false';
        $plugins = isset($_POST['plugins']) ? sanitize_key($_POST['plugins']) : 'false';
        $themes = isset($_POST['themes']) ? sanitize_key($_POST['themes']) : 'false';
        $php_upgrade = isset($_POST['php_upgrade']) ? sanitize_key($_POST['php_upgrade']) : 'false';
        $notes = sanitize_textarea_field( $_POST['notes'] );
        
        $client_table =  $this->wpdb->prefix . 'wmr_client';
        $client_site_report_table =  $this->wpdb->prefix . 'wmr_client_site_report';
        
        $this->wpdb->insert(
            $client_table,
            array(
                'client_name' => $client_name,
                'client_email' => $client_email,
                'client_website' => $client_website
            )
        );

        // Get the customer ID
        $client_id =  $this->wpdb->insert_id;

        if ($client_id) {
            // Insert data into the orders table
            $this->wpdb->insert(
                $client_site_report_table,
                array(
                    'client_id' => $client_id,
                    'maintenance_date' => $maintenance_date .  ' ' . $currentTime,
                    'wordpress' => $wordpress,
                    'plugins' => $plugins,
                    'themes' => $themes,
                    'php_upgrade' => $php_upgrade,
                    'notes' => $notes,
                    'status' => 'published',
                )
            );
        echo '<p>Form submitted successfully!</p>';
        $to = $client_email; // Replace with your email
        $subject = 'Website Maintenance Summary - ' . $maintenance_date;
        $body = "Name: $client_name\nEmail: $client_email\nMessage: $notes";
        $headers = ['Content-Type: text/plain; charset=UTF-8'];
        wp_mail($to, $subject, $body, $headers);    
         }
         else {
            echo '<p>There was an error submitting the form.</p>';
        }

        
        
    }

}
public function client_record_view($id){
    $client_table =  $this->wpdb->prefix . 'wmr_client';
    $client_site_report_table =  $this->wpdb->prefix . 'wmr_client_site_report';
    $data =  $this->wpdb->get_row(
         "SELECT * FROM {$client_table} INNER JOIN {$client_site_report_table} ON {$client_table}.id=$client_site_report_table.client_id 
         WHERE {$client_table}.id=$id ");
       //  var_dump($data); wp_die();
    include_once( plugin_dir_path( __FILE__ ) . '/partials/wmr-client-single-view.php' );
}

}

?>