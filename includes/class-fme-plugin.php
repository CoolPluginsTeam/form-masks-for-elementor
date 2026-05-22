<?php
//phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedNamespaceFound	
namespace FME\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Form Mask Elementor Class
 *
 * Class to initialize the plugin.
 *
 * @since 1.4
 */
final class FME_Plugin {
	/**
	 * Instance
	 *
	 * @since 1.4
	 *
	 * @access private
	 * @static
	 *
	 * @var FME_Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.4
	 *
	 * @access public
	 * @static
	 *
	 * @return FME_Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * Constructor
	 *
	 * Private method for prevent instance outsite the class.
	 *
	 * @since 1.4
	 *
	 * @access private
	 */
	private function __construct() {
		add_action('wp_enqueue_scripts', array($this,'my_enqueue_scripts'));
		add_action( 'elementor/frontend/after_enqueue_scripts', array( $this, 'frontend_assets' ) ,999);
		add_action( 'elementor/preview/init', array( $this, 'editor_inline_JS'));
		add_action( 'init', array( $this, 'init' ), -10 );
		add_action( 'wp_ajax_fme_elementor_review_notice', array( $this, 'fme_elementor_review_notice' ) );

	}

	public function my_enqueue_scripts(){
		wp_register_script( 'fme-custom-mask-script', FME_PLUGIN_URL . 'assets/js/custom-mask-script.js', array('jquery'), FME_VERSION, true );

		wp_register_style( 'fme-frontend-css', FME_PLUGIN_URL . 'assets/css/mask-frontend.css', FME_VERSION, true );

		wp_register_script( 'fme-new-input-mask', FME_PLUGIN_URL . 'assets/js/new-input-mask.js', array('elementor-frontend','jquery'), FME_VERSION, true );
	}

	public function frontend_assets(){	
		$error_messages = [
			'mask-cnpj'   => __("Invalid CNPJ.", "form-masks-for-elementor"),
			'mask-cpf'    => __("Invalid CPF.", "form-masks-for-elementor"),
			'mask-cep'    => __("Invalid CEP (XXXXX-XXX).", "form-masks-for-elementor"),
			'mask-phus'   => __("Invalid number: (123) 456-7890", "form-masks-for-elementor"),
			'mask-ph8'    => __("Invalid number: 1234-5678", "form-masks-for-elementor"),
			'mask-ddd8'   => __("Invalid number: (DDD) 1234-5678", "form-masks-for-elementor"),
			'mask-ddd9'   => __("Invalid number: (DDD) 91234-5678", "form-masks-for-elementor"),
			'mask-dmy'    => __("Invalid date: dd/mm/yyyy", "form-masks-for-elementor"),
			'mask-mdy'    => __("Invalid date: mm/dd/yyyy", "form-masks-for-elementor"),
			'mask-hms'    => __("Invalid time: hh:mm:ss", "form-masks-for-elementor"),
			'mask-hm'     => __("Invalid time: hh:mm", "form-masks-for-elementor"),
			'mask-dmyhm'  => __("Invalid date: dd/mm/yyyy hh:mm", "form-masks-for-elementor"),
			'mask-mdyhm'  => __("Invalid date: mm/dd/yyyy hh:mm", "form-masks-for-elementor"),
			'mask-my'     => __("Invalid date: mm/yyyy", "form-masks-for-elementor"),
			'mask-ccs'    => __("Invalid credit card number.", "form-masks-for-elementor"),
			'mask-cch'    => __("Invalid credit card number.", "form-masks-for-elementor"),
			'mask-ccmy'   => __("Invalid date.", "form-masks-for-elementor"),
			'mask-ccmyy'  => __("Invalid date.", "form-masks-for-elementor"),
			'mask-ipv4'   => __("Invalid IPv4 address.", "form-masks-for-elementor")
		];

		wp_enqueue_script( 'fme-custom-mask-script' );
		wp_enqueue_script( 'fme-new-input-mask' );
		wp_enqueue_style( 'fme-frontend-css' );

		wp_localize_script( 'fme-custom-mask-script', 'fmeData', array(
			'pluginUrl' => FME_PLUGIN_URL, 
			'errorMessages' => $error_messages 
		) );		
	}

	public function editor_inline_JS() {
		wp_enqueue_script( 'fme-editor-template-js', FME_PLUGIN_URL . 'assets/js/mask-editor-template.js', array(), FME_VERSION, true );
	}
	/**
	 * Initialize the plugin
	 *
	 * Load the plugin and all classes after Elementor and all plugins is loaded.
	 *
	 * @since 1.4
	 *
	 * @access public
	 */
	public function init() {
		require_once FME_PLUGIN_PATH . '/includes/class-elementor-mask-control.php';
		new FME_Elementor_Forms_Mask();

		// add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_plugin_js' ] );
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'register_editor_scripts') );
	}

	/**
	 * Enqueue JS
	 *
	 * Register and enqueue JS scripts.
	 *
	 * @since 1.4
	 *
	 * @access public
	 */
	public function enqueue_plugin_js() {
		//phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		do_action( 'fme_after_enqueue_scripts' );
	}

	/**
	 * Enqueue script on Elemento Editor
	 *
	 * @return void
	 */
	public function register_editor_scripts() {
		wp_register_style( 'fme-input-mask-editor', FME_PLUGIN_URL . 'assets/css/mask-editor.css', array(), FME_VERSION );
		wp_enqueue_style( 'fme-input-mask-editor' );

		wp_register_script( 'fme-input-mask-editor', FME_PLUGIN_URL . 'assets/js/mask-editor.js', array( 'jquery' ), FME_VERSION, true );
		wp_enqueue_script( 'fme-input-mask-editor' );
	}

	public function fme_elementor_review_notice() {
		if ( ! check_ajax_referer( 'cfef_elementor_review', 'nonce', false ) ) {
			wp_send_json_error( __( 'Invalid security token sent.', 'form-masks-for-elementor' ) );
			wp_die( '0', 400 );
		}

		if ( isset( $_POST['cfef_notice_dismiss'] ) && 'true' === sanitize_text_field(wp_unslash($_POST['cfef_notice_dismiss'])) ) {
			update_option( 'fme_elementor_notice_dismiss', 'yes' );
		}
		exit;
	}
}
