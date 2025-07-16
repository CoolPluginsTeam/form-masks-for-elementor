<?php
// Ensure the file is being accessed through the WordPress admin area
if (!defined('ABSPATH')) {
    die;
}

if (! function_exists('get_plugins')) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}


$enabled_elements = get_option('cfkef_enabled_elements', array());


$popular_elements = array('range_slider');
$updated_elements = array('country_code');


$plugin_list = get_plugins();

$form_mask_installed_date = get_option('fme-installDate');
$conditional_fields_installed_date = get_option('cfef-installDate');
$conditional_fields_pro_installed_date = get_option('cfefp-installDate');
$country_code_installed_date = get_option('ccfef-installDate');

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
    $first_plugin = 'cfef_plugin';
}

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'form-elements';



$form_elements = array(

    
    'whatsapp_redirect' => array(
        'label' => __('Whatsapp Redirect', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/whatsapp-redirection-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/whatsapp-icon-min.svg',
        'pro' => true
    ),
    
    'range_slider' => array(
        'label' => __('Range Slider', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/range-slider-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#range-field'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/range-slider-min.svg',
        'pro' => true
    ),
    'calculator_field' => array(
        'label' => __('Calculator Field', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/calculator-field-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#calculator-field'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/calculator-field-min.svg',
        'pro' => true
    ),
    'rating_field' => array(
        'label' => __('Rating Field', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/rating-field-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#rating-field'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/rating-field-min.svg',
        'pro' => true
    ),
    'signature_field' => array(
        'label' => __('Signature Field', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/signature-field-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#signature-field'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/signature.svg',
        'pro' => true
    ),
    'image_radio' => array(
        'label' => __('Image Radio', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/add-image-radio-field/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#image-radio-checkbox'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/image-radio-min.svg',
        'pro' => true
    ),
    'radio_checkbox_styler' => array(
        'label' => __('Radio & Checkbox Styler', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/style-radio-checkbox-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#button-radio-checkbox'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/radio-styler-min.svg',
        'pro' => true
    ),
    'label_styler' => array(
        'label' => __('Label Styler', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/label-styler-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#label-styler'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/label-style-min.svg',
        'pro' => true
    ),
    'select2' => array(
        'label' => __('Select2', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/select-field-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/select2-field-min.svg',
        'pro' => true
    ),
    'WYSIWYG' => array(
        'label' => __('WYSIWYG', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/add-wysiwyg-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/WYSIWYG-min.svg',
        'pro' => true
    ),
    'confirm_dialog' => array(
        'label' => __('Confirm Dialog Box', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/elementor-form-confirm-dialog-popup/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/dialog-box-min.svg',
        'pro' => true
    ),
    'restrict_date' => array(
        'label' => __('Restrict Date', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/restrict-date-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/restrict-date-min.svg',
        'pro' => true
    ),
    'currency_field' => array(
        'label' => __('Currency Field', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/add-currency-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/currency-field-min.svg',
        'pro' => true
    ),
    'month_week_field' => array(
        'label' => __('Month/Week Field', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/add-month-week/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/month-week-field-min.svg',
        'pro' => true
    ),
    'cloudflare_recaptcha' => array(
        'label' => __('Cloudflare Turnstile', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/add-cloudflare-turnstile-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/cloudflare-icon-min.svg',
        'pro' => true
    ),

    'h_recaptcha' => array(
        'label' => __('hCAPTCHA', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/add-hcaptcha-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/hcaptcha-icon-min.svg',
        'pro' => true
    ),
    'toggle_field' => array(
        'label' => __('Toggle Field', 'cool-formkit'),
        'how_to' => 'https://docs.coolplugins.net/doc/toggle-field-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard',
        'demo' => 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard',
        'icon' => FME_PLUGIN_URL . 'assets/icons/toggle-field.svg',
        'pro' => true
    )
);


$condition_plugin_features = array(
    'condtional_logic' => array(
        'label' => __('Conditional Logic', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/elementor-form-conditional-fields/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=docs&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://coolplugins.net/product/conditional-fields-for-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#view-demo-forms'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/conditional-logic-1-min.svg'
    ),

    'submit_condition' => array(
        'label' => __('Submit Conditions', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/product/conditional-fields-for-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=docs&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/elementor-form-submit-button-conditions/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#conditional-redirect'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/conditional-button-min.svg',
        'pro' => true
    ),


    'redirect_conditionaly' => array(
        'label' => __('Redirect Conditionaly', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/product/conditional-fields-for-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=docs&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/conditional-redirect-elementor-form-on-submit/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#conditional-redirect'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/redirect-conditionally-min.svg',
        'pro' => true
    ),


    'email_conditionaly' => array(
        'label' => __('Email Conditionaly', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/product/conditional-fields-for-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=docs&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/conditional-email-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#conditional-redirect'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/conditional-email-1-min.svg',
        'pro' => true

    ),


    'multicondtion_or_logic' => array(
        'label' => __('Multiple OR Conditions', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/product/conditional-fields-for-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=docs&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/plugin/conditional-fields-for-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#conditional-redirect'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/or-condition.svg',
        'pro' => true

    ),


    'more_operators' => array(
        'label' => __('More Operators', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/product/conditional-fields-for-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=docs&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/plugin/conditional-fields-for-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#conditional-redirect'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/more-opreators.svg',
        'pro' => true

    ),

    


);


$country_field_features = array(
    'country_code' => array(
        'label' => __('Country code', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/country-code-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=docs&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/country-code-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#view-demo-forms'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/country-code-min.svg'
    ),


    'country_state' => array(
        'label' => __('State Field', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/plugin/cool-formkit-for-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#view-demo-forms'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/state-field.svg',
        'pro' => true
    ),

    'auto_select_country' => array(
        'label' => __('Auto Detect Country', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/plugin/cool-formkit-for-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#conditional-redirect'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/auto-detect.svg',
        'pro' => true

    ),

);



$form_mask_features = array(
    'form_input_mask' => array(
        'label' => __('Field Maksing', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/input-masks-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=docs&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/input-masks-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#view-demo-forms'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/input-mask-min.svg'
    ),
    'hello_plus_support' => array(
        'label' => __('Hello Plus Support', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/plugin/cool-formkit-for-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#conditional-redirect'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/hello-plus-support.svg',
        'pro' => true
    ),

    'advanced_fields' => array(
        'label' => __('Advanced Fields', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/plugin/cool-formkit-for-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#conditional-redirect'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/advanced-field.svg',
        'pro' => true
    ),

);



$input_form_mask_features = array(
    'input_mask' => array(
        'label' => __('Input Mask', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/input-masks-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=docs&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/doc/input-masks-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#view-demo-forms'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/input-mask-min.svg'
    ),
    'hello_plus_support' => array(
        'label' => __('Hello Plus Support', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://docs.coolplugins.net/plugin/conditional-fields-for-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#conditional-redirect'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/hello-plus-support.svg',
        'pro' => true
    ),

    'advanced_fields' => array(
        'label' => __('Advanced Fields', 'cool-formkit'),
        'how_to' => str_replace('utm_source=', 'utm_source=' . $first_plugin, 'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'),
        'demo' => str_replace('utm_source=cfkef_plugin', 'utm_source=' . $first_plugin, 'https://coolplugins.net/product/conditional-fields-for-elementor-form/?utm_source=cfkef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/#conditional-redirect'),
        'icon' => FME_PLUGIN_URL . 'assets/icons/advanced-field.svg',
        'pro' => true
    ),

);




?>


<div id="cfkef-loader" style="display: none;">
    <div class="cfkef-loader-overlay"></div>
    <div class="cfkef-loader-spinner"></div>
</div>

<form method="post" action="options.php">

    <?php settings_fields('cfkef_form_elements_group'); ?>
    <?php do_settings_sections('cfkef_form_elements_group'); ?>

    <div class="cfk-wrapper">

        <div class="cfk-content">
            <div class="cfk-plugins">
                <div class="cfk-box cfk-left">

                    <div class="wrapper-header">
                        <div class="cfkef-save-all">
                            <div class="cfkef-title-desc">
                                <h2><?php esc_html_e('Conditional Fields For Elementor Form', 'cool-formkit'); ?></h2>
                            </div>
                            <div class="cfkef-save-controls">
                                <?php
                                $plugin_file = 'conditional-fields-for-elementor-form/class-conditional-fields-for-elementor-form.php';

                                $is_condtional_field_active = defined('CFEF_VERSION');
                                $all_plugins = get_plugins();
                                $is_conditional_field_installed = isset($all_plugins[$plugin_file]);

                                $card_class = '';
                                $data_action = '';
                                $data_slug = '';
                                $data_init = '';


                                if (!$is_condtional_field_active) {
                                    $card_class .= ' cfkef-has-tooltip';
                                    if ($is_conditional_field_installed) {
                                        $card_class .= ' need-activation';
                                        $data_action = 'activate';
                                        $data_slug   = 'conditional-fields-for-elementor-form';
                                        $data_init   = $plugin_file;
                                    } else {
                                        $card_class .= ' need-install';
                                        $data_init   = $plugin_file;
                                        $data_action = 'install';
                                        $data_slug   = 'conditional-fields-for-elementor-form';
                                    }
                                }

                                ?>

                                <?php

                                if (!$is_condtional_field_active) {

                                    if ($is_conditional_field_installed) {

                                        echo '<a target="_blank" class="button need-activation  cfkef-has-tooltip cfkef-activate-plugin-btn" data-action="' . esc_attr($data_action) . '" data-slug="' . esc_attr($data_slug) . '" data-init="' . esc_attr($data_init) . '" title="Requires Conditional Field plugin to be activated">' . esc_html__('Activate', 'cfef') . '</a>';
                                    } else if (!$is_conditional_field_installed) {

                                        echo '<a target="_blank" class="button need-activation  cfkef-has-tooltip cfkef-install-plugin-btn" data-action="' . esc_attr($data_action) . '" data-slug="' . esc_attr($data_slug) . '" data-init="' . esc_attr($data_init) . '" title="Requires Conditional Field plugin to be install">' . esc_html__('Install', 'cfef') . '</a>';
                                    }
                                } else {

                                    echo '<a target="_blank" href="' . esc_url(
                                        ' https://coolplugins.net/product/conditional-fields-for-elementor-form/?utm_source=' . urlencode($first_plugin) . '&utm_medium=inside&utm_campaign=docs&utm_content=plugins-dashboard'
                                    ) . '" class="button">' . esc_html__('Get Pro', 'cfef') . '</a>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>



                    <div class="wrapper-body">

                        <div class="cfk-p-info">
                            <picture>
                                <source srcset="<?php //echo FME_PLUGIN_URL . 'assets/images/placeholder.avif'; 
                                                ?>">
                                <img src="<?php echo FME_PLUGIN_URL . 'assets/images/conditional-fields.gif'; ?>">
                            </picture>
                            <div class="cfk-p-name">
                                <p>Show or hide Elementor form fields based on other fields values selected by user.</p>
                                <div class="cfk-buttons">
                                    <a target="_blank" class="button button-secondary" href="https://coolplugins.net/conditional-fields-for-elementor-form/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=blog&utm_content=setting-page-cfef-docs">
                                        Documentation
                                    </a>
                                </div>
                            </div>

                        </div>


                        <div class="cfk-p-features">


                            <div class="cfkef-form-element-box">


                                <?php foreach ($condition_plugin_features as $key => $element): ?>



                                    <?php if (!empty($element['pro'])): ?>

                                        <div class="cfkef-form-element-card">
                                            <div class="cfkef-form-element-info">
                                                <img src="<?php echo $element['icon'] ?>" alt="Color Field">
                                                <h4>
                                                    <?php echo esc_html($element['label']); ?>
                                                    <?php if (!empty($element['pro'])): ?>
                                                        <span class="cfkef-label-popular"><a href="<?php echo $element['how_to'] ?>" target="_blank"><?php esc_html_e('Pro', 'cool-formkit'); ?></a></span>
                                                    <?php endif; ?>

                                                    <?php if (in_array($key, $popular_elements)): ?>
                                                        <span class="cfkef-label-popular">Popular</span>
                                                    <?php endif; ?>

                                                    <?php if (in_array($key, $updated_elements)): ?>
                                                        <span class="cfkef-label-updated">Updated</span>
                                                    <?php endif; ?>
                                                </h4>
                                                <div>
                                                    <a href="<?php echo $element['demo'] ?>" title="Documentation" target="_blank" rel="noreferrer">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                            <path fill="#000" d="M21 11V3h-8v2h4v2h-2v2h-2v2h-2v2H9v2h2v-2h2v-2h2V9h2V7h2v4zM11 5H3v16h16v-8h-2v6H5V7h6z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                            <label class="cfkef-toggle-switch" style="opacity: 0.5; ">
                                                <input type="checkbox" name="cfkef_enabled_elements[]" value="<?php echo esc_attr($key); ?>" <?php checked(in_array($key, $enabled_elements)); ?> class="cfkef-element-toggle"
                                                    <?php disabled(!empty($element['pro'])); ?>>
                                                <?php if (!empty($element['pro'])): ?>
                                                    <a href="<?php echo $element['demo'] ?>" target="_blank">
                                                        <span class="cfkef-slider round"></span>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="cfkef-slider round"></span>
                                                <?php endif; ?>

                                            </label>
                                        </div>


                                    <?php else: ?>

                                        <div class="cfkef-form-element-card<?php echo esc_attr($card_class); ?>"


                                            <?php if (!$is_condtional_field_active) : ?>
                                            data-action="<?php echo esc_attr($data_action); ?>"
                                            data-slug="<?php echo esc_attr($data_slug); ?>"
                                            <?php if ($data_init) : ?>
                                            data-init="<?php echo esc_attr($data_init); ?>"
                                            <?php endif; ?>
                                            <?php endif; ?>
                                            title="<?php echo !$is_condtional_field_active ? 'Requires Conditional plugin to be activated' : ''; ?>">
                                            <div class="cfkef-form-element-info">
                                                <img src="<?php echo $element['icon'] ?>" alt="Color Field">
                                                <h4>
                                                    <?php echo esc_html($element['label']); ?>
                                                    <?php if (!empty($element['pro'])): ?>
                                                        <span class="cfkef-label-popular"><a href="<?php echo $element['how_to'] ?>" target="_blank"><?php esc_html_e('Pro', 'cool-formkit'); ?></a></span>
                                                    <?php endif; ?>

                                                    <?php if (in_array($key, $popular_elements)): ?>
                                                        <span class="cfkef-label-popular">Popular</span>
                                                    <?php endif; ?>

                                                    <?php if (in_array($key, $updated_elements)): ?>
                                                        <span class="cfkef-label-updated">Updated</span>
                                                    <?php endif; ?>
                                                </h4>
                                                <div>
                                                    <a href="<?php echo $element['how_to'] ?>" title="Documentation" target="_blank" rel="noreferrer">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                            <path fill="#000" d="M21 11V3h-8v2h4v2h-2v2h-2v2h-2v2H9v2h2v-2h2v-2h2V9h2V7h2v4zM11 5H3v16h16v-8h-2v6H5V7h6z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>

                                            <label class="cfkef-toggle-switch" style="<?php echo !$is_condtional_field_active ? 'opacity: 0.2; ' : ''; ?>">
                                                <input type="checkbox" name="<?php echo esc_attr($key); ?>" value="1" <?php checked(get_option('condtional_logic'));
                                                                                                                        ?> class="cfkef-element-toggle"
                                                    <?php disabled(!$is_condtional_field_active); ?>>
                                                <?php if (!empty($element['pro'])): ?>
                                                    <a href="<?php echo $element['how_to'] ?>" target="_blank">
                                                        <span class="cfkef-slider round"></span>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="cfkef-slider round"></span>
                                                <?php endif; ?>

                                            </label>
                                            <?php if (!$is_condtional_field_active): ?>
                                                <div class="cfkef-tooltip"><?php esc_html_e('Requires Conditional Field plugin to be activated', 'cool-formkit'); ?></div>
                                            <?php endif; ?>
                                        </div>

                                    <?php endif; ?>
                                <?php endforeach; ?>

                            </div>

                        </div>

                        <div class="cfk-buttons">
                            <button type="submit" class="button button-primary "><?php esc_html_e('Save Changes', 'cool-formkit'); ?></button>
                        </div>

                    </div>

                </div>

                <div class="cfk-box cfk-middle">

                    <div class="wrapper-header">
                        <div class="cfkef-save-all">
                            <div class="cfkef-title-desc">
                                <h2><?php esc_html_e('Country Code For Tel Field', 'cool-formkit'); ?></h2>
                            </div>
                            <div class="cfkef-save-controls">


                                <?php
                                $plugin_file = 'country-code-field-for-elementor-form/country-code-field-for-elementor-form.php';

                                $is_country_field_active = defined('CCFEF_VERSION');
                                $all_plugins = get_plugins();
                                $is_country_field_installed = isset($all_plugins[$plugin_file]);

                                $card_class = '';
                                $data_action = '';
                                $data_slug = '';
                                $data_init = '';


                                if (!$is_country_field_active) {
                                    $card_class .= ' cfkef-has-tooltip';
                                    if ($is_country_field_installed) {
                                        $card_class .= ' need-activation';
                                        $data_action = 'activate';
                                        $data_slug   = 'country-code-field-for-elementor-form';
                                        $data_init   = $plugin_file;
                                    } else {
                                        $card_class .= ' need-install';
                                        $data_init   = $plugin_file;
                                        $data_action = 'install';
                                        $data_slug   = 'country-code-field-for-elementor-form';
                                    }
                                }

                                ?>

                                <?php

                                if (!$is_country_field_active) {

                                    if ($is_country_field_installed) {

                                        echo '<a target="_blank" class="button need-activation  cfkef-has-tooltip cfkef-activate-plugin-btn" data-action="' . esc_attr($data_action) . '" data-slug="' . esc_attr($data_slug) . '" data-init="' . esc_attr($data_init) . '" title="Requires Country Code Field plugin to be activated">' . esc_html__('Activate', 'cfef') . '</a>';
                                    } else if (!$is_country_field_installed) {

                                        echo '<a target="_blank" class="button need-activation  cfkef-has-tooltip cfkef-install-plugin-btn" data-action="' . esc_attr($data_action) . '" data-slug="' . esc_attr($data_slug) . '" data-init="' . esc_attr($data_init) . '" title="Requires Country Code Field plugin to be install">' . esc_html__('Install', 'cfef') . '</a>';
                                    }
                                } else {

                                    echo '<a target="_blank" href="' . esc_url(
                                        'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=' . urlencode($first_plugin) . '&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'
                                    ) . '" class="button">' . esc_html__('Get Pro', 'cfef') . '</a>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>


                    <div class="wrapper-body">


                        <div class="cfk-p-info">
                            <picture>
                                <!-- <source srcset="<?php echo FME_PLUGIN_URL . 'assets/images/country-code-field.avif'; ?>"> -->
                                <img src="<?php echo FME_PLUGIN_URL . 'assets/images/country-code-field.gif'; ?>">
                            </picture>
                            <div class="cfk-p-name">
                                <p>Show country codes & flags in Elementor phone field.</p>
                                <div class="cfk-buttons">

                                    <a target="_blank" class="button button-secondary" href="https://docs.coolplugins.net/docs/cool-formkit/add-country-code-dropdown-to-tel-field-in-elementor-forms/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=docs&utm_content=setting-page-ccfef-docs">
                                        Documentation
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="cfk-p-features">
                            <div class="cfkef-form-element-box">


                                <?php foreach ($country_field_features as $key => $element): ?>


                                    <?php if (!empty($element['pro'])): ?>

                                        <div class="cfkef-form-element-card">
                                            <div class="cfkef-form-element-info">
                                                <img src="<?php echo $element['icon'] ?>" alt="Color Field">
                                                <h4>
                                                    <?php echo esc_html($element['label']); ?>
                                                    <?php if (!empty($element['pro'])): ?>
                                                        <span class="cfkef-label-popular"><a href="<?php echo $element['how_to'] ?>" target="_blank"><?php esc_html_e('Pro', 'cool-formkit'); ?></a></span>
                                                    <?php endif; ?>

                                                    <?php if (in_array($key, $popular_elements)): ?>
                                                        <span class="cfkef-label-popular">Popular</span>
                                                    <?php endif; ?>

                                                    <?php if (in_array($key, $updated_elements)): ?>
                                                        <span class="cfkef-label-updated">Updated</span>
                                                    <?php endif; ?>
                                                </h4>
                                                <div>
                                                    <a href="<?php echo $element['demo'] ?>" title="Documentation" target="_blank" rel="noreferrer">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                            <path fill="#000" d="M21 11V3h-8v2h4v2h-2v2h-2v2h-2v2H9v2h2v-2h2v-2h2V9h2V7h2v4zM11 5H3v16h16v-8h-2v6H5V7h6z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                            <label class="cfkef-toggle-switch" style="opacity: 0.5; ">
                                                <input type="checkbox" name="cfkef_enabled_elements[]" value="<?php echo esc_attr($key); ?>" <?php checked(in_array($key, $enabled_elements)); ?> class="cfkef-element-toggle"
                                                    <?php disabled(!empty($element['pro'])); ?>>
                                                <?php if (!empty($element['pro'])): ?>
                                                    <a href="<?php echo $element['demo'] ?>" target="_blank">
                                                        <span class="cfkef-slider round"></span>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="cfkef-slider round"></span>
                                                <?php endif; ?>

                                            </label>
                                        </div>


                                    <?php else: ?>

                                        <div class="cfkef-form-element-card<?php echo esc_attr($card_class); ?>"


                                            <?php if (!$is_country_field_active) : ?>
                                            data-action="<?php echo esc_attr($data_action); ?>"
                                            data-slug="<?php echo esc_attr($data_slug); ?>"
                                            <?php if ($data_init) : ?>
                                            data-init="<?php echo esc_attr($data_init); ?>"
                                            <?php endif; ?>
                                            <?php endif; ?>
                                            title="<?php echo !$is_country_field_active ? 'Requires Conditional plugin to be activated' : ''; ?>">
                                            <div class="cfkef-form-element-info">
                                                <img src="<?php echo $element['icon'] ?>" alt="Color Field">
                                                <h4>
                                                    <?php echo esc_html($element['label']); ?>
                                                    <?php if (!empty($element['pro'])): ?>
                                                        <span class="cfkef-label-popular"><a href="<?php echo $element['how_to'] ?>" target="_blank"><?php esc_html_e('Pro', 'cool-formkit'); ?></a></span>
                                                    <?php endif; ?>

                                                    <?php if (in_array($key, $popular_elements)): ?>
                                                        <span class="cfkef-label-popular">Popular</span>
                                                    <?php endif; ?>

                                                    <?php if (in_array($key, $updated_elements)): ?>
                                                        <span class="cfkef-label-updated">Updated</span>
                                                    <?php endif; ?>
                                                </h4>
                                                <div>
                                                    <a href="<?php echo $element['how_to'] ?>" title="Documentation" target="_blank" rel="noreferrer">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                            <path fill="#000" d="M21 11V3h-8v2h4v2h-2v2h-2v2h-2v2H9v2h2v-2h2v-2h2V9h2V7h2v4zM11 5H3v16h16v-8h-2v6H5V7h6z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>

                                            <label class="cfkef-toggle-switch" style="<?php echo !$is_country_field_active ? 'opacity: 0.2; ' : ''; ?>">
                                                <input type="checkbox" name="<?php echo esc_attr($key); ?>" value="1" <?php checked(get_option('country_code'));
                                                                                                                        ?> class="cfkef-element-toggle"
                                                    <?php disabled(!$is_country_field_active); ?>>
                                                <?php if (!empty($element['pro'])): ?>
                                                    <a href="<?php echo $element['how_to'] ?>" target="_blank">
                                                        <span class="cfkef-slider round"></span>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="cfkef-slider round"></span>
                                                <?php endif; ?>

                                            </label>
                                            <?php if (!$is_country_field_active): ?>
                                                <div class="cfkef-tooltip"><?php esc_html_e('Requires Conditional Field plugin to be activated', 'cool-formkit'); ?></div>
                                            <?php endif; ?>
                                        </div>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="cfk-buttons">
                            <button type="submit" class="button button-primary"><?php esc_html_e('Save Changes', 'cool-formkit'); ?></button>
                        </div>
                    </div>


                </div>

                <?php
                $plugin_file = 'mask-form-elementor/index.php';

                $is_input_form_mask_active = defined('MFE_VERSION');
                $all_plugins = get_plugins();
                $is_input_form_mask_installed = isset($all_plugins[$plugin_file]);

                $card_class = '';
                $data_action = '';
                $data_slug = '';
                $data_init = '';


                ?>


                <?php if ($is_input_form_mask_installed && $is_input_form_mask_active): ?>

                    <div class="cfk-box cfk-right">
                        <div class="wrapper-header">
                            <div class="cfkef-save-all">
                                <div class="cfkef-title-desc">
                                    <h2><?php esc_html_e('Input Mask Elementor Form Fields', 'cool-formkit'); ?></h2>
                                </div>
                                <div class="cfkef-save-controls">

                                        <a target="_blank" href="
                                            https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=<?php echo $first_plugin?>&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard" class="button">Get Pro</a>
                                    
                                </div>
                            </div>
                        </div>


                        <div class="wrapper-body">


                            <div class="cfk-p-info">
                                <picture>
                                    <source srcset="<?php //echo FME_PLUGIN_URL . 'assets/images/placeholder.avif'; 
                                                    ?>">
                                    <img src="<?php echo FME_PLUGIN_URL . 'assets/images/form-input-mask-icon.gif'; ?>">
                                </picture>
                                <div class="cfk-p-name">
                                    <p>Add input mask for form fields to enhance user input accuracy.</p>
                                    <div class="cfk-buttons">
                                        <a target="_blank" class="button button-secondary" href="https://coolplugins.net/add-input-masks-elementor-form/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=blog&utm_content=setting-page-ccfef-docs">
                                            Documentation
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="cfk-p-features">
                                <div class="cfkef-form-element-box">


                                    <?php foreach ($input_form_mask_features as $key => $element): ?>

                                            <div class="cfkef-form-element-card">
                                                <div class="cfkef-form-element-info">
                                                    <img src="<?php echo $element['icon'] ?>" alt="Color Field">
                                                    <h4>
                                                        <?php echo esc_html($element['label']); ?>
                                                        <?php if (!empty($element['pro'])): ?>
                                                            <span class="cfkef-label-popular"><a href="<?php echo $element['how_to'] ?>" target="_blank"><?php esc_html_e('Pro', 'cool-formkit'); ?></a></span>
                                                        <?php endif; ?>

                                                        <?php if (in_array($key, $popular_elements)): ?>
                                                            <span class="cfkef-label-popular">Popular</span>
                                                        <?php endif; ?>

                                                        <?php if (in_array($key, $updated_elements)): ?>
                                                            <span class="cfkef-label-updated">Updated</span>
                                                        <?php endif; ?>
                                                    </h4>
                                                    <div>
                                                        <a href="<?php echo $element['how_to'] ?>" title="Documentation" target="_blank" rel="noreferrer">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                                <path fill="#000" d="M21 11V3h-8v2h4v2h-2v2h-2v2h-2v2H9v2h2v-2h2v-2h2V9h2V7h2v4zM11 5H3v16h16v-8h-2v6H5V7h6z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                                <label class="cfkef-toggle-switch" >
                                                    <input type="checkbox" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php checked(in_array($key, $enabled_elements)); ?> class="cfkef-element-toggle"
                                                        <?php disabled(!empty($element['pro'])); ?>>
                                                    <?php if (!empty($element['pro'])): ?>
                                                        <a href="<?php echo $element['how_to'] ?>" target="_blank">
                                                            <span class="cfkef-slider round"></span>
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="cfkef-slider round"></span>
                                                    <?php endif; ?>

                                                </label>
                                            </div>

                                    <?php endforeach; ?>

                                    <div class="cfk-buttons">

                                        <button type="submit" class="button button-primary"><?php esc_html_e('Save Changes', 'cool-formkit'); ?></button>
                                    </div>

                                
                                </div>
                            </div>
                        
                        </div>



                    </div>

                <?php else: ?>

                    <div class="cfk-box cfk-right">

                        <div class="wrapper-header">
                            <div class="cfkef-save-all">
                                <div class="cfkef-title-desc">
                                    <h2><?php esc_html_e('Form Input Masks for Elementor Form', 'cool-formkit'); ?></h2>
                                </div>
                                <div class="cfkef-save-controls">

                                    <?php
                                    $plugin_file = 'form-masks-for-elementor/form-masks-for-elementor.php';

                                    $is_form_mask_active = defined('FME_VERSION');
                                    $all_plugins = get_plugins();
                                    $is_form_mask_installed = isset($all_plugins[$plugin_file]);

                                    $card_class = '';
                                    $data_action = '';
                                    $data_slug = '';
                                    $data_init = '';


                                    if (!$is_form_mask_active) {
                                        $card_class .= ' cfkef-has-tooltip';
                                        if ($is_form_mask_installed) {
                                            $card_class .= ' need-activation';
                                            $data_action = 'activate';
                                            $data_slug   = 'form-masks-for-elementor';
                                            $data_init   = $plugin_file;
                                        } else {
                                            $card_class .= ' need-install';
                                            $data_init   = $plugin_file;
                                            $data_action = 'install';
                                            $data_slug   = 'form-masks-for-elementor';
                                        }
                                    }

                                    ?>


                                    <?php

                                    if (!$is_form_mask_active) {

                                        if ($is_form_mask_installed) {

                                            echo '<a target="_blank" class="button need-activation  cfkef-has-tooltip cfkef-activate-plugin-btn" data-action="' . esc_attr($data_action) . '" data-slug="' . esc_attr($data_slug) . '" data-init="' . esc_attr($data_init) . '" title="Requires form mask plugin to be activated">' . esc_html__('Activate', 'cfef') . '</a>';
                                        } else if (!$is_form_mask_installed) {

                                            echo '<a target="_blank" class="button need-activation  cfkef-has-tooltip cfkef-install-plugin-btn" data-action="' . esc_attr($data_action) . '" data-slug="' . esc_attr($data_slug) . '" data-init="' . esc_attr($data_init) . '" title="Requires form mask plugin to be install">' . esc_html__('Install', 'cfef') . '</a>';
                                        }
                                    } else {

                                        echo '<a target="_blank" href="' . esc_url(
                                            'https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=' . urlencode($first_plugin) . '&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard'
                                        ) . '" class="button">' . esc_html__('Get Pro', 'cfef') . '</a>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>


                        <div class="wrapper-body">


                            <div class="cfk-p-info">
                                <picture>
                                    <source srcset="<?php //echo FME_PLUGIN_URL . 'assets/images/placeholder.avif'; 
                                                    ?>">
                                    <img src="<?php echo FME_PLUGIN_URL . 'assets/images/form-input-mask-icon.gif'; ?>">
                                </picture>
                                <div class="cfk-p-name">
                                    <p>Add input masks to Elementor Pro forms.</p>
                                    <div class="cfk-buttons">

                                        <a target="_blank" class="button button-secondary" href="https://coolplugins.net/add-input-masks-elementor-form/?utm_source=<?php echo $first_plugin; ?>utm_medium=inside&utm_campaign=blog&utm_content=setting-page-ccfef-docs">
                                            Documentation
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="cfk-p-features">
                                <div class="cfkef-form-element-box">


                                    <?php foreach ($form_mask_features as $key => $element): ?>



                                        <?php if (!empty($element['pro'])): ?>

                                            <div class="cfkef-form-element-card">
                                                <div class="cfkef-form-element-info">
                                                    <img src="<?php echo $element['icon'] ?>" alt="Color Field">
                                                    <h4>
                                                        <?php echo esc_html($element['label']); ?>
                                                        <?php if (!empty($element['pro'])): ?>
                                                            <span class="cfkef-label-popular"><a href="<?php echo $element['how_to'] ?>" target="_blank"><?php esc_html_e('Pro', 'cool-formkit'); ?></a></span>
                                                        <?php endif; ?>

                                                        <?php if (in_array($key, $popular_elements)): ?>
                                                            <span class="cfkef-label-popular">Popular</span>
                                                        <?php endif; ?>

                                                        <?php if (in_array($key, $updated_elements)): ?>
                                                            <span class="cfkef-label-updated">Updated</span>
                                                        <?php endif; ?>
                                                    </h4>
                                                    <div>
                                                        <a href="<?php echo $element['how_to'] ?>" title="Documentation" target="_blank" rel="noreferrer">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                                <path fill="#000" d="M21 11V3h-8v2h4v2h-2v2h-2v2h-2v2H9v2h2v-2h2v-2h2V9h2V7h2v4zM11 5H3v16h16v-8h-2v6H5V7h6z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                                <label class="cfkef-toggle-switch" style="opacity: 0.5; ">
                                                    <input type="checkbox" name="cfkef_enabled_elements[]" value="<?php echo esc_attr($key); ?>" <?php checked(in_array($key, $enabled_elements)); ?> class="cfkef-element-toggle"
                                                        <?php disabled(!empty($element['pro'])); ?>>
                                                    <?php if (!empty($element['pro'])): ?>
                                                        <a href="<?php echo $element['how_to'] ?>" target="_blank">
                                                            <span class="cfkef-slider round"></span>
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="cfkef-slider round"></span>
                                                    <?php endif; ?>

                                                </label>
                                            </div>


                                        <?php else: ?>

                                            <div class="cfkef-form-element-card<?php echo esc_attr($card_class); ?>"


                                                <?php if (!$is_form_mask_active) : ?>
                                                data-action="<?php echo esc_attr($data_action); ?>"
                                                data-slug="<?php echo esc_attr($data_slug); ?>"
                                                <?php if ($data_init) : ?>
                                                data-init="<?php echo esc_attr($data_init); ?>"
                                                <?php endif; ?>
                                                <?php endif; ?>
                                                title="<?php echo !$is_form_mask_active ? 'Requires Form Maks plugin to be activated' : ''; ?>">
                                                <div class="cfkef-form-element-info">
                                                    <img src="<?php echo $element['icon'] ?>" alt="Color Field">
                                                    <h4>
                                                        <?php echo esc_html($element['label']); ?>
                                                        <?php if (!empty($element['pro'])): ?>
                                                            <span class="cfkef-label-popular"><a href="<?php echo $element['how_to'] ?>" target="_blank"><?php esc_html_e('Pro', 'cool-formkit'); ?></a></span>
                                                        <?php endif; ?>

                                                        <?php if (in_array($key, $popular_elements)): ?>
                                                            <span class="cfkef-label-popular">Popular</span>
                                                        <?php endif; ?>

                                                        <?php if (in_array($key, $updated_elements)): ?>
                                                            <span class="cfkef-label-updated">Updated</span>
                                                        <?php endif; ?>
                                                    </h4>
                                                    <div>
                                                        <a href="<?php echo $element['how_to'] ?>" title="Documentation" target="_blank" rel="noreferrer">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                                <path fill="#000" d="M21 11V3h-8v2h4v2h-2v2h-2v2h-2v2H9v2h2v-2h2v-2h2V9h2V7h2v4zM11 5H3v16h16v-8h-2v6H5V7h6z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>

                                                <label class="cfkef-toggle-switch" style="<?php echo !$is_form_mask_active ? 'opacity: 0.2; ' : ''; ?>">
                                                    <input type="checkbox" name="<?php echo esc_attr($key); ?>" value="1" <?php checked(get_option('form_input_mask'));
                                                                                                                            ?> class="cfkef-element-toggle"
                                                        <?php disabled(!$is_form_mask_active); ?>>
                                                    <?php if (!empty($element['pro'])): ?>
                                                        <a href="<?php echo $element['how_to'] ?>" target="_blank">
                                                            <span class="cfkef-slider round"></span>
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="cfkef-slider round"></span>
                                                    <?php endif; ?>

                                                </label>
                                                <?php if (!$is_form_mask_active): ?>
                                                    <div class="cfkef-tooltip"><?php esc_html_e('Requires Form Mask plugin to be activated', 'cool-formkit'); ?></div>
                                                <?php endif; ?>
                                            </div>

                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="cfk-buttons">
                                <button type="submit" class="button button-primary"><?php esc_html_e('Save Changes', 'cool-formkit'); ?></button>
                            </div>

                        </div>

                    </div>

                <?php endif ?>
            </div>

            <div class="cfk-promo">
                <div class="cfk-box cfk-left">

                    <div class="wrapper-header">
                        <div class="cfkef-save-all">
                            <div class="cfkef-title-desc">
                                <h2><?php esc_html_e('What is Cool FormKit?', 'cool-formkit'); ?></h2>
                            </div>

                            <div class="cfkef-save-controls">

                                <a target="_blank" href="https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=<?php $first_plugin ?>&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard" class="button">Get Pro</a>
                            </div>

                        </div>
                    </div>

                    <div class="wrapper-body">


                        <p>All-in-one plugin, An addon for Elementor Pro forms that provides many extra features and advanced fields to extend your form-building experience using Elementor form widget.</p>


                        <div class="cfkef-form-element-box">
                            <?php foreach ($form_elements as $key => $element): ?>
                                <div class="cfkef-form-element-card">
                                    <div class="cfkef-form-element-info">
                                        <img src="<?php echo $element['icon'] ?>" alt="Color Field">
                                        <h4>
                                            <?php echo esc_html($element['label']); ?>
                                            <?php if (!empty($element['pro'])): ?>
                                                <span class="cfkef-label-popular"><a href="<?php echo $element['how_to'] ?>" target="_blank"><?php esc_html_e('Pro', 'cool-formkit'); ?></a></span>
                                            <?php endif; ?>

                                            
                                        </h4>
                                        <div>
                                            <a href="<?php echo $element['demo'] ?>" title="Documentation" target="_blank" rel="noreferrer">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                    <path fill="#000" d="M21 11V3h-8v2h4v2h-2v2h-2v2h-2v2H9v2h2v-2h2v-2h2V9h2V7h2v4zM11 5H3v16h16v-8h-2v6H5V7h6z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                    <label class="cfkef-toggle-switch" style="opacity: 0.5; ">
                                        <input type="checkbox" name="cfkef_enabled_elements[]" value="<?php echo esc_attr($key); ?>" <?php checked(in_array($key, $enabled_elements)); ?> class="cfkef-element-toggle"
                                            <?php disabled(!empty($element['pro'])); ?>>
                                        <?php if (!empty($element['pro'])): ?>
                                            <a href="<?php echo $element['demo'] ?>" target="_blank">
                                                <span class="cfkef-slider round"></span>
                                            </a>
                                        <?php else: ?>
                                            <span class="cfkef-slider round"></span>
                                        <?php endif; ?>

                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>


                    </div>
                </div>

                <div class="cfk-right">
                    <a href="https://www.trustpilot.com/review/coolplugins.net" target="_blank" class="cfk-box review">
                        Are you enjoying using our addon to upgrade features inside your Elementor form? Please submit your review as it boosts our energy to work on future updates.
                        <span>Submit Review ★★★★★</span>
                    </a>
                    <div class="cfk-box">
                        <h3>Links</h3>
                        <div class="cfk-buttons">
                            <a href="https://my.coolplugins.net/account/support-tickets/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=support&utm_content=important-links" class="button button-secondary" target="_blank">Contact Support</a>
                            <a href="https://coolplugins.net/about-us/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=about-us&utm_content=important-links" class="button" target="_blank">Meet Cool Plugins Developers</a>
                            <a href="https://x.com/cool_plugins" class="button" target="_blank">Follow On X</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>

</form>