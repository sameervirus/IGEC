jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        updateSldier();
    };
    function updateSldier() {
        if (typeof window.Flickity !== 'undefined') {
            setTimeout(function () {
                window.pnwt.sections.pnwtOwlCarousel();
            }, 10);
        } else {
			window.pnwt.sections.pnwtOwlCarousel();
        }
    }
    elementorFrontend.hooks.addAction(
        'frontend/element_ready/powernode-reviews-carousel.default',
        addHandler
    );
});