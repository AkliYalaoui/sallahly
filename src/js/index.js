// Toastify
$(document).ready(function ($) {
	setTimeout(function () {
		$('#toast').fadeOut('fast');
	}, 3000);
});

if (window.history.replaceState) {
	window.history.replaceState(null, null, window.location.href);
}
