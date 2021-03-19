(function ($) {
    var getElementSettings = function ($element) {
        var elementSettings = {};

        elementSettings = $element.data("settings") || {};


        return elementSettings;
    };

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

    var TamanKitProgressHandler = function ($scope) {
        var $target = $scope.find(".tk-progress-bar"),
            percent = $target.data("percent"),
            type = $target.data("type"),
            deltaPercent = percent * 0.01;

        elementorFrontend.waypoint($target, function (direction) {
            var $this = $(this),
                animeObject = { charged: 0 },
                $statusBar = $(".tk-progress-bar__status-bar", $this),
                $percent = $(".tk-progress-bar__percent-value", $this),
                animeProgress,
                animePercent;

            if ("type-7" == type) {
                $statusBar.css({
                    height: percent + "%",
                });
            } else {
                $statusBar.css({
                    width: percent + "%",
                });
            }

            animePercent = anime({
                targets: animeObject,
                charged: percent,
                round: 1,
                duration: 1000,
                easing: "easeInOutQuad",
                update: function () {
                    $percent.html(animeObject.charged);
                },
            });
        });
    };

    /**=================================================== */
    var TamanKitCounterHandler = function ($scope, $) {
        var $counterElement = $scope.find(".tk-counter");

        elementorFrontend.waypoint($counterElement, function () {
            var counterSettings = $counterElement.data(),
                incrementElement = $counterElement.find(".tk-counter-init"),
                iconElement = $counterElement.find(".icon");

            $(incrementElement).numerator(counterSettings);

            $(iconElement).addClass("animated " + iconElement.data("animation"));
        });
    };
    /**=================================================== */
    var TamanKitCountDownHandler = function ($scope, $) {
        var countDownElement = $scope.find(".tk-countdown").each(function () {
            var countDownSettings = $(this).data("settings");
            var label1 = countDownSettings["label1"],
                label2 = countDownSettings["label2"],
                newLabe1 = label1.split(","),
                newLabe2 = label2.split(",");
            if (countDownSettings["event"] === "onExpiry") {
                $(this)
                    .find(".tk-countdown-init")
                    .pre_countdown({
                        labels: newLabe2,
                        labels1: newLabe1,
                        until: new Date(countDownSettings["until"]),
                        format: countDownSettings["format"],
                        padZeroes: true,
                        timeSeparator: countDownSettings["separator"],
                        onExpiry: function () {
                            $(this).html(countDownSettings["text"]);
                        },
                        serverSync: function () {
                            return new Date(countDownSettings["serverSync"]);
                        },
                    });
            } else if (countDownSettings["event"] === "expiryUrl") {
                $(this)
                    .find(".tk-countdown-init")
                    .pre_countdown({
                        labels: newLabe2,
                        labels1: newLabe1,
                        until: new Date(countDownSettings["until"]),
                        format: countDownSettings["format"],
                        padZeroes: true,
                        timeSeparator: countDownSettings["separator"],
                        expiryUrl: countDownSettings["text"],
                        serverSync: function () {
                            return new Date(countDownSettings["serverSync"]);
                        },
                    });
            }

            times = $(this).find(".tk-countdown-init").pre_countdown("getTimes");

            function runTimer(el) {
                return el == 0;
            }
            if (times.every(runTimer)) {
                if (countDownSettings["event"] === "onExpiry") {
                    $(this).find(".tk-countdown-init").html(countDownSettings["text"]);
                }
                if (countDownSettings["event"] === "expiryUrl") {
                    var editMode = $("body").find("#elementor").length;
                    if (editMode > 0) {
                        $(this)
                            .find(".tk-countdown-init")
                            .html(
                                "<h1>You can not redirect url from elementor Editor!!</h1>"
                            );
                    } else {
                        window.location.href = countDownSettings["text"];
                    }
                }
            }
        });
    };

    /*======================================================== */
    var TamanKitCircleProgressHandler = function ($scope) {
        var $progress = $scope.find(".circle-progress");

        if (!$progress.length) {
            return;
        }

        var $value = $progress.find(".circle-progress__value"),
            $meter = $progress.find(".circle-progress__meter"),
            percent = parseInt($value.data("value")),
            progress = percent / 100,
            duration = $scope.find(".circle-progress-wrap").data("duration"),
            responsiveSizes = $progress.data("responsive-sizes"),
            desktopSizes = responsiveSizes.desktop,
            tabletSizes = responsiveSizes.tablet,
            mobileSizes = responsiveSizes.mobile,
            currentDeviceMode = elementorFrontend.getCurrentDeviceMode(),
            prevDeviceMode = currentDeviceMode,
            isAnimatedCircle = false;

        if ("tablet" === currentDeviceMode) {
            updateSvgSizes(
                tabletSizes.size,
                tabletSizes.viewBox,
                tabletSizes.center,
                tabletSizes.radius,
                tabletSizes.valStroke,
                tabletSizes.bgStroke,
                tabletSizes.circumference
            );
        }

        if ("mobile" === currentDeviceMode) {
            updateSvgSizes(
                mobileSizes.size,
                mobileSizes.viewBox,
                mobileSizes.center,
                mobileSizes.radius,
                mobileSizes.valStroke,
                mobileSizes.bgStroke,
                mobileSizes.circumference
            );
        }

        elementorFrontend.waypoint($scope, function () {
            // animate counter
            var $number = $scope.find(".circle-counter__number"),
                data = $number.data();

            var decimalDigits = data.toValue.toString().match(/\.(.*)/);

            if (decimalDigits) {
                data.rounding = decimalDigits[1].length;
            }

            data.duration = duration;

            $number.numerator(data);

            // animate progress
            var circumference = parseInt($progress.data("circumference")),
                dashoffset = circumference * (1 - progress);

            $value.css({
                transitionDuration: duration + "ms",
                strokeDashoffset: dashoffset,
            });

            isAnimatedCircle = true;
        });

        $(window).on(
            "resize.tkCircleProgress orientationchange.tkCircleProgress",
            circleResizeHandler
        );

        function circleResizeHandler(event) {
            currentDeviceMode = elementorFrontend.getCurrentDeviceMode();

            if ("desktop" === currentDeviceMode && "desktop" !== prevDeviceMode) {
                updateSvgSizes(
                    desktopSizes.size,
                    desktopSizes.viewBox,
                    desktopSizes.center,
                    desktopSizes.radius,
                    desktopSizes.valStroke,
                    desktopSizes.bgStroke,
                    desktopSizes.circumference
                );
                prevDeviceMode = "desktop";
            }

            if ("tablet" === currentDeviceMode && "tablet" !== prevDeviceMode) {
                updateSvgSizes(
                    tabletSizes.size,
                    tabletSizes.viewBox,
                    tabletSizes.center,
                    tabletSizes.radius,
                    tabletSizes.valStroke,
                    tabletSizes.bgStroke,
                    tabletSizes.circumference
                );
                prevDeviceMode = "tablet";
            }

            if ("mobile" === currentDeviceMode && "mobile" !== prevDeviceMode) {
                updateSvgSizes(
                    mobileSizes.size,
                    mobileSizes.viewBox,
                    mobileSizes.center,
                    mobileSizes.radius,
                    mobileSizes.valStroke,
                    mobileSizes.bgStroke,
                    mobileSizes.circumference
                );
                prevDeviceMode = "mobile";
            }
        }

        function updateSvgSizes(
            size,
            viewBox,
            center,
            radius,
            valStroke,
            bgStroke,
            circumference
        ) {
            var dashoffset = circumference * (1 - progress);

            $progress.attr({
                width: size,
                height: size,
                "data-radius": radius,
                "data-circumference": circumference,
            });

            $progress[0].setAttribute("viewBox", viewBox);

            $meter.attr({
                cx: center,
                cy: center,
                r: radius,
                "stroke-width": bgStroke,
            });

            if (isAnimatedCircle) {
                $value.css({
                    transitionDuration: "",
                });
            }

            $value.attr({
                cx: center,
                cy: center,
                r: radius,
                "stroke-width": valStroke,
            });

            $value.css({
                strokeDasharray: circumference,
                strokeDashoffset: isAnimatedCircle ? dashoffset : circumference,
            });
        }
    };
    /*========================================================*/

    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/tk_counter.default", TamanKitCounterHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/tk-countdown.default", TamanKitCountDownHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/tk-progress.default", TamanKitProgressHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/tk-circleprogress.default", TamanKitCircleProgressHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/tk-modal.default", TamanKitModalHandler);
    });
})(jQuery);
