function toggleActionsMenu(id) {
	const wrapper = document.getElementById(`actionsWrapper${id}`);
	wrapper.classList.toggle('open');

	document.querySelectorAll('.custom-actions-wrapper').forEach((el) => {
		if (el.id !== `actionsWrapper${id}`) {
			el.classList.remove('open');
		}
	});
}

window.addEventListener('click', function (e) {
	document.querySelectorAll('.custom-actions-wrapper').forEach(wrapper => {
		if (!wrapper.contains(e.target)) {
			wrapper.classList.remove('open');
		}
	});
});
