/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

import { GET, POST, PUT, DELETE } from './ajax';

const baseRequestPath = '/api';

const valueChangedEvent = new Event('valueChanged');
const changedEvent = new Event('changed');


document.querySelectorAll('.select').forEach($select => {
	$select.dataset.value = '';
	let oldValue = '';

	const isMultiple = $select.classList.contains('multiple');

	const text = $select.innerText.split('\n');

	const defaultLabel = text.splice(0, 1)[0].trim();
	const $oldOptions = $select.querySelectorAll('opt');

	$select.innerHTML = '';

	const $defaultLabel = document.createElement('span');
	$defaultLabel.innerText = defaultLabel;


	const $options = document.createElement('div');

	let $selected;

	for(const $opt of $oldOptions) {
		$opt.innerText = $opt.innerText.trim();
		$opt.setAttribute('title', $opt.innerText);
		$options.append($opt);

		if($opt.hasAttribute('data-selected')) {
			$selected = $opt;
		}
	}

	$select.append($defaultLabel, $options);


	$defaultLabel.addEventListener('click', () => {
		$select.classList.toggle('focus');

		if(!$select.classList.contains('focus')) {
			if(isMultiple && $select.dataset.value !== oldValue) {
				oldValue = $select.dataset.value;
				$select.dispatchEvent(changedEvent);
			}
		}
	});

	$options.addEventListener('click', e => {
		/** @type {HTMLDivElement} */
		const $option = e.target;

		const label = $option.textContent;
		const value = $option.dataset.value?? label;

		if(isMultiple) {
			if(value === '*') {
				$select.dataset.value = value;
				$defaultLabel.innerText = defaultLabel;
	
				$options.querySelectorAll('opt.selected').forEach($opt => $opt.classList.remove('selected'));
				$option.classList.add('selected');
			}
			else {
				if($select.dataset.value === '*') {
					$options.querySelector('opt.selected')?.classList.remove('selected');
				}

				$option.classList.toggle('selected');
				
				const values = [...$options.querySelectorAll('opt.selected')]
					.map($el => $el.dataset.value?? $el.innerText)
					.join(';');

				$select.dataset.value = values;
			}

			$select.dispatchEvent(valueChangedEvent);
		}
		else {
			if(value !== $select.dataset.value) {
				$defaultLabel.innerText = label;
				$select.dataset.value = value;

				$select.dispatchEvent(valueChangedEvent);
				$select.dispatchEvent(changedEvent);
			}

			$select.classList.remove('focus');
		}
	}, false);

	$selected?.click();
});

document.querySelectorAll('.switch-1').forEach($switch => {
	$switch.dataset.value = "";

	$switch.addEventListener('click', e => {
		/** @type {HTMLInputElement} */
		const $input = e.target;

		const $tab = $input.parentNode;

		if($tab.classList.contains('active')) {
			return;
		}

		$switch.querySelector('.active')?.classList.remove('active');
		$tab.classList.add('active');

		$switch.dataset.value = $input.value;

		$switch.dispatchEvent(valueChangedEvent);
	}, false);
});

document.querySelectorAll('details').forEach($details => {
	$details.querySelector('summary').addEventListener('click', () => {
		const $opened = document.querySelector('details[open]');

		if($opened && $opened !== $details) {
			$opened.removeAttribute('open');
		}
	});
});

document.querySelectorAll('.endpoint').forEach($endpoint => {
	const $execBtn = $endpoint.querySelector('.exec-req');
	const $form = $endpoint.querySelector('form');
	const path = $endpoint.querySelector('summary .path')?.textContent;
	const $parameters = $form.querySelectorAll('.param-row.api-param');

	const $apiUri = $endpoint.querySelector('.api-uri .inner a');
	const $reqHdrs = $endpoint.querySelector('.request-headers .inner pre');
	const $resBdy = $endpoint.querySelector('.response-body .inner pre');

	const $rightInner = $endpoint.querySelector('.right-column .inner');
	const $bodyList = $rightInner?.querySelector('.body-list');

	const $selectMethod = $form.querySelector('.param-row.api-method .select.method-tabs');

	const $responseWrapper = $endpoint.querySelector('.response-wrapper');

	const $reqTime = $endpoint.querySelector('.req-time');

	$selectMethod.addEventListener('changed', () => {
		if($selectMethod.dataset.value === 'GET' || $selectMethod.dataset.value === 'DELETE') {
			$rightInner?.classList.add('hidden');
		}
		else {
			$rightInner?.classList.remove('hidden');
		}
	});

	$rightInner.querySelector('.add-param')?.addEventListener('click', () => {
		const $param = document.createElement('div');
		$param.classList.add('param-row', 'api-body');

		const $keyIpt = document.createElement('input');
		$keyIpt.setAttribute('type', 'text');
		$keyIpt.setAttribute('placeholder', 'key');
		$keyIpt.classList.add('body-key');

		const $valueIpt = document.createElement('input');
		$valueIpt.setAttribute('type', 'text');
		$valueIpt.setAttribute('placeholder', 'value');
		$valueIpt.classList.add('body-value');

		const $deleteBtn = document.createElement('button');
		$deleteBtn.classList.add('delete-param');

		$deleteBtn.addEventListener('click', () => {
			$param.remove();
		});

		$param.append($keyIpt, $valueIpt, $deleteBtn);

		$bodyList.append($param);
	});
	
	

	$form?.addEventListener('submit', async e => {
		e.preventDefault();

		if($execBtn.hasAttribute('disabled')) {
			return;
		}

		$execBtn.setAttribute('disabled', true);

		const obj = {
			method: $selectMethod.dataset.value.trim(),
			path: baseRequestPath + path,
			body: {},
			headers: {},
			token: $form.querySelector('.param-row.api-token input').value.trim(),
			tokenLocation: $form.querySelector('.token-location input:checked')?.value
		};


		$parameters.forEach($param => {
			const key = $param.querySelector('label .param-name').innerText.trim();
			const value = $param.querySelector('input').value;

			const reg = new RegExp(`{${key}}`);

			obj.path = obj.path.replace(reg, value);
		});

		if(obj.method !== 'GET' && obj.method !== 'DELETE') {
			$bodyList.querySelectorAll('.param-row.api-body').forEach($param => {
				const key = $param.querySelector('.body-key').value.trim();
				const value = $param.querySelector('.body-value').value;

				if(key?.length > 0) {
					obj.body[key] = value;
				}
			});
		}

		if(obj.token.length > 0) {
			if(obj.tokenLocation === 'query') {
				obj.path += '?api_key=' + obj.token;
			}
			else if(obj.tokenLocation === 'header') {
				obj.headers['X-Auth-Token'] = obj.token;
			}
		}

		let ajax = null;

		switch(obj.method) {
			case 'GET': 	ajax = GET; break;
			case 'POST': 	ajax = POST; break;
			case 'PUT': 	ajax = PUT; break;
			case 'DELETE': 	ajax = DELETE; break;
		}

		if(ajax) {
			let res = {};

			const t0 = Date.now();
			let t1 = 0;
			
			try {
				res = await ajax(obj.path, obj.body, 'json', 'json', obj.headers);
				t1 = Date.now();
			}
			catch(e) {
				t1 = Date.now();

				res = e;

				if(res.body && res.body.response && res.body.response.indexOf('<table class=') > -1) {
					const parser = new DOMParser();
					let html = parser.parseFromString(res.body.response, 'text/html').querySelector('table');
					let content = [];

					html.querySelectorAll('table tr').forEach(($tr, i) => {
						if(i === 0) {
							$tr.querySelector('span')?.remove();
							content.push($tr.innerText.trim().replace(/\\/g, '/'));
						}
						else if(i > 3) {
							content.push($tr.children.item(4).innerText.trim().replace(/\.+\\/g, ''));
						}
					});
					
					res.body.response = content;
				}
			}
			finally {
				const uri = res.url?? obj.path;
				const headers = Object.fromEntries((res.headers?? new Headers()).entries());
				const body = JSON.stringify(res.body?? '{}', null, 2);

				$reqTime.innerText = 'Request executed in ' + (t1 - t0) + ' ms';

				$apiUri.href = uri;
				$apiUri.innerText = uri;

				$reqHdrs.innerText = JSON.stringify(headers, null, 2);
				$resBdy.innerText = body;

				if($responseWrapper.classList.contains('hidden')) {
					$responseWrapper.classList.remove('hidden');
				}
			}
		}

		$execBtn.removeAttribute('disabled');
	});
}, false);