<?php
/**
 * Class FME_Elementor_Page
 */
if ( ! defined( 'ABSPATH' ) ){
    exit;
} 

class FME_Elementor_Page {

    protected $plugin_name;

    protected $version;


    public function __construct() {

        $this->plugin_name = 'form-masks-for-elementor';

        $this->version = FME_VERSION;

        $this->load_dependencies();

    }


    private function load_dependencies() {

        if (!is_plugin_active( 'conditional-fields-for-elementor-form/class-conditional-fields-for-elementor-form.php' )) {

        require_once FME_PLUGIN_PATH . 'admin/class-cfef-admin.php';
        $plugin_admin = CFEF_Admin::get_instance($this->get_plugin_name(), $this->get_version());

        }

    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_version() {
        return $this->version;
    }
}