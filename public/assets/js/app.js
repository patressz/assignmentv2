function money(number)
{
    return Intl.NumberFormat('sk-SK', { style: 'currency', currency: 'eur' }).format(number);
}

var productImage = $('.product-image'),
    productImages = $('.product-images');

productImages.on('click', function(e) {
    e.preventDefault();

    productImage.hide();
    productImage.attr('src', this.src);
    productImage.fadeIn();
});

var addToCart = $('.add-to-cart'),
    cart = $('.cart span');

addToCart.on('click', function(e) {
    e.preventDefault();

    count = +$('.select-count option:selected').text();
    cart.text( count );
});

var chooseOptionMain =  $('.choose-option-main');

chooseOptionMain.on('change', function(e) {
    e.preventDefault();

    var options = [],
        errors = [],
        variant = "",
        optionsLength = 0,
        price = $('.price'),
        availability = $('.availability'),
        selects = $('select.choose-option'),
        hiddenInputs = $('input[type="hidden"].choose-option'),
        productId = $('.product').attr('data-product_id'),
        _token = $('meta[name="csrf-token"]').attr('content');

        selects.each( function() {
            options.push( $(this).val() );
        });

        hiddenInputs.each( function() {
            options.push( $(this).val() );
        });

        $.ajax({
            type: 'POST',
            url: 'http://localhost:8000/getAvailabilityAndPrice',
            data: {
                _token: _token,
            },
            dataType: 'json',
            beforeSend: function() {
                price.empty();
                availability.empty();
            },
            success: function( data ) {
                if ( data.status == 1 ) {

                    $.each(data.data[productId].combinations, function(key, combinations) {

                        optionsLength = Object.keys( combinations.options ).length;

                        for ( i = 0; i < optionsLength; i++) {
                            variant = combinations.options.hasOwnProperty( options[i] );

                            if ( variant == false ) {
                                errors.push(false);
                            }
                        }

                        if ( errors.length == 0 ) {
                            price.text( money( combinations.price ) );
                            availability.text( combinations.available );
                            return false;
                        } else {
                            errors = [];
                        }

                    });

                }
            }
        });


});

