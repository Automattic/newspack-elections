import { Button } from '@wordpress/components';
import { useState } from 'react';
import {apiFetch} from "./../../components/ApiFetch"
import {Error} from "./../../components/Error"

export const Exporter = () => {

	const [isRunning, setIsRunning] = useState(false)
	const [hasError, setHasError] = useState(false)
	const [error, setError] = useState(null)

	const DownloadFile = (blob) => {
		const url = window.URL.createObjectURL(
			new Blob([blob]),
		  );
		  const link = document.createElement('a');
		  link.href = url;
		  link.setAttribute(
			'download',
			'govpack-export.csv',
		  );
	  
		  // Append to html link element page
		  document.body.appendChild(link);
	  
		  // Start download
		  link.click();
	  
		  // Clean up and remove the link
		  link.parentNode.removeChild(link);
	}

	const getCSV = async () => {
		setIsRunning(true)
		try {
			await apiFetch( {
            	path: '/govpack/v1/export',
            	method: 'GET',

        	} ).then( ( res ) => {
				console.log(res)
            	setIsRunning(false)
				DownloadFile(res.data)
				
        	} );

		} catch(err) {
			setIsRunning(false)
			setHasError(true)
			setError(err.message)
			console.log(err)
		}

	}

	return (
		<>
		{ hasError && (<Error message={error} />) }
		<Button
			 variant="primary"
			 onClick = { getCSV }
			 className = {"components-button is-primary"}
			 isBusy = {isRunning}
		>
			{ isRunning ? "Exporting Now" : "Start Export"}
		</Button>
		</>
	)
	}

export default Exporter