jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        updateGallery();
    };
    function updateGallery() {
        if (typeof window.Flickity !== 'undefined') {
            setTimeout(function () {
                window.pnwt.sections.masonryGrid();
            }, 10);
        } else {
			 setTimeout(function () {
                window.pnwt.sections.masonryGrid();
            }, 400);
        }
    }
    elementorFrontend.hooks.addAction(
        'frontend/element_ready/powernode-gallery.default',
        addHandler
    );
});