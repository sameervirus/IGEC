jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        updateSldier();
    };
    function updateSldier() {
        if (typeof window.Flickity !== 'undefined') {
            setTimeout(function () {
                window.pnwt.sections.pnwtSlickCarousel();
            }, 10);
        } else {
			window.pnwt.sections.pnwtSlickCarousel();
        }
    }
    elementorFrontend.hooks.addAction(
        'frontend/element_ready/powernode-image-carousel.default',
        addHandler
    );
});