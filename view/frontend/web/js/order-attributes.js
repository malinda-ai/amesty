// Country code to name mapping for enhanced reliability
var countryMapping = {
    'US': 'United States',
    'CA': 'Canada',
    'GB': 'United Kingdom',
    'DE': 'Germany',
    'FR': 'France',
    'IT': 'Italy',
    'ES': 'Spain',
    'JP': 'Japan',
    'AU': 'Australia',
    'BR': 'Brazil'
};

// Listen for change event on the country select box and log the selected country name
document.addEventListener('DOMContentLoaded', function() {
    var select = document.getElementById('country-select');
    
    if (select) {
        select.addEventListener('change', function() {
            var selectedValue = select.value;
            var countryName = '';
            
            // Try to get country name from selected option text first
            if (selectedValue && select.selectedIndex > 0) {
                var selectedOption = select.options[select.selectedIndex];
                countryName = selectedOption.textContent || selectedOption.innerText;
            }
            
            // Fallback to mapping if option text is not available
            if (!countryName && selectedValue && countryMapping[selectedValue]) {
                countryName = countryMapping[selectedValue];
            }
            
            // Log the country name if available, otherwise log that no country was selected
            if (countryName) {
                console.log('Selected country:', countryName);
            } else if (selectedValue === '') {
                console.log('No country selected');
            } else {
                console.log('Selected country code:', selectedValue, '(name not found)');
            }
        });
    } else {
        console.warn('Country select element not found');
    }
});
