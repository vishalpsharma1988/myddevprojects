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
class Wmr_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->load_required_files();

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wmr_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wmr_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wmr-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wmr_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wmr_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wmr-admin.js', array( 'jquery' ), $this->version, false );

	}

	 /**
     * Load required files
     *
     * @since    1.0.0
     */
    public function load_required_files()
    {
        self::include_all_php_files(plugin_dir_path(__FILE__) . "Menu");
    }

    public static function include_all_php_files($dir) {
        // TODO: load_required_files() function call this function. So now include all files of those folder and sub folder.
        // In Menu and Page folder should contain folder, subfodler and files.
        foreach ( glob( plugin_dir_path( __FILE__ ) . "Menu/*.php" ) as $file ) {
            include_once $file;
        }
        
    }

    /**
     * Register the admin menu for the admin area.
     *
     * @since    1.0.0
     */
    public function register_menus()
    {
        $wmr_menu = new Wmr_Menu();
        $wmr_menu->add_menu_callback();
    }

	  // add screen options
    public function client_screen_options() {
    echo "hi"; die();
 
	global $client_report_screen_page;
        global $table;
 
	$screen = get_current_screen();
 
	// get out of here if we are not on our settings page
	if(!is_object($screen) || $screen->id != $client_report_screen_page)
		return;
 
	$args = array(
		'label' => __('Elements per page', 'supporthost-admin-table'),
		'default' => 2,
		'option' => 'elements_per_page'
	);
	add_screen_option( 'per_page', $args );

    $table = new Wmr_Client_Display();

}

}
