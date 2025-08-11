document.addEventListener('DOMContentLoaded', () => {
	const btnHomologar = document.getElementById('btnHomologarMultipla');
	const confirmarModalEl = document.getElementById('confirmarHomologacaoModal');
	const confirmarModal = new bootstrap.Modal(confirmarModalEl);
	const resultadoModalEl = document.getElementById('resultadoHomologacaoModal');
	const resultadoModal = resultadoModalEl ? new bootstrap.Modal(resultadoModalEl) : null;

	let btnConfirmar = document.getElementById('btnConfirmarHomologacao');
	const listaConfirmar = document.getElementById('listaConfirmarHomologacao');

	function toggleButton() {
		const checkboxes = document.querySelectorAll('.resposta-checkbox:checked');
		const textoBotao = document.getElementById('textoBotaoHomologar');
		const btnHomologar = document.getElementById('btnHomologarMultipla');

		if (checkboxes.length === 0) {
			btnHomologar.disabled = true;
			btnHomologar.classList.remove('footer-success');
			textoBotao.textContent = 'Marque a caixa para selecionar providências';
		} else {
			btnHomologar.disabled = false;
			btnHomologar.classList.add('footer-success');
			textoBotao.textContent = 'Homologar selecionadas';
		}
	}

	function getRowData(checkbox) {
		const row = checkbox.closest('tr');
		return {
			id: checkbox.value,
			usuario: row.cells[1].textContent.trim(),
			unidade: row.cells[2].textContent.trim(),
			monitoramento: row.cells[3].textContent.trim().substring(0, 50) + '...',
			providencia: row.cells[4].textContent.trim().substring(0, 50) + '...'
		};
	}

	document.addEventListener('change', (event) => {
		if (event.target.classList.contains('resposta-checkbox')) {
			toggleButton();
		}
	});

	toggleButton();

	btnHomologar.addEventListener('click', (event) => {
		event.preventDefault();

		const checkboxes = document.querySelectorAll('.resposta-checkbox:checked');
		const selectedItems = Array.from(checkboxes).map(checkbox => getRowData(checkbox));

		if (selectedItems.length === 0) {
			alert('Selecione ao menos uma resposta para homologar.');
			return;
		}

		listaConfirmar.innerHTML = `
				<div class="list-group">
					${selectedItems.map((item, index) => `
						<div class="list-group-item" style="background-color: ${index % 2 === 0 ? '#f2f2f2' : '#fff'};">
							<div><strong>Usuário:</strong> ${item.usuario}</div>
							<div><strong>Unidade:</strong> ${item.unidade}</div>
							<div><strong>Monitoramento:</strong> ${item.monitoramento}</div>
						</div>
					`).join('')}
				</div>
				<div class="mt-3 text-center"><strong>Total:</strong> ${selectedItems.length} item(s) selecionado(s)</div>
			`;

		confirmarModal.show();

		const newBtnConfirmar = btnConfirmar.cloneNode(true);
		btnConfirmar.replaceWith(newBtnConfirmar);
		btnConfirmar = newBtnConfirmar;

		btnConfirmar.addEventListener('click', async () => {
			confirmarModal.hide();

			try {
				const token = document.querySelector('meta[name="csrf-token"]').content;
				const selectedIds = selectedItems.map(item => item.id);

				const response = await fetch(window.ROTA_HOMOLOGAR_MULTIPLA, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
						'X-CSRF-TOKEN': token,
						'Accept': 'application/json'
					},
					body: JSON.stringify({ respostas_ids: selectedIds })
				});

				if (!response.ok) {
					throw new Error(`Erro HTTP: ${response.status}`);
				}

				const data = await response.json();

				if (resultadoModal) {
					let homologadasHTML = '<h5 class="text-success">Homologadas com sucesso</h5>';
					let naoHomologadasHTML = '<h5 class="text-danger mt-4">Não homologadas</h5>';

					if (data.homologadas && data.homologadas.length > 0) {
						homologadasHTML += `
							<div class="list-group">
								${data.homologadas.map(id => {
							const item = selectedItems.find(i => i.id == id);

							return item ? `
									<div class="list-group-item list-group-item-success">
										<div><strong>Usuário:</strong> ${item.usuario}</div>
										<div><strong>Unidade:</strong> ${item.unidade}</div>
									</div>
								` : '';
						}).join('')}
							</div>

							<div class="text-end mt-2">Total: ${data.homologadas.length}</div>
							`;
					} else {
						homologadasHTML += '<p>Nenhuma resposta foi homologada.</p>';
					}

					if (data.nao_homologadas && data.nao_homologadas.length > 0) {
						naoHomologadasHTML += `
								<div class="list-group">
									${data.nao_homologadas.map(item => {
							const originalItem = selectedItems.find(i => i.id == item.id);
							return originalItem ? `
									<div class="list-group-item list-group-item-danger">
										<div><strong>Usuário:</strong> ${originalItem.usuario}</div>
										<div><strong>Unidade:</strong> ${originalItem.unidade}</div>
										<div class="text-danger"><strong>Motivo:</strong> ${item.motivo || 'Não especificado'}</div>
									</div>
								` : '';
						}).join('')}
								</div>

								<div class="text-end mt-2">Total: ${data.nao_homologadas.length}</div>
								`;
					} else {
						naoHomologadasHTML = '';
					}

					const listaHomologadas = document.getElementById('listaHomologadas');
					const listaNaoHomologadas = document.getElementById('listaNaoHomologadas');

					if (listaHomologadas) listaHomologadas.innerHTML = homologadasHTML;
					if (listaNaoHomologadas) listaNaoHomologadas.innerHTML = naoHomologadasHTML;

					resultadoModal.show();
				}

				checkboxes.forEach(cb => cb.checked = false);
				toggleButton();

				setTimeout(() => window.location.reload(), 3000);

			} catch (error) {
				console.error('Erro na homologação:', error);
				alert(`Falha na homologação: ${error.message}`);
			}
		});
	});

	document.getElementById('selecionarTodasCheckbox').addEventListener('click', () => {
		const allCheckboxes = document.querySelectorAll('.resposta-checkbox');
		const allChecked = Array.from(allCheckboxes).every(checkbox => checkbox.checked);

		allCheckboxes.forEach(checkbox => {
			if (!checkbox.disabled) {
				checkbox.checked = !allChecked;
			}
		});

		toggleButton();
	});

	const selectAllCheckbox = document.getElementById('selectAllCheckbox');
	selectAllCheckbox.addEventListener('change', () => {
		const allCheckboxes = document.querySelectorAll('.resposta-checkbox');
		allCheckboxes.forEach(checkbox => {
			if (!checkbox.disabled) {
				checkbox.checked = selectAllCheckbox.checked;
			}
		});
		toggleButton();
	});
});
