/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */



const baseUri = document.baseURI.replace(/\/developer\/public\/?$/, '');




/**
 * @param {string} url
 * @param {'GET'|'POST'|'PUT'|'DELETE'} method
 * @param {*|FormData} data
 * @param {'text'|'json'} type
 * @param {'json'|'urlencoded'|'multipart'} contentType
 * @param {{[key: string]: string}} additionalHeaders
 */
const AJAX = (url, method, data={}, type='json', contentType='json', additionalHeaders={}) => {
    return new Promise((resolve, reject) => {
        if(!['GET', 'POST', 'PUT', 'DELETE'].includes(method))
            reject('Unknown method');

        if(data === null)
            data = {};

        else if(typeof data !== 'object')
            reject('AJAX\'s data must be object type.');

        const startsWithSlash = url[0] === '/';
        
        if(startsWithSlash || !/^(http)?:?\/?\//.test(url)) {
            url = `${baseUri}${startsWithSlash?'':'/'}${url}`;
        }

        switch(contentType) {
            case 'json': contentType = 'application/json'; break;
            case 'urlencoded': contentType = 'application/x-www-form-urlencoded'; break;
            case 'multipart': contentType = 'multipart/form-data'; break;
        }

        const headers = new Headers();
        headers.append('Accept', 'application/json');
        headers.append('Content-Type', contentType);
        headers.append('Access-Control-Origin', '*');

        for(const hdr in additionalHeaders) {
            headers.append(hdr, additionalHeaders[hdr]);
        }

        /**
         * @var {RequestInit} options
         */
        const options = {
            method: method,
            headers: headers,
            mode: 'cors'
        };

        if(method !== 'GET' && method !== 'DELETE') {
            options.body = data;

            if(!(data instanceof FormData)) {
                try {
                    options.body = JSON.stringify(data);
                }
                catch(e) {
                    console.error('Failed to parse Form Request Data as JSON :', data, e);
                    reject(e);
                }
            }
        }


        return fetch(url, options)
            .then(async response => {
                if(response.status !== 200) {
                    return reject({
                        status: response.status,
                        statusText: response.statusText,
                        url: response.url,
                        headers: headers,
                        resHeaders: response.headers,
                        body: data,
                        response: response.text()
                    });
                }

                const txtResult = await response.text();

                if(type === 'json') {
                    try {
                        const body = JSON.parse(txtResult);

                        if('status' in body && body.status !== 200) {
                            return reject({
                                url,
                                headers,
                                body
                            });
                        }

                        return body;
                    } catch(e) {
                        reject({
                            url,
                            headers,
                            body: {
                                error: 'Failed to parse response as JSON.',
                                response: txtResult
                            }
                        });
                    }
                }

                return txtResult;
            })
            .then(body => resolve({
                url,
                headers,
                body
            }))
            .catch(reject);
    });
};

/**
 * @param {string} url
 * @param {*|FormData} data
 * @param {'text'|'json'} type
 * @param {'json'|'urlencoded'|'multipart'} contentType
 * @param {{[key: string]: string}} additionalHeaders
 */
export const GET = (url, data={}, type='json', contentType='json', additionalHeaders={}) => AJAX(url, 'GET', data, type, contentType, additionalHeaders);
/**
 * @param {string} url
 * @param {*|FormData} data
 * @param {'text'|'json'} type
 * @param {'json'|'urlencoded'|'multipart'} contentType
 * @param {{[key: string]: string}} additionalHeaders
 */
export const POST = (url, data={}, type='json', contentType='json', additionalHeaders={}) => AJAX(url, 'POST', data, type, contentType, additionalHeaders);
/**
 * @param {string} url
 * @param {*|FormData} data
 * @param {'text'|'json'} type
 * @param {'json'|'urlencoded'|'multipart'} contentType
 * @param {{[key: string]: string}} additionalHeaders
 */
export const PUT = (url, data={}, type='json', contentType='json', additionalHeaders={}) => AJAX(url, 'PUT', data, type, contentType, additionalHeaders);
/**
 * @param {string} url
 * @param {*|FormData} data
 * @param {'text'|'json'} type
 * @param {'json'|'urlencoded'|'multipart'} contentType
 * @param {{[key: string]: string}} additionalHeaders
 */
export const DELETE = (url, data={}, type='json', contentType='json', additionalHeaders={}) => AJAX(url, 'DELETE', data, type, contentType, additionalHeaders);