jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        updatePortfolio();
    };
    function updatePortfolio() {
		
        if (typeof window.Flickity !== 'undefined') {
            setTimeout(function () {
                window.pnwt.sections.pnwtOwlCarousel();
                window.pnwt.sections.masonryGrid();
            }, 2500);
        } else {
			setTimeout(function () {
                window.pnwt.sections.pnwtOwlCarousel();
                window.pnwt.sections.masonryGrid();
            }, 200);
        }
    }
    elementorFrontend.hooks.addAction(
        'frontend/element_ready/powernode-portfolio.default',
        addHandler
    );
});
