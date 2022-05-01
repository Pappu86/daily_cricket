/**
 * Show page loader
 * @param boolean true/false
 * @result page loader show
 */
export const showLoader = (isOverlay = true) => {
    if (isOverlay) {
        $("#overlayer").show();
    }
    $(".loader").show();
};

/**
 * Hide page loader
 * @param boolean true/false
 * @result page loader hode
 */
export const hideLoader = (isOverlay = true) => {
    if (isOverlay) {
        $("#overlayer").hide();
    }
    $(".loader").hide();
};
