import { useState, useEffect } from "react"
import { ReactDOM } from "ReactDOM"



import { 
    Button, 
    FormFileUpload, 
    __experimentalHStack as HStack,
    __experimentalSurface as Surface,
    __experimentalSpacer as Spacer,
    __experimentalHeading as Heading,
    Spinner,
    SelectControl
} from '@wordpress/components';

import stage from "./../stages"
import apiFetch from "./../ApiFetch"

import {isUndefined} from "lodash"

import Error from "./Error.jsx"
import InfoPanel from "./InfoPanel.jsx"


import Uploader from "./Uploader.jsx"
import Uploading from "./Uploading.jsx"
import Processing from "./Processing.jsx"
import Importing from "./Importing.jsx"
import Done from "./Done.jsx"



 


const Importer = () => {
  
    let [step, setStep] = useState(stage.UPLOADER);
    let [didInitialStatusCheck, setDidInitialStatusCheck] = useState(false)
    let [uploadProgress, setUploadProgress] = useState(0)

    useEffect(() => {

        if(didInitialStatusCheck){
            return 
        }

        apiFetch( {
            path: '/govpack/v1/import/status',
            method: 'GET',
        } ).then( ( res ) => {
            console.log(res.data.status)
            if(res.data.status === "running"){
                setStep(stage.PROCESSING)
            }
        } );

        setDidInitialStatusCheck(true)

    });

    if(step === stage.UPLOADER){
        return (<Uploader 
            updateStep = {setStep}
            onUploadProgress = {setUploadProgress}
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