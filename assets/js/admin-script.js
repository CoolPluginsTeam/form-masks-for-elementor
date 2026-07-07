

document.addEventListener('DOMContentLoaded', function () {

    const apiSelector = document.querySelector('#api-selector select');
    const ipapiRow    = document.getElementById('ipapi-row');
    const otherApiRow    = document.getElementById('other-api-row');

    // function to handle entries page
    // function to handle shake effect
    buttonShakeEffectHandler();
	// function to handle element card tooltip 
	handleElementCardTooltip();
	// function to handle tooltip buttons actions
	handleTooltipButtonAction();

    if (!apiSelector || !ipapiRow || !otherApiRow) return;

    function toggleIpapiRow() {
        let apiInformationLink = otherApiRow.querySelector('.api-infromation')
        ipapiRow.style.display = apiSelector.value === 'ipapi' ? '' : 'none';
        otherApiRow.style.display = apiSelector.value === 'ipapi' ? 'none' : '';

        switch(apiSelector.value){
            case 'ipstack':
                apiInformationLink.href = 'https://apilayer.com'
                break;
            case 'ipapi':
                apiInformationLink.href = 'https://ipapi.co'
                break;
            case 'geojs':
                apiInformationLink.href = 'https://geojs.io/'
                break;
            case 'ip-api':
                apiInformationLink.href = 'https://ip-api.com'
                break;
            default:
                apiInformationLink.href = 'https://ipinfo.io'
        }
    }
    
    toggleIpapiRow();
    apiSelector.addEventListener('change', toggleIpapiRow);

    const termsLinks = document.querySelectorAll('.ccpw-see-terms');
    const termsBox = document.getElementById('termsBox');

    termsLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            if (termsBox) {
                // Toggle display using plain JavaScript
                const isVisible = termsBox.style.display === 'block';
                termsBox.style.display = isVisible ? 'none' : 'block';
                link.innerHTML = !isVisible ? 'Hide Terms' : 'See terms';
            }
        });
    });
});



function buttonShakeEffectHandler() {
	const shakeInputValues = [
		'conditional_logic',
		'country_code',
		'form_input_mask',
		'input_mask',
	];

	document.querySelectorAll('.cfk-plugins .cfkef-element-toggle').forEach(input => {
		input.addEventListener('change', function () {
			if (!shakeInputValues.includes(input.value)) {
				return;
			}

			const section = input.closest('.cfk-box') || input.closest('.wrapper-body');
			if (!section) {
				return;
			}

			const saveButton = section.querySelector('.cfk-buttons .button-primary');
			if (saveButton) {
				saveButton.classList.add('shake-effect');
			}
		});
	});
}

function handleElementCardTooltip() {
	const cardElm = document.querySelectorAll('.cfkef-form-element-card.cfkef-has-tooltip');

	cardElm.forEach(el => {
		el.addEventListener('click', function () {
			const tooltip = el.querySelector('.cfkef-tooltip');
			if (!tooltip) return;

			// Toggle visibility
			if (tooltip.style.display === 'block') {
				tooltip.style.display = 'none';
				let plugin_name = tooltip.textContent.replace('Activate Plugin', '');

				tooltip.innerHTML = plugin_name; // Reset message
			} else {
				tooltip.style.display = 'block';

				const action = el.dataset.action;
				const slug = el.dataset.slug;
				const init = el.dataset.init;

				// Append button
				if (action === 'activate') {
					const button = document.createElement('button');
					button.className = 'cfkef-activate-plugin-btn';
					button.dataset.slug = slug;
					button.dataset.init = init;
					button.textContent = 'Activate Plugin';
					tooltip.appendChild(button);
				} else if (action === 'install') {
					let extraCss = '';
					if (el.classList.contains('need-install') && el.dataset.slug === 'elementor-pro') {
						extraCss = 'redirect-elementor-page';
					}

					// Clear tooltip text safely
					const tooltipText = tooltip.textContent.replace('Install Plugin', '');
					tooltip.textContent = tooltipText;

					const button = document.createElement('button');
					button.className = `cfkef-install-plugin-btn ${extraCss}`;
					button.dataset.slug = slug;
					button.dataset.init = init;
					button.textContent = 'Install Plugin';
					tooltip.appendChild(button);
				}
			}
		});
	});

	// Hide tooltip if clicked outside any .cfkef-form-element-card
	document.addEventListener('click', function (e) {
		if (!e.target.closest('.cfkef-form-element-card')) {
			document.querySelectorAll('.cfkef-tooltip').forEach(tip => {
				tip.style.display = 'none';
				tip_message  = tip.textContent.replace('Activate Plugin', '');
				tip.innerHTML = tip_message;
			});
		}
	});
}
function handleTooltipButtonAction(){
	document.addEventListener('click', function (e) {
		let ajaxLoader = jQuery('#cfkef-loader');

		if (e.target.classList.contains('cfkef-install-plugin-btn') && !e.target.classList.contains('redirect-elementor-page')) {
			const slug = e.target.dataset.slug;
			const init = e.target.dataset.init;

			
			ajaxLoader.show();

			// First: Install plugin
			jQuery.ajax({
				type: 'POST',
				url: cfkef_plugin_vars.ajaxurl,
				data: {
					action: 'cfkef_plugin_install',
					slug: slug,
					_ajax_nonce: cfkef_plugin_vars.installNonce
				},
				success: function (res) {
					if (res.success) {
						// After successful install, activate the plugin
						jQuery.ajax({
							type: 'POST',
							url: cfkef_plugin_vars.ajaxurl,
							data: {
								action: 'cfkef_plugin_activate',
								init: init,
								security: cfkef_plugin_vars.nonce
							},
							success: function (res) {
								if (res) {
									window.location.reload();
								}
							},
							error: function () {
								alert('Activation failed.');
							},
							complete: function () {
								ajaxLoader.hide();
							}
						});
					} else {
						alert('Installation error: ' + res.data?.message);
						ajaxLoader.hide();
					}
				},
				error: function () {
					alert('Installation failed.');
					ajaxLoader.hide();
				}
			});
		} else if(e.target.classList.contains('redirect-elementor-page')){	
			window.open('https://elementor.com/', '_blank');
		}

		if (e.target.classList.contains('cfkef-activate-plugin-btn')) {
			const init = e.target.dataset.init;

			ajaxLoader.show();
			jQuery.ajax({
				type: 'POST',
				url: cfkef_plugin_vars.ajaxurl,
				data: {
					action: 'cfkef_plugin_activate',
					init: init,
					security: cfkef_plugin_vars.nonce
				},
				success: function (res) {
					window.location.reload()
				},
				error: function () {
					alert('Activation failed.');
				},
				complete: function () {
					ajaxLoader.hide();
				}
			});
		}
	});
}
