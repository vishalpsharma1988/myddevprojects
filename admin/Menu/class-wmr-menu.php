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

 if(!class_exists('Wmr_Data_Query')){
    require_once( plugin_dir_path( __FILE__ ) . '../class-wmr-data-query.php' );
    include_once( plugin_dir_path( __FILE__ ) . '../class-wmr-client-display.php' );
    }
class Wmr_Menu{

	public function add_menu_callback(){
        global $client_report_screen_page;

        $client_report_screen_page = add_menu_page(
			__('WMR Report', 'wmr'),
			__('WMR Report', 'wmr'),
			'manage_options',
			'wmr_report',
			array($this,'wmr_client_data_callback'),
			'dashicons-id',
		);

	    add_submenu_page(
	        'wmr_report',
	        __('Add Client', 'wmr'),
	        __('Add Client', 'wmr'),
	        'manage_options',
	        'wmr-add-record',
	        array($this,'wmr_client_addition_callback'),
	    );

        add_submenu_page(
	        'wmr_report',
	        __('Settings', 'wmr'),
	        __('settings', 'wmr'),
	        'manage_options',
	        'wmr-settings',
	        array($this,'wmr_client_email_callback'),
	    );

        add_action("load-$client_report_screen_page", "client_page_screen_options");
        
    }

 
    public function wmr_client_data_callback(){
    
if ( isset( $_GET['action'] ) && isset( $_GET['element'] ) ) {
    $action = $_GET['action'];
    $id = intval( $_GET['element'] );

    if ( $action == 'edit' ) {
        $this->my_custom_list_table_edit( $id );
    } elseif ( $action == 'delete' ) {
        // Handle the delete action
        $this->my_custom_list_table_delete( $id );
    } 
    elseif( $action == 'view' ) {
        // Handle the delete action
        $this->my_custom_list_table_view( $id );
    } 
} 
else{
    
$myListTable = new Wmr_Client_Display();
$myListTable->prepare_items();

?>
<div class="wrap">
    <h2>All CLient Records</h2>
    <form method="post">
        <input type="hidden" name="page" value="wmr_report">
        <?php
        
        $myListTable->display();
        ?>
    </form>
</div>
<?php

}
if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] === 'delete_all' ) {
    $this->my_custom_list_table_delete_all();
}
    
}

function my_custom_list_table_edit( $id ) {

    $get_item = New Wmr_Data_Query();
    $get_item->my_custom_list_table_get_item( $id );  

    }

function my_custom_list_table_delete( $id ) {

        $delete_item = New Wmr_Data_Query();
        $delete_item->my_custom_list_table_delete_item( $id ); 
	
		// Redirect to the list table page
		wp_redirect( admin_url( 'admin.php?page=wmr_report' ) );
		exit;
	}
	
    public function wmr_client_addition_callback(){
        
        $add_client = New Wmr_Data_Query();
        $add_client->create_client_record();  
    }

    public function wmr_client_email_callback(){
        
    }

    public function my_custom_list_table_delete_all(){
        $delete_all_client = New Wmr_Data_Query();
        $delete_all_client->my_custom_list_table_delete_all_item(); 

    }
    public function my_custom_list_table_view($id){
        $view_client = New Wmr_Data_Query();
        $view_client->client_record_view($id); 

    }

}

// add screen options
function client_page_screen_options() {

    global $client_report_screen_page;
    global $table;

    $screen = get_current_screen();
    if($_post['screen-options-apply']){
        echo "hi"; die();
    }
    // $per_page = $get_items_per_page('elements_per_page', 10);
   // echo $per_page; die();
   
    if(!is_object($screen) || $screen->id != $client_report_screen_page)
        return;

        $args = array(
            'label' => __('Elements per page', 'supporthost-admin-table'),
            'default' => 2,
            'option' => 'elements_per_page'
        );
        add_screen_option( 'per_page', $args );

        // if ($per_page === 'items_per_page') {
        //     $user_id = get_current_user_id();
        //     update_user_meta($user_id, 'my_custom_table_items_per_page', intval($value));
        // }

        $table = new Wmr_Client_Display();


}






