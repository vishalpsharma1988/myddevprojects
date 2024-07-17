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

 if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class Wmr_Client_Display extends WP_List_Table{

	 // define $table_data property

     private $table_data;
    

     // Render data from the database to prepare the item
 
     private function get_table_data( $search = '' ) {
         global $wpdb;
 
         $client_table = $wpdb->prefix . 'wmr_client';
         $client_site_report_table = $wpdb->prefix . 'wmr_client_site_report';
 
             if ( !empty($search) ) {
             return $wpdb->get_results(
             "SELECT * FROM {$client_table} INNER JOIN {$client_site_report_table} ON {$client_table}.id=$client_site_report_table.client_id WHERE client_name Like '%{$search}%' OR client_email Like '%{$search}%'", ARRAY_A
             );
             }
             else if( isset( $_REQUEST['status'] ) && $_REQUEST['status'] === 'published' ){
                $status =  $_REQUEST['status'];
                return $wpdb->get_results(
 
                    "SELECT * FROM {$client_table} INNER JOIN {$client_site_report_table} ON {$client_table}.id=$client_site_report_table.client_id WHERE $client_site_report_table.status Like 'published'", ARRAY_A
                );
               } 
            else if( isset( $_REQUEST['status'] ) && $_REQUEST['status'] === 'draft' ){
                    $status =  $_REQUEST['status'];
                    return $wpdb->get_results(
     
                        "SELECT * FROM {$client_table} INNER JOIN {$client_site_report_table} ON {$client_table}.id=$client_site_report_table.client_id WHERE $client_site_report_table.status Like 'draft'", ARRAY_A
                    );
                    } 
             else {
             return $wpdb->get_results(
 
             "SELECT * FROM {$client_table} INNER JOIN {$client_site_report_table} ON {$client_table}.id=$client_site_report_table.client_id", ARRAY_A
             );
         }
     }
 
     // Generate Table Columns
 
     function get_columns() {
         $columns = array(
                        'cb'            => '<input type="checkbox" />',
                        'client_name'          => __('Client Name', 'client_editable'),
                        'client_email'          => __('Client Email', 'client_editable'),
                        'client_website'       => __('Website', 'client_editable'),
                        'maintenance_date'    => __('Maintenance Date', 'client_editable'),
                        'wordpress'    => __('Core Update', 'client_editable'),
                        'plugins'    => __('Plugins', 'client_editable'),
                        'themes'       => __('Themes', 'client_editable'),
                        'php_upgrade'    => __('PHP Upgrade', 'client_editable'),
                        'notes'    => __('Notes', 'client_editable'),
                        'status'    => __('Status', 'client_editable'),
                         );
         return $columns;
     }
 
     // Assembling the stuff like columns, data etc.
     
     function prepare_items() {
         
         if ( isset($_POST['s']) ) {
         $this->table_data = $this->get_table_data($_POST['s']);
         } else {
         $this->table_data = $this->get_table_data();
         }
        
         $columns = $this->get_columns();
         $hidden = ( is_array(get_user_meta( get_current_user_id(), 'managetoplevel_page_wmr_reportcolumnshidden', true)) ) ? get_user_meta( get_current_user_id(), 'managetoplevel_page_wmr_reportcolumnshidden', true) : array();
     
         $sortable = $this->get_sortable_columns();
         $primary  = 'client_name';
         $this->_column_headers = array($columns, $hidden, $sortable, $primary);
 
         usort($this->table_data, array(&$this, 'usort_reorder'));
         //Pagination
         $per_page = $this->get_items_per_page('elements_per_page', 10);
         $current_page = $this->get_pagenum();
         $total_items = count($this->table_data);
 
         $this->table_data = array_slice($this->table_data, (($current_page - 1) * $per_page), $per_page);
 
         $this->set_pagination_args(array(
             'total_items' => $total_items, // total number of items
             'per_page'    => $per_page, // items to show on a page
             'total_pages' => ceil( $total_items / $per_page ) // use ceil to round up
         ));
 
         $this->items = $this->table_data;
     }
     
   
     // adding value to the columns
 
     function column_default($item, $column_name) {
         switch ($column_name) {
             case 'id':
             case 'client_name':
             case 'client_email':
             case 'client_website':
             case 'maintenance_date':
             case 'wordpress':
             case 'plugins':
             case 'themes':
             case 'php_upgrade':
             case 'notes':
             case 'status':
             default:
                 return $item[$column_name];
         }
     }
 
     // Add a checkbox to the first column
 
     function column_cb($item) {
         return sprintf(
                 '<input type="checkbox" name="element[]" value="%s" />',
                 $item['client_id']
         );
     }
 
     // Define the columns for sorting
 
     protected function get_sortable_columns()
     {
         $sortable_columns = array(
             'client_name'  => array('client_name', false),
             'client_email' => array('client_email', false)
         );
         return $sortable_columns;
     }
 
     // function for sorting
 
     function usort_reorder($a, $b)
     {
         // For no sorting, default to name
         $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'client_name';
 
         // for no ordering, default to asc
         $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';
 
         // sort ordering
         $result = strcmp($a[$orderby], $b[$orderby]);
 
         // Send final sort direction to usort
         return ($order === 'asc') ? $result : -$result;
     }
 
     // Add action links to the items
 
     function column_client_name($item)
     {
         $actions = array(
                 'edit'      => sprintf('<a href="?page=%s&action=%s&element=%s">' . __('Edit', 'client_editable') . '</a>', $_REQUEST['page'], 'edit', $item['client_id']),
                 'delete'    => sprintf('<a href="?page=%s&action=%s&element=%s">' . __('Delete', 'client_editable') . '</a>', $_REQUEST['page'], 'delete', $item['client_id']),
                 'view'    => sprintf('<a href="?page=%s&action=%s&element=%s">' . __('View', 'client_editable') . '</a>', $_REQUEST['page'], 'view', $item['client_id']),
         );
 
         return sprintf('%1$s %2$s', $item['client_name'], $this->row_actions($actions));
     }
     public function extra_tablenav( $which ) {
        if ( 'top' === $which ) {
            // Display status filter links
            $current_status = isset( $_GET['status'] ) ? $_GET['status'] : 'all';
            $statuses = array(
                'all'       => 'All',
                'published' => 'Published',
                'draft'     => 'Draft',
                // Add more statuses as needed
            );
         ?>   
            <div class="alignleft actions">
            <?php foreach ( $statuses as $key => $label ) :
                $url = remove_query_arg( 'status' );
                if ( $key !== 'all' ) {
                    $url = add_query_arg( 'status', $key, $url );
                }
                ?>
                  <a href="<?php echo esc_url( $url ); ?>" class="<?php echo $key === $current_status ? 'current' : ''; ?>"><?php echo esc_html( $label ); ?></a> |
                  <?php endforeach; ?>
      
            </div>
            <?php
        }
    }
     // To show bulk action dropdown
     function get_bulk_actions()
     {
             $actions = array(
                     'delete_all'    => __('Delete', 'client_editable'),
                     'draft_all' => __('Move to Draft', 'client_editable')
             );
             return $actions;
     }

   

}
