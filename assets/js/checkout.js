//console.log('Script loaded');
jQuery(function($) {
    //console.log('jQuery ready');
    //console.log('hello hamza from aswc.js');
    
    // Check for different possible selectors
    //console.log('Checking all possible selectors:');
    //console.log('#billing-state length:', $('#billing-state').length);
    
    
    // Function to initialize our state change handler with the correct selector
    function initStateChangeHandler() {
        // Try to find the state field using various selectors
        let stateField = $('#billing-state');
        let stateSelector = '#billing-state';
        let stateField1 = $('#shipping-state');
        let stateSelector1 = '#shipping-state';
        
        //console.log('Found state field with selector:', stateSelector, 'Length:', stateField.length);
        
        if (stateField.length > 0) {
            //console.log('State field found, attaching handler');
            
            // Try to find the city field using various selectors
            let cityField = $('#billing-city');
            let citySelector = '#billing-city';
            let cityField1 = $('#shipping-city');
            let citySelector1 = '#shipping-city';
            
            //console.log('Found city field with selector:', citySelector, 'Length:', cityField.length);
            
            // Convert city input to select if needed
            if ($(citySelector).length > 0 && !$(citySelector).is('select')) {
                //console.log('City field is not a select, converting it');
                
                // Get the current field properties
                const fieldId = citySelector.substring(1); // Remove the # from the selector
                const fieldId1 = citySelector1.substring(1);
                const fieldLabel = $('label[for="' + fieldId + '"]').text();
                const fieldRequired = $(citySelector).prop('required');
                const fieldRequired1 = $(citySelector1).prop('required');
                const fieldParent = $(citySelector).parent();
                
                // Create a new select element with same styling as state field
                const stateFieldClasses = $(stateSelector).attr('class');
                const stateFieldClasses1 = $(stateSelector1).attr('class');
                
                const selectField = $('<select>', {
                    id: fieldId,
                    name: fieldId,
                    class: stateFieldClasses, // Use state field classes for consistent styling
                    required: fieldRequired,
                    size: '1',
                    ariaInvalid: 'false',
                    autocomplete: 'address-level1'
                });
                
                const wc_block_components_address_form__state =$('<div>',{
                    class: 'wc-block-components-address-form__state wc-block-components-state-input',
                })
                const wc_blocks_components_select =$('<div>',{
                    class: 'wc-blocks-components-select',
                });

                const wc_blocks_components_select__container = $('<div>',{
                    class: 'wc-blocks-components-select__container',
                });
                const wc_blocks_components_select__label =$('<label>',{
                    for: 'aswc-label',
                    class: 'wc-blocks-components-select__label',
                    text: fieldLabel,
                });
                const wc_svg =$('svg',{
                    xmlns: 'URL_ADDRESS.w3.org/2000/svg',
                    width: '24',
                    height: '24',
                    viewBox: '0 0 24 24',
                    class: 'wc-blocks-components-select__expand',
                    focusable: 'false',
                    ariaHidden: 'true',
                });

                const wc_path = $('<path>',{
                    d: 'M17.5 11.6L12 16l-5.5-4.4.9-1.2L12 14l4.5-3.6 1 1.2z',
                });
                wc_svg.append(wc_path);

                const selectField1 = $('<select>', {
                    id: fieldId1,
                    name: fieldId1,
                    class: stateFieldClasses1, // Use state field classes for consistent styling
                    required: fieldRequired1,
                    size: '1',
                });
                
                // Add initial option
                selectField.append($('<option>', {
                    value: '',
                    text: 'Select a state first'
                }));

                selectField1.append($('<option>', {
                    value: '',
                    text: 'Select a state first'
                }));
                
                //
                //$( "div" ).removeClass( "wc-block-components-text-input wc-block-components-address-form__city" );
                const childElement = document.querySelector(".wc-block-components-address-form__state");
                if (childElement) {
                    // Find the closest ancestor with class "class1"
                    const parent = childElement.parentElement.className =''
                    
                    if (parent) {
                      parent.remove();
                     // console.error(parent.classList); // Remove the parent
                    }
                  } else {
                   // console.error('Child element not found!');
                  }
                //
                //
                const parentElement = document.getElementById('billing');
                const childElement1 = parentElement.querySelector('.wc-block-components-address-form__city'); // Assuming the child has class "child"

                if (childElement1) {
                childElement1.classList.remove('wc-block-components-text-input');
                }
                const labelToRemove = document.querySelector('label[for="billing-city"]');
                if (labelToRemove) {
                labelToRemove.remove();
                }

                wc_blocks_components_select__container.append(wc_blocks_components_select__label);
                wc_blocks_components_select__container.append(selectField);
                wc_blocks_components_select__container.append(wc_svg);
                //
                wc_blocks_components_select.append(wc_blocks_components_select__container);
                wc_block_components_address_form__state.append(wc_blocks_components_select);

                // Replace the input with the select
                $(citySelector).replaceWith(wc_block_components_address_form__state);
                $(citySelector1).replaceWith(selectField1);
                
                // Update the citySelector to point to the new select element
                cityField = $('#' + fieldId);
                citySelector = '#' + fieldId;

                cityField1 = $('#' + fieldId1);
                citySelector1 = '#' + fieldId1;
                
               // console.log('City field converted to select with same styling as state field');
            }
            
            // Remove any existing handlers to avoid duplicates
            $(document).off('change', stateSelector);
            $(document).off('change', stateSelector1);
            
            // Add our handler
            $(document).on('change', stateSelector, function() {
                //console.log('State changed');
                var selectedState = $(this).val();
                //console.log('Selected state:', selectedState);
                
                // Always initialize the city field first, regardless of whether a state is selected
                $(citySelector).empty();
                $(citySelector).append($('<option>', {
                    value: '',
                    text: selectedState ? 'Loading cities...' : 'Select a state first'
                }));
                $(citySelector).prop('disabled', true);
                
                if (selectedState) {
                    $.ajax({
                        url: aswc_params.ajax_url,
                        type: 'POST',
                        data: {
                            action: 'get_algeria_cities',
                            wilaya_id: selectedState,
                            nonce: aswc_params.nonce
                        },
                        beforeSend: function() {
                           // console.log('Sending AJAX request...');
                        },
                        success: function(response) {
                          //  console.log('AJAX Response:', response);
                            if (response.success && response.data) {
                                $(citySelector).empty();
                                $(citySelector).append($('<option>', {
                                    value: '',
                                    text: 'Select a city...'
                                }));
                                
                                $.each(response.data, function(index, city) {
                                    $(citySelector).append($('<option>', {
                                        value: city,
                                        text: city
                                    }));
                                });
                                
                                $(citySelector).prop('disabled', false);
                            } else {
                               // console.error('Invalid response:', response);
                                $(citySelector).empty().append($('<option>', {
                                    value: '',
                                    text: 'Error loading cities'
                                }));
                            }
                        },
                        error: function(xhr, status, error) {
                            //console.error('AJAX error:', error);
                            //console.log('XHR:', xhr.responseText);
                            $(citySelector).empty().append($('<option>', {
                                value: '',
                                text: 'Error loading cities'
                            }));
                        }
                    });
                }
            });

            //
            $(document).on('change', stateSelector1, function() {
                //console.log('State changed');
                var selectedState1 = $(this).val();
                //console.log('Selected state:', selectedState1);
                
                // Always initialize the city field first, regardless of whether a state is selected
                $(citySelector1).empty();
                $(citySelector1).append($('<option>', {
                    value: '',
                    text: selectedState1 ? 'Loading cities...' : 'Select a state first'
                }));
                $(citySelector1).prop('disabled', true);
                
                if (selectedState1) {
                    $.ajax({
                        url: aswc_params.ajax_url,
                        type: 'POST',
                        data: {
                            action: 'get_algeria_cities',
                            wilaya_id: selectedState1,
                            nonce: aswc_params.nonce
                        },
                        beforeSend: function() {
                          //  console.log('Sending AJAX request...');
                        },
                        success: function(response) {
                           // console.log('AJAX Response:', response);
                            if (response.success && response.data) {
                                $(citySelector1).empty();
                                $(citySelector1).append($('<option>', {
                                    value: '',
                                    text: 'Select a city...'
                                }));
                                
                                $.each(response.data, function(index, city) {
                                    $(citySelector1).append($('<option>', {
                                        value: city,
                                        text: city
                                    }));
                                });
                                
                                $(citySelector1).prop('disabled', false);
                            } else {
                               // console.error('Invalid response:', response);
                                $(citySelector).empty().append($('<option>', {
                                    value: '',
                                    text: 'Error loading cities'
                                }));
                            }
                        },
                        error: function(xhr, status, error) {
                            //console.error('AJAX error:', error);
                            //console.log('XHR:', xhr.responseText);
                            $(citySelector1).empty().append($('<option>', {
                                value: '',
                                text: 'Error loading cities'
                            }));
                        }
                    });
                }
            });
            //
                        
            return true;
        }
        
        return false;
    }
    
    // Try on document ready
    if (!initStateChangeHandler()) {
        //console.log('Fields not found on initial load, setting up observers');
        
        // Set up a MutationObserver to watch for changes to the DOM
        const checkoutBlock = document.querySelector('.woocommerce-checkout');
        const mainTag = document.querySelector('main');
        const targetNode = checkoutBlock || mainTag || document.body;
        
        //console.log('Setting up observer on:', targetNode.tagName);
        
        // Create a MutationObserver to watch for changes to the DOM
        const observer = new MutationObserver(function(mutations) {
            if (initStateChangeHandler()) {
                //console.log('Fields found, disconnecting observer');
                observer.disconnect();
            }
        });
        
        // Start observing
        observer.observe(targetNode, { 
            childList: true, 
            subtree: true 
        });
    }
    
    // Also try when WooCommerce updates the checkout
    $(document.body).on('updated_checkout', function() {
        //console.log('Checkout updated, checking for fields again');
        initStateChangeHandler();
    });
    
    // Also try on country change which might trigger field updates
    $(document.body).on('country_to_state_changed', function() {
        //console.log('Country changed, checking for fields again');
        initStateChangeHandler();
    });
    
});

