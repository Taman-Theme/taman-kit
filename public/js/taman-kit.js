(function ($) {
    var getElementSettings = function ($element) {
        var elementSettings = {};

        elementSettings = $element.data("settings") || {};

        return elementSettings;
    };

    var isEditMode		= false;

    var TamanKitModalHandler = function ($scope, $) {
        var
            elementSettings = getElementSettings($scope),
            widget_id = $scope.data("id"),
            popup_elem = $scope.find(".tk-modal-popup-" + widget_id).eq(0),
            $popup_id = "popup_" + widget_id,
            $display_after = popup_elem.data('display-after'),
            $trigger = elementSettings.trigger,
            $delay = popup_elem.data("delay"),
            $modal = "tk-modal-popup-window-" + widget_id;

        if ('page-load' == $trigger) {

            $(document).ready(function () {

                if ($display_after === 0) {
                    $.removeCookie($popup_id, { path: '/' });
                }

                if (!$.cookie($popup_id)) {
                    setTimeout(function () {

                        $('#tk-openmodal').trigger('click');

                        if ($display_after > 0) {
                            $.cookie($popup_id, $display_after, { expires: $display_after, path: '/' });
                        } else {
                            $.removeCookie($popup_id);
                        }
                    }, $delay);
                }
            });
        }

        if ('exit-intent' == $trigger) {
            var mouseY = 0,
                topValue = 0;

            const mouseEvent = e => {
                if (!e.toElement && !e.relatedTarget) {
                    document.removeEventListener('mouseout', mouseEvent);
                    $('#tk-openmodal').trigger('click');
                }
            };

            $(document).on('mouseleave', function (e) {
                mouseY = e.clientY;

                if (mouseY < topValue && !$.cookie($popup_id)) {

                    document.addEventListener('mouseout', mouseEvent);

                    if ($display_after > 0) {
                        $.cookie($popup_id, $display_after, { expires: $display_after, path: '/' });
                    } else {
                        $.removeCookie($popup_id);
                    }
                }
            });
        }

    };

	
    $(window).on("elementor/frontend/init", function () {
        if ( elementorFrontend.isEditMode() ) {
			isEditMode = true;
		}
        elementorFrontend.hooks.addAction("frontend/element_ready/tk-modal.default", TamanKitModalHandler);

        
    });
})(jQuery);
