function initAutocomplete() {
    var autocomplete = new google.maps.places.Autocomplete(document.getElementById('autocomplete'), {
        types: ['(cities)']
    });
    autocomplete.setFields(['address_component', 'geometry']);

    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();
        if (place.geometry) {
            var city = '';
            var state = '';
            var country = '';

            for (var i = 0; i < place.address_components.length; i++) {
                var component = place.address_components[i];
                if (component.types.includes('locality')) {
                    city = component.long_name;
                } else if (component.types.includes('administrative_area_level_1')) {
                    state = component.long_name;
                } else if (component.types.includes('country')) {
                    country = component.long_name;
                }
            }

            $('#latitude').val(place.geometry.location.lat());
            $('#longitude').val(place.geometry.location.lng());
            $('#city').val(city);
            $('#state').val(state);
            $('#country').val(country);
        }
    });
}

google.maps.event.addDomListener(window, 'load', initAutocomplete);
