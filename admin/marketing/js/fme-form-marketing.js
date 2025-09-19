jQuery(document).ready(function($) {

    $(document).on('click', '.fme-dismiss-notice, .fme-dismiss-cross, .fme-tec-notice .notice-dismiss', function(e) {
        e.preventDefault();
        var $el = $(this);
        var noticeType = $el.data('notice');
        var nonce = $el.data('nonce');

        if (noticeType == undefined) {
            noticeType = jQuery('.fme-tec-notice').data('notice');
            nonce = jQuery('.fme-tec-notice').data('nonce');
        }

        $.post(ajaxurl, {
            action: 'fme_mkt_dismiss_notice',
            notice_type: noticeType,
            nonce: nonce
        }, function(response) {
            if (response.success) {
                if (noticeType === 'cool_form') {
                    $el.closest('.cool-form-wrp').fadeOut();
                } else if (noticeType === 'tec_notice') {
                    $el.closest('.fme-tec-notice').fadeOut();
                }
            }
        });
    });

    $(document).on('click', '.fme-install-plugin', function(e) {
        e.preventDefault();

        var $form = $(this);
        var $wrapper = $form.closest('.cool-form-wrp');
        let button = $(this);
        let plugin = button.data('plugin');
        button.next('.fme-error-message').remove();

        const slug = getPluginSlug(plugin);
        if (!slug) return;

        let nonce = button.data('nonce');

        button.text('Installing...').prop('disabled', true);
        disableAllOtherPluginButtonsTemporarily(slug);

        $.post(ajaxurl, {
                action: 'fme_install_plugin',
                slug: slug,
                _wpnonce: nonce
            },
            function(response) {
                const pluginSlug = slug;
                const responseString = JSON.stringify(response);
                const responseContainsPlugin = responseString.includes(pluginSlug);

                if (pluginSlug === 'country-code-field-for-elementor-form') {
                    const $page_html = $(response);
                    let $input_country_code = $page_html.find('input[name="country_code"]');

                    if ($input_country_code.is(':disabled')) {
                        showNotActivatedMessage($wrapper);
                    } else {
                        handlePluginActivation(button, slug, $wrapper);
                    }
                } else if (responseContainsPlugin) {
                    handlePluginActivation(button, slug, $wrapper);
                } else if (!responseContainsPlugin) {
                    showNotActivatedMessage($wrapper);
                } else {
                    let errorMessage = 'Please try again or download plugin manually from WordPress.org</a>';
                    $wrapper.find('.elementor-button-warning').remove();
                    if (slug === 'events-widget') {
                        jQuery('.ect-notice-widget').text(errorMessage)
                    } else {
                        $wrapper.find('.elementor-control-notice-main-actions').after(
                            '<div class="elementor-control-notice elementor-button-warning">' +
                            '<div class="elementor-control-notice-content">' +
                            errorMessage +
                            '</div></div>'
                        );
                    }
                }
            }
        );
    });

    // function for activation success
    function handlePluginActivation(button, slug, $wrapper) {
        button.text('Activated')
            .removeClass('e-btn e-info e-btn-1 elementor-button-success')
            .addClass('elementor-disabled')
            .prop('disabled', true);

        disableOtherPluginButtons(slug);

        let successMessage = 'Save & reload the page to start using the feature.';

        if (slug === 'events-widgets-for-elementor-and-the-events-calendar') {
            successMessage = 'Events Widget is now active! Design your Events page with Elementor to access powerful new features.';

            jQuery('.fme-tec-notice .ect-notice-widget').text(successMessage);

        } else {
            $wrapper.find('.elementor-control-notice-success').remove();
            $wrapper.find('.elementor-control-notice-main-actions').after(
                '<div class="elementor-control-notice elementor-control-notice-success">' +
                '<div class="elementor-control-notice-content">' +
                successMessage +
                '</div></div>'
            );
        }
    }

    // function for "not activated" notice
    function showNotActivatedMessage($wrapper) {
        $wrapper.find('.elementor-control-notice-success').remove();
        $wrapper.find('.elementor-control-notice-main-actions').after(
            '<div class="elementor-control-notice elementor-control-notice-success">' +
            '<div class="elementor-control-notice-content">' +
            'The plugin is installed but not yet activated. Please go to the Plugins menu and activate it.' +
            '</div></div>'
        );
    }

    function getPluginSlug(plugin) {
        const slugs = {
            'cool-form-lite': 'extensions-for-elementor-form',
            'conditional': 'conditional-fields-for-elementor-form',
            'country-code': 'country-code-field-for-elementor-form',
            'loop-grid': 'loop-grid-extender-for-elementor-pro',
            'events-widget': 'events-widgets-for-elementor-and-the-events-calendar',
            'conditional-pro': 'conditional-fields-for-elementor-form-pro',
        };
        return slugs[plugin];
    }

    function disableAllOtherPluginButtonsTemporarily(activeSlug) {
        const relatedSlugs = [
            'extensions-for-elementor-form',
            'conditional-fields-for-elementor-form',
            'country-code-field-for-elementor-form'
        ];

        jQuery('.fme-install-plugin').each(function() {
            const $btn = jQuery(this);
            const btnSlug = getPluginSlug($btn.data('plugin'));
            if (btnSlug !== activeSlug && relatedSlugs.includes(btnSlug)) {
                $btn.prop('disabled', true);
            }
        });
    }

    function disableOtherPluginButtons(activatedSlug) {
        const relatedSlugs = [
            'extensions-for-elementor-form',
            'conditional-fields-for-elementor-form',
            'country-code-field-for-elementor-form'
        ];

        if (!relatedSlugs.includes(activatedSlug)) return;

        jQuery('.fme-install-plugin').each(function() {
            const $btn = jQuery(this);
            const btnSlug = getPluginSlug($btn.data('plugin'));

            if (btnSlug !== activatedSlug && relatedSlugs.includes(btnSlug)) {
                $btn.text('Already Installed')
                    .addClass('elementor-disabled')
                    .prop('disabled', true)
                    .removeClass('e-btn e-info e-btn-1 elementor-button-success');

                $btn.closest('.cool-form-wrp').hide();

                if (btnSlug === 'country-code-field-for-elementor-form') {
                    $('[data-setting="cfme-mkt-country-conditions"]').closest('.elementor-control').hide();
                }
                if (btnSlug === 'conditional-fields-for-elementor-form') {
                    $('[data-setting="cfme-mkt-conditional-conditions"]').closest('.elementor-control').hide();
                }
            }
        });
    }

});
