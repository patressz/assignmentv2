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

