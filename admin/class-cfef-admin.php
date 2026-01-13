<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://coolplugins.net
 * @since      1.0.0
 *
 * @package    Cool_FormKit
 * @subpackage Cool_FormKit/admin
 */



if (!defined('ABSPATH')) {
    die;
}

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 * @package    Cool_FormKit
 * @subpackage Cool_FormKit/admin
 */
if(!class_exists('CFEF_Admin')) {
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound
class CFEF_Admin {

    /**
     * The instance of this class.
     *
     * @since    1.0.0
     * @access   private
     * @var      CFEF_Admin    $instance    The instance of this class.
     */
    private static $instance = null;

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
     * Constructor to initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $plugin_name       The name of this plugin.
     * @param    string    $version    The version of this plugin.
     */
    private function __construct($plugin_name, $version) {


        $this->plugin_name = $plugin_name;
        $this->version = $version;
        add_action('admin_menu', array($this, 'add_plugin_admin_menu'),999);
        add_action('admin_init', array($this, 'register_form_elements_settings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));

        add_action( 'wp_ajax_cfkef_plugin_install', 'wp_ajax_install_plugin' );
        add_action( 'wp_ajax_cfkef_plugin_activate', array($this,'cfkef_plugin_activate') );

        
    }
    /**
     * Get the instance of this class.
     *
     * @since    1.0.0
     * @param    string    $plugin_name       The name of this plugin.
     * @param    string    $version    The version of this plugin.
     * @return   CFEF_Admin    The instance of this class.
     */
    public static function get_instance($plugin_name, $version) {
        if (null == self::$instance) {
            self::$instance = new self($plugin_name, $version);
        }
        return self::$instance;
    }


    public function cfkef_plugin_activate(){
        check_ajax_referer( 'cfkef_plugin_nonce', 'security' );
        if ( ! current_user_can( 'activate_plugins' ) ) {
            wp_send_json_error( [ 'message' => 'Permission denied' ] );
        }

        if ( empty( $_POST['init'] ) ) {
            wp_send_json_error( [ 'message' => 'Plugin init file missing' ] );
        }

        include_once ABSPATH . 'wp-admin/includes/plugin.php';

        $init_file = sanitize_text_field( wp_unslash($_POST['init']));

        $activate = activate_plugin( $init_file );

        if ( is_wp_error( $activate ) ) {
            wp_send_json_error( [ 'message' => $activate->get_error_message() ] );
        }

        wp_send_json_success( [ 'message' => 'Plugin activated successfully' ] );
    } 

    /**
     * Add a menu item under Settings.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu() {
        add_submenu_page(
            'elementor',
            __('Cool FormKit', 'form-masks-for-elementor'),
            __('Cool FormKit', 'form-masks-for-elementor'),
            'manage_options',
            'cool-formkit',
            array($this, 'display_plugin_admin_page')
        );
    }
    /**
     * Display the plugin admin page with tabs.
     *
     * @since    1.0.0
     */
    public function display_plugin_admin_page() {


        $form_mask_installed_date = get_option( 'fme-installDate' );
        $conditional_fields_installed_date = get_option( 'cfef-installDate' );
        $conditional_fields_pro_installed_date = get_option( 'cfefp-installDate' );
        $country_code_installed_date = get_option( 'ccfef-installDate' );

        $plugins_dates = [
            'fim_plugin'  => $form_mask_installed_date,
            'cfef_plugin' => $conditional_fields_installed_date,
            'cfefp_plugin' => $conditional_fields_pro_installed_date,
            'ccfef_plugin' => $country_code_installed_date,
        ];

        $plugins_dates = array_filter($plugins_dates);

        if (!empty($plugins_dates)) {
            asort($plugins_dates);
            $first_plugin = key($plugins_dates);
        } else {
            $first_plugin = 'fim_plugin';
        }

        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $tab = isset($_GET['tab']) ? sanitize_text_field((wp_unslash($_GET['tab']))) : 'form-elements';
        ?>
        <div class="cfkef-wrapper">
            <div class="cfk-header">
                <div class="cfk-header-logo">
                    <a href="?page=cool-formkit">
                        <img src="<?php echo esc_url(FME_PLUGIN_URL . 'assets/images/logo-cool-formkit.png'); ?>" alt="Cool FormKit Logo">
                    </a>

                    <span>Lite</span>
                    <a class="button button-primary upgrade-pro-btn" target="_blank" href="https://coolformkit.com/pricing/?utm_source=<?php echo esc_attr($first_plugin); ?>&utm_medium=inside&utm_campaign=get_pro&utm_content=dashboard">
                        <img class="crown-diamond-pro" src="<?php echo esc_url(FME_PLUGIN_URL . 'assets/images/crown-diamond-pro.png'); ?>" alt="Cool FormKit Logo">
                        <?php esc_html_e('Upgrade To Pro', 'form-masks-for-elementor'); ?>
                    </a>
                </div>
                <div class="cfk-buttons">
                    <p>Advanced Elementor Form Builder.</p>
                    <a href="https://coolformkit.com/pricing/?utm_source=<?php echo esc_attr($first_plugin); ?>&utm_medium=inside&utm_campaign=get_pro&utm_content=setting_page_header" class="button" target="_blank">Get Cool FormKit</a>
                </div>
            </div>
            <h2 class="nav-tab-wrapper">
                <a href="?page=cool-formkit&tab=form-elements" class="nav-tab <?php echo esc_attr($tab) == 'form-elements' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Form Elements', 'form-masks-for-elementor'); ?></a>
                <a href="?page=cool-formkit&tab=settings" class="nav-tab <?php echo esc_attr($tab) == 'settings' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Settings', 'form-masks-for-elementor'); ?></a>
                <a href="?page=cool-formkit&tab=license" class="nav-tab <?php echo esc_attr($tab) == 'license' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('License', 'form-masks-for-elementor'); ?></a>
            </h2>
            <div class="tab-content">
                <?php
                switch ($tab) {
                    case 'form-elements':
                        include_once 'views/form-elements.php';
                        break;
                    case 'settings':
                        include_once 'views/settings.php';
                        break;
                    case 'license':
                        include_once 'views/license.php';
                        break;
                }
                ?>
            </div>
        </div>
        <?php
    }

    public function add_to_cfkef_enabled_elements( $new_items ) {
        $current = get_option( 'cfkef_enabled_elements', [] );
        $merged  = array_unique( array_merge( $current, (array) $new_items ) );
        update_option( 'cfkef_enabled_elements', $merged );
    }

    /**
     * Register the settings for form elements.
     *
     * @since    1.0.0
     */
    public function register_form_elements_settings() {
        register_setting('cfkef_form_elements_group', 'cfkef_enabled_elements', array(
            'type' => 'array',
            'description' => 'Enabled Form Elements',
            'sanitize_callback' => array($this, 'sanitize_form_elements'),
            'default' => array()
        ));
        // phpcs:ignore PluginCheck.CodeAnalysis.SettingSanitization.register_settingMissing
        register_setting( 'cfkef_form_elements_group', 'cfkef_toggle_all' );
        // phpcs:ignore PluginCheck.CodeAnalysis.SettingSanitization.register_settingMissing
        register_setting( 'cfkef_form_elements_group', 'country_code' );
        // phpcs:ignore PluginCheck.CodeAnalysis.SettingSanitization.register_settingMissing
        register_setting( 'cfkef_form_elements_group', 'conditional_logic' );
        // phpcs:ignore PluginCheck.CodeAnalysis.SettingSanitization.register_settingMissing
        register_setting( 'cfkef_form_elements_group', 'form_input_mask' );
        // phpcs:ignore PluginCheck.CodeAnalysis.SettingSanitization.register_settingMissing
        register_setting( 'cfkef_form_elements_group', 'input_mask' );



        // phpcs:ignore PluginCheck.CodeAnalysis.SettingSanitization.register_settingMissing
        register_setting( 'cfkef_form_elements_group', 'cfkef_enable_elementor_pro_form' );

        if ( ! get_option( 'ccfef_plugin_initialized' ) ) {

            $this->add_to_cfkef_enabled_elements( ['country_code'] );

            update_option( 'ccfef_plugin_initialized', true );

        } else {

            if ( ! get_option( 'ccfef_migrate_done' ) ) {

                $val = get_option( 'country_code', null );

                if ( ! is_null( $val ) && $val ) {
                    // Option exists AND is true
                    $this->add_to_cfkef_enabled_elements( ['country_code'] );
                }

                update_option( 'ccfef_migrate_done', true );
            }
        }


        /**
         * 2. FME initialization / migration
         */
        if ( ! get_option( 'fme_plugin_initialized' ) ) {

            $this->add_to_cfkef_enabled_elements( ['form_input_mask'] );

            update_option( 'fme_plugin_initialized', true );

        } else {

            if ( ! get_option( 'fme_migrate_done' ) ) {

                $val = get_option( 'form_input_mask', null );

                if ( ! is_null( $val ) && $val ) {
                    // Option exists AND is true
                    $this->add_to_cfkef_enabled_elements( ['form_input_mask'] );
                }

                update_option( 'fme_migrate_done', true );
            }
        }


        /**
         * 3. MFE initialization / migration
         */
        if ( ! get_option( 'mfe_plugin_initialized' ) ) {

            $this->add_to_cfkef_enabled_elements( ['input_mask'] );

            update_option( 'mfe_plugin_initialized', true );

        } else {

            if ( ! get_option( 'mfe_migrate_done' ) ) {

                $val = get_option( 'input_mask', null );

                if ( ! is_null( $val ) && $val ) {
                    // Option exists AND is true
                    $this->add_to_cfkef_enabled_elements( ['input_mask'] );
                }

                update_option( 'mfe_migrate_done', true );
            }
        }
    }

    /**
     * Sanitize form elements input.
     *
     * @param array $input The input array.
     * @return array The sanitized array.
     */
    public function sanitize_form_elements($input) {
        $valid = array();

        $form_elements = array('conditional_logic', 'conditional_redirect', 'conditional_email', 'conditional_submit_button', 'range_slider', 'country_code', 'calculator_field', 'rating_field', 'signature_field', 'image_radio', 'radio_checkbox_styler', 'label_styler', 'select2','WYSIWYG','confirm_dialog','restrict_date','currency_field','month_week_field','form_input_mask', 'cloudflare_recaptcha', 'h_recaptcha','whatsapp_redirect');

        if (is_array($input)) {
            foreach ($input as $element) {
                if (in_array($element, $form_elements)) {
                    $valid[] = $element;
                }
            }
        } 
        return $valid;
    }

    /**
     * Enqueue admin styles and scripts.
     *
     * @since    1.0.0
     */
    public function enqueue_admin_styles() {

        wp_enqueue_style('cfkef-admin-global-style', FME_PLUGIN_URL . 'assets/css/global-admin-style.css', array(), $this->version, 'all');
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if (isset($_GET['page']) &&(strpos(sanitize_key(wp_unslash($_GET['page'])), 'cool-formkit') !== false || strpos(sanitize_key( wp_unslash($_GET['page'])), 'cfkef-entries') !== false)){
            wp_enqueue_style('cfkef-admin-style', FME_PLUGIN_URL . 'assets/css/admin-style.css', array(), $this->version, 'all');

            wp_enqueue_style('cfkef-temp-style', FME_PLUGIN_URL . 'assets/css/dashboard-style.css', array(), '1.0', 'all');

            wp_enqueue_style('dashicons');
            wp_enqueue_script('cfkef-admin-script', FME_PLUGIN_URL . 'assets/js/admin-script.js', array('jquery'), $this->version, true);
            
            wp_localize_script( 'cfkef-admin-script', 'cfkef_plugin_vars', [
                'nonce' => wp_create_nonce( 'cfkef_plugin_nonce' ),
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'installNonce' => wp_create_nonce( 'updates' ),
            ] );
        }
    }

}
}
