import apiFetch from "@wordpress/api-fetch"
import axios from 'axios';


apiFetch.setFetchHandler( ( options ) => {

    const { url, path, data, method, headers } = options;

    return axios( {
        url: url || path,
        method,
        data,
        headers,
    } );
    
} );

export default apiFetch
export {apiFetch}