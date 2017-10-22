/* globals jQuery, report */
;(function ($, window, report, undefined) {
    "use strict";

    function unique(arr) {
        return $.grep(arr, function (v, k) {
            return $.inArray(v, arr) === k;
        });
    }

    $(document).ready(function () {

        $('.css-block-prelude').on('click', function (event) {
            event.preventDefault();

            var $cssBlock = $(this).closest('.css-block');

            if ($cssBlock.is('.css-block-collapsable')) {
                $cssBlock.children('.css-block').toggleClass('hidden');
                $cssBlock.toggleClass('collapsed');
            }

        });

        var $blocks = $('.css-block');

        $.each(['id', 'class', 'type'], function (i, filter) {
            var $options = $('.filter-' + filter + '-input');

            $options.on('change', function (event) {
                var selection, blockIds, selector, $matches;

                selection = $options.filter(':checked').map(function () {
                    return $(this).val();
                }).get();

                blockIds = unique($.map(selection, function (id) {
                    return report[filter + 'Map'][id] || [];
                }));

                selector = $.map(blockIds, function (blockId) {
                    return '#css-block-' + blockId;
                }).join(', ');

                $matches = $blocks.filter(selector);

                $blocks.show();

                if ($matches.length) {
                    $blocks.not($matches).hide();
                    $matches.parents('.css-block').show();
                }
            });


        });

    });


}(jQuery, window, report));