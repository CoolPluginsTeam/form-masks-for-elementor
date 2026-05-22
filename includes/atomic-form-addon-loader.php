<?php

namespace FME\Includes;
use FME\Includes\AtomicForm\Input\Input;
use Elementor\Widgets_Manager;

class Atomic_Form_Addon_Loader {


    private static $instance = null;

    protected $version;

    protected $error_map;

    public static function get_instance() {
        if (null == self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {

        if ( ! $this->are_atomic_form_experiments_active() ) {
            return;
        }

        $this->version = FME_VERSION;
        add_filter('elementor/widgets/register', [$this, 'register_widgets'], 999);
        add_action('elementor/frontend/before_enqueue_scripts', [$this, 'enqueue_frontend_scripts']);
    }

    /**
     * Core Atomic Widgets (`e_atomic_elements`) plus Pro Atomic Form (`e_pro_atomic_form`) must both be active.
     *
     * @see \Elementor\Modules\AtomicWidgets\Module::EXPERIMENT_NAME
     */
    private function are_atomic_form_experiments_active(): bool {
        $experiments = Elementor_Plugin::$instance->experiments ?? null;
        if ( ! $experiments || ! method_exists( $experiments, 'is_feature_active' ) ) {
            return false;
        }

        return $experiments->is_feature_active( 'e_atomic_elements' )
            && $experiments->is_feature_active( 'e_pro_atomic_form' );
    }

    private function is_field_enabled($field_key) {
        $enabled_elements = get_option('cfkef_enabled_elements', array());
        return in_array(sanitize_key($field_key), array_map('sanitize_key', $enabled_elements));
    }

    public function register_widgets( Widgets_Manager $widgets_manager ) {

        if ( ! $this->are_atomic_form_experiments_active() ) {
            return;
        }

        if($this->is_field_enabled('form_input_mask')){

            $widgets_manager->unregister('e-form-input');
    
            require_once FME_PLUGIN_PATH . 'includes/atomic-form/input/input.php';
            $widgets_manager->register( new Input() );
        }

    }

    /**
     * Mask scripts are normally registered by FME_Plugin when "form input mask" is enabled.
     * Atomic form masks still need them, so register here if missing.
     */
    private function ensure_fme_mask_assets_registered() {
        if ( ! wp_script_is( 'fme-custom-mask-script', 'registered' ) ) {
            wp_register_script( 'fme-custom-mask-script', FME_PLUGIN_URL . 'assets/js/inputmask/custom-mask-script.js', array( 'jquery' ), $this->version, true );

            $error_messages = array(
                'mask-cnpj'  => __( 'Invalid CNPJ.', 'extensions-for-elementor-form' ),
                'mask-cpf'   => __( 'Invalid CPF.', 'extensions-for-elementor-form' ),
                'mask-cep'   => __( 'Invalid CEP (XXXXX-XXX).', 'extensions-for-elementor-form' ),
                'mask-phus'  => __( 'Invalid number: (123) 456-7890', 'extensions-for-elementor-form' ),
                'mask-ph8'   => __( 'Invalid number: 1234-5678', 'extensions-for-elementor-form' ),
                'mask-ddd8'  => __( 'Invalid number: (DDD) 1234-5678', 'extensions-for-elementor-form' ),
                'mask-ddd9'  => __( 'Invalid number: (DDD) 91234-5678', 'extensions-for-elementor-form' ),
                'mask-dmy'   => __( 'Invalid date: dd/mm/yyyy', 'extensions-for-elementor-form' ),
                'mask-mdy'   => __( 'Invalid date: mm/dd/yyyy', 'extensions-for-elementor-form' ),
                'mask-hms'   => __( 'Invalid time: hh:mm:ss', 'extensions-for-elementor-form' ),
                'mask-hm'    => __( 'Invalid time: hh:mm', 'extensions-for-elementor-form' ),
                'mask-dmyhm' => __( 'Invalid date: dd/mm/yyyy hh:mm', 'extensions-for-elementor-form' ),
                'mask-mdyhm' => __( 'Invalid date: mm/dd/yyyy hh:mm', 'extensions-for-elementor-form' ),
                'mask-my'    => __( 'Invalid date: mm/yyyy', 'extensions-for-elementor-form' ),
                'mask-ccs'   => __( 'Invalid credit card number.', 'extensions-for-elementor-form' ),
                'mask-cch'   => __( 'Invalid credit card number.', 'extensions-for-elementor-form' ),
                'mask-ccmy'  => __( 'Invalid date.', 'extensions-for-elementor-form' ),
                'mask-ccmyy' => __( 'Invalid date.', 'extensions-for-elementor-form' ),
                'mask-ipv4'  => __( 'Invalid IPv4 address.', 'extensions-for-elementor-form' ),
            );

            wp_localize_script(
                'fme-custom-mask-script',
                'fmeData',
                array(
                    'pluginUrl'     => FME_PLUGIN_URL,
                    'errorMessages' => $error_messages,
                )
            );
        }

        wp_register_script(
            'cfl-atomic-form-mask-init',
            FME_PLUGIN_URL . 'assets/atomic-form/js/atomic-form-mask-init.js',
            array( 'jquery', 'elementor-frontend', 'fme-custom-mask-script' ),
            $this->version,
            true
        );

        if ( ! wp_style_is( 'fme-frontend-css', 'registered' ) ) {
            wp_register_style( 'fme-frontend-css', FME_PLUGIN_URL . 'assets/css/inputmask/mask-frontend.css', array(), $this->version, 'all' );
        }

        if ( ! wp_style_is( 'atomic-form-mask-style', 'registered' ) ) {
            wp_register_style( 'atomic-form-mask-style', FME_PLUGIN_URL . 'assets/atomic-form/css/atomic-form-mask-style.min.css', array(), $this->version, 'all' );
        }

        if (! wp_script_is('fme-custom-mask-script', 'enqueued') && ! wp_script_is('fme-custom-mask-script', 'done')) {
            wp_enqueue_script( 'fme-custom-mask-script' );
        }

        if (! wp_script_is('cfl-atomic-form-mask-init', 'enqueued') && ! wp_script_is('cfl-atomic-form-mask-init', 'done')) {
            wp_enqueue_script( 'cfl-atomic-form-mask-init' );
        }
        if (! wp_style_is('fme-frontend-css', 'enqueued') && ! wp_style_is('fme-frontend-css', 'done')) {
            wp_enqueue_style( 'fme-frontend-css' );
        }
        if (! wp_style_is('atomic-form-mask-style', 'enqueued') && ! wp_style_is('atomic-form-mask-style', 'done')) {
            wp_enqueue_style( 'atomic-form-mask-style' );
        }
    }


    public function enqueue_frontend_scripts() {

        if ( ! $this->are_atomic_form_experiments_active() ) {
            return;
        }
        
        if($this->is_field_enabled('form_input_mask')){
            $this->ensure_fme_mask_assets_registered();
        }
    }

    public function get_version() {
        return $this->version;
    }
}
