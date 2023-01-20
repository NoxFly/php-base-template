/**
 * @copyright Copyrights (C) 2021 - 2023 Dorian Thivolle All rights reserved.
 * @author Dorian Thivolle
 * @since 2021
 */

const $basepath = document.querySelector('[data-basepath]');
const baseUrl = $basepath?.dataset.basepath || window.location.pathname;
delete $basepath.dataset.basepath;

document.body.querySelectorAll('a').forEach(a => {
    const href = a.getAttribute('href');

    if(href) {
        const newHref = baseUrl + ((href[0] === '/')? href : '/' + href);
        a.setAttribute('href', newHref);
    }
});