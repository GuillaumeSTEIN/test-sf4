(function ( $ ) {
    'use strict';

    $.fn.extend({
        requireConfirmation: function() {
            return this.each(function() {
                return $(this).on('click', function(event) {
                    event.preventDefault();

                    var actionButton = $(this);

                    if (actionButton.is('a')) {
                        $('#confirmation-button').attr('href', actionButton.attr('href'));
                    }
                    if (actionButton.is('button')) {
                        $('#confirmation-button').on('click', function(event) {
                            event.preventDefault();

                            return actionButton.closest('form').submit();
                        });
                    }

                    return $('#confirmation-modal').modal('show');
                });
            });
        }
    });
})( jQuery );
