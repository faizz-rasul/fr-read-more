jQuery(document).ready(function($) {
    var lessButton = $('.fr-readmore-toggle[data-less]');
    var moreButton = $('.fr-readmore-toggle[data-more]');
    
    lessButton.hide();
    moreButton.show();
    
    $('.fr-readmore-toggle').click(function() {
        var button = $(this);
        var container = button.closest('.fr-readmore'); // Get the closest wrapper div
        var content = container.find('.fr-readmore-content'); // Find the content within the container
        
        if (content.is(':visible')) {
            content.slideUp(400, function() {
                button.text("Read more");
                lessButton.hide();
                moreButton.show();
            });
        } else {
            // Make AJAX request with nonce included
            $.ajax({
                url: frReadmoreAjax.ajaxurl, // AJAX URL
                type: 'post',
                dataType: 'json',
                data: {
                    action: 'frrm_readmore_plugin_load_content', // AJAX action name
                    nonce: frReadmoreAjax.nonce, // Include nonce in data
                },
                success: function(response) {
                    content.html(response.data);
                    content.slideDown(400, function() {
                        button.text("Read less");
                    });
                    lessButton.show();
                    moreButton.hide();
                    $('html, body').animate({
                        scrollTop: container.offset().top
                    }, 400);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed: ' + status + ', ' + error);
                }
            });
        }
    });
});
