Number.prototype.myRound = function (decimals) {
    decimals = decimals || 2;
    let multiplier = Math.pow(10, decimals);
    return (
        Math.round((this.valueOf() * multiplier).toFixed(decimals)) / multiplier
    );
};

Number.random = function (min, max) {
    return min + Math.floor(Math.random() * (max + 1 - min));
};

String.prototype.slug = function () {
    return this.valueOf()
        .toLowerCase()
        .replace(/\&\&+/g, "and") // Replace multiple & with single &
        .replace(/\s+/g, "-") // Replace spaces with -
        .replace(/[^\w\-]+/g, "") // Remove all non-word chars
        .replace(/\-\-+/g, "-") // Replace multiple - with single -
        .replace(/^-+/, "") // Trim - from start of text
        .replace(/-+$/, ""); // Trim - from end of text
};

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

setTimeout(function () {
    $(".hide-after-some-seconds").fadeOut();
}, 5000);

function alertMessage(message, type) {
    type = type || "success";

    showSuccessToast(message, type);
}

function notification(message, type, duration) {
    console.log(message);

    type = type || "success";
    duration = (duration || 5) * 1000;

    $.notify(
        {
            // icon: "notifications",
            message: message,
        },
        {
            type: type,
            timer: duration,
            placement: {
                from: "top",
                align: "right",
            },
        }
    );
}

/**
 * Check if scroll has reached the bottom of the $element
 * enclose it inside $(window).on('scroll', function() { METHOD_GOES_HERE })
 *
 * @param $element
 * @returns {boolean}
 */
function isAtTheBottomOf($element) {
    let elementTopPosition = $element.position().top;
    let elementHeight = $element.outerHeight();
    let scrollBarTopPosition = $(window).scrollTop();
    let scrollBarHeight =
        window.innerHeight * (window.innerHeight / document.body.offsetHeight);

    return (
        elementTopPosition + elementHeight <=
        scrollBarTopPosition + scrollBarHeight
    );
}
