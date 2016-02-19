function resizeDataContainer() {
	TYPO3.jQuery('.data-container').css('width','10px');
	TYPO3.jQuery('.data-container').css('max-width', TYPO3.jQuery('.container-fluid').eq(0).width()-20 + 'px');
	TYPO3.jQuery('.data-container').css('width','auto');
}
TYPO3.jQuery(document).ready(function() {
	resizeDataContainer();
});
TYPO3.jQuery(window).resize(debounce(resizeDataContainer, 250));