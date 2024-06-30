// Front Scripts

(function ($, window, document, pluginObject) {

    $(document).on('click', '.dokaani-add-cart', function () {
        var thisButton = $(this),
            productID = thisButton.data('product-id');

        $.ajax({
            type: 'post',
            url: pluginObject.ajaxurl,
            data: {
                'action': 'add_to_cart',
                'product_id': productID,
            },
            success: function (response) {
                if (response.success) {
                    thisButton.html('Cart Added')
                } else {
                    console.error(response.data.message);
                }
            }
        });
    });

    $(document).on('click', '.dokaani-remove-cart', function () {
        var thisButton = $(this),
            productID = thisButton.data('product-id');

        $.ajax({
            type: 'post',
            url: pluginObject.ajaxurl,
            data: {
                'action': 'remove_cart',
                'product_id': productID,
            },
            success: function (response) {
                if (response.success) {
                    thisButton.parents('.dokaani-cart-wrap').css('display', 'none');
                } else {
                    console.error(response.data.message);
                }
            }
        });
    });

})(jQuery, window, document, dokaani_cart);
