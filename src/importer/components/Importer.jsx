import { useState, useEffect } from "react"



import stage from "./../stages"
import apiFetch from "./../ApiFetch"

import Checking from "./Checking.jsx"
import Uploader from "./Uploader.jsx"
import Uploading from "./Uploading.jsx"
import Processing from "./Processing.jsx"
import Importing from "./Importing.jsx"
import Done from "./Done.jsx"


import api from "@wordpress/api"
 


const Importer = () => {
  
    let [step, setStep] = useState(stage.UPLOADER);
    let [didInitialStatusCheck, setDidInitialStatusCheck] = useState(false)
    let [uploadProgress, setUploadProgress] = useState(0)

	const [hasError, setHasError] = useState(false)
    const [errorMessage, setErrorMessage] = useState("")

	let [file, setFile] = useState()

    useEffect(() => {

        if(didInitialStatusCheck){
            return 
        }

        apiFetch( {
            path: '/govpack/v1/import/status',
            method: 'GET',
        } ).then( ( res ) => {
            if(res.data.status === "running"){
                setStep(stage.IMPORTING)
            }
			setDidInitialStatusCheck(true)
        } );

        

    });

	if(!didInitialStatusCheck){
		return (
			<Checking />
		) 
	}

    if(step === stage.UPLOADER){
        return (<Uploader 
            updateStep = {setStep}
            onUploadProgress = {setUploadProgress}
			hasError = {hasError}
			errorMessage = {errorMessage}
			file = {file}
			setFile = {setFile}
        />)
    }

    if(step === stage.UPLOADING){
        return (<Uploading 
            progress = {uploadProgress}
        />)
    }

    if(step === stage.PROCESSING){
        return (<Processing 
            updateStep = {setStep}
			setErrorMessage = {setErrorMessage}
			setHasError = {setHasError}
        />)
    }

    if(step === stage.IMPORTING){
        return (<Importing 
            updateStep = {setStep}
        />)
    }

    if(step === stage.DONE){
        return (<Done />)
    }
    
}


export default Importer
export {Importer}