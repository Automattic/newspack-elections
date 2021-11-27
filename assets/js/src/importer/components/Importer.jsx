import { useState, useEffect } from "react"
import axios from 'axios';

import { 
    Button, 
    FormFileUpload, 
    __experimentalHStack as HStack,
    __experimentalSurface as Surface,
    __experimentalSpacer as Spacer,
    __experimentalHeading as Heading
} from '@wordpress/components';

import apiFetch from '@wordpress/api-fetch';
import {isUndefined} from "lodash"

const STAGE_UPLOADER = 0
const STAGE_UPLOADING = 1
const STAGE_PROCESSING = 2
const STAGE_IMPORTING = 3
const STAGE_DONE = 4
 
apiFetch.setFetchHandler( ( options ) => {

    const { url, path, data, method, headers } = options;

    return axios( {
        url: url || path,
        method,
        data,
        headers,
        onUploadProgress: function (progressEvent) {
           // console.log(progressEvent)
        }
    } );
    
} );

 
// .5MB Chunk to Upload
const CHUNK_SIZE = 0.5 * 1024 * 1024;

const Uploader = (props) => {

    let [file, setFile] = useState()

    const onFileChosen = ( event ) => {
        setFile(event.target.files[0])
	};

    const onFilesUpload = (  ) => {

        props.updateStep(STAGE_UPLOADING)

        console.log(file)

        let chunks = []
        let number_of_chunks = Math.ceil(file.size / CHUNK_SIZE)
        let current_chunk = 0
        let upload_progress = 0
        let upload_progress_per_chunk = (100 / number_of_chunks)


        console.log("Number of Chunks: ", number_of_chunks)
        
        const createChunk = (start_byte = 0) => {
            let start = start_byte ?? 0
            let end = (start + CHUNK_SIZE)
            let chunk = file.slice(start, end)
            chunks[current_chunk] = chunk
            current_chunk++
        }

        const uploadChunk = (index = 0) => {

            if(isUndefined(chunks[index])){
                return false
            }

            let data = new FormData()
            data.append(
                "blob", chunks[index], file.name
            )

            apiFetch( {
                path: '/wp-json/govpack/v1/upload',
                method: 'POST',
                headers:  {
                    'content-type': 'multipart/form-data',
                    'Content-Range': "bytes "+ (index * CHUNK_SIZE) +"-"+ ((index + 1) * CHUNK_SIZE) + "/"+ file.size
                },
                data: data
            } ).then( ( res ) => {
                upload_progress = upload_progress + upload_progress_per_chunk
                props.onUploadProgress( upload_progress )
                uploadChunk(index + 1)
            } );

        }

        let start = 0
        while(start <= file.size){
            createChunk(start)
            start = (start + CHUNK_SIZE)
        }
        
        uploadChunk()
        props.updateStep(STAGE_PROCESSING)
        
	};


    return (
        <div>
            <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In faucibus elit nec urna imperdiet, ut molestie orci viverra. Fusce interdum rutrum leo. Praesent non pretium purus, vel molestie orci. Cras hendrerit enim non dolor sollicitudin ultricies. 
            </p>

            <HStack
                spacing="4"
                justify="flex-start"
            >
                <FormFileUpload
		            accept="text/xml, text/csv"
                    variant="secondary"
		            onChange={ onFileChosen }
	            >
		            Choose File
	            </FormFileUpload>

                { file && (
                    <>
                        <span>{file.name}</span>
                        <Button 
                            variant="primary"
                            onClick = {onFilesUpload}
                        >
                        Upload
                        </Button>
                    </>
                )}

            </HStack>
        </div>
    )
}

const InfoPanel = (props) => {
    return (
        <Surface>
            <Spacer padding="4">
                <Heading level = "3">
                    {props.heading}
                </Heading>
                <Spacer marginBottom="4" />
                { props.children }
            </Spacer>
        </Surface>
    )
}

const Uploading = (props) => {
    return (
       <InfoPanel heading="Uploading">
            <progress style={{width:"100%"}} id="upload_progress" max="100" value={props.progress}> {props.progress}% </progress>
        </InfoPanel>
    )
}

const Processing = (props) => {

    const Tick = async () => {
        await apiFetch( {
            path: '/wp-json/govpack/v1/import',
            method: 'GET',
        } ).then( ( res ) => {
            
            if(res.data.status === "done"){
                props.updateStep(STAGE_IMPORTING)
            }
        } );
    }

    const Tock = (timeout) => {
        Tick()
        timeout = setTimeout( () => {
            Tock();
        }, 3000)
    }

    let timeout = null
    useEffect(() => {

        if(timeout){
            return;
        }

        console.log("useEffect")
        
        Tick()

        timeout = setTimeout( () => {
            Tock(timeout)
        }, 3000)

        return () => { clearTimeout(timeout) }
    }, [timeout] )



   



    return (
        <div>
            <InfoPanel heading="Processing">
                <p>Reading your file to make sure we can import it</p>
            </InfoPanel>
        </div>
    )
}

const Importing = (props) => {

    let [importProgress, setImportProgress] = useState(0)
    let [total, setTotal] = useState(0)
    let [done, setDone] = useState(0)

    const Tick = async () => {
        await apiFetch( {
            path: '/wp-json/govpack/v1/import/progress',
            method: 'GET',
        } ).then( ( res ) => {
            
            console.log(res.data)
            setImportProgress( 100 / res.data.total * res.data.done)
            setTotal(res.data.total)
            setDone(res.data.done)
        } );
    }

    const Tock = (timeout) => {
        Tick()
        timeout = setTimeout( () => {
            Tock();
        }, 5000)
    }

    let timeout = null
    useEffect(() => {

        if(timeout){
            return;
        }

        console.log("UseEffectCalled")
        Tick();
        timeout = setTimeout( () => {
            Tock(timeout)
        }, 5000)

        return () => { clearTimeout(timeout) }
    }, [timeout] )


    
    
   


    return (
        <div>
            <InfoPanel heading="Importing">
                <progress style={{width:"100%"}} id="import_progress" max="100" value={importProgress}> {importProgress}% </progress>
                <div>
                    <strong>{importProgress}%</strong> : <em>{done}</em> /<span>{total}</span>
                </div>
            </InfoPanel>
        </div>
    )
}

const Done = () => {
    return (
        <div>
            Done!
        </div>
    )
}


const Importer = () => {

    let [step, setStep] = useState(STAGE_PROCESSING)
    let [uploadProgress, setUploadProgress] = useState(0)

    if(step === STAGE_UPLOADER){
        return (<Uploader 
            updateStep = {setStep}
            onUploadProgress = {setUploadProgress}
        />)
    }

    if(step === STAGE_UPLOADING){
        return (<Uploading 
            progress = {uploadProgress}
        />)
    }

    if(step === STAGE_PROCESSING){
        return (<Processing 
            updateStep = {setStep}
        />)
    }

    if(step === STAGE_IMPORTING){
        return (<Importing 
           
        />)
    }

    if(step === STAGE_DONE){
        return (<Done />)
    }
    
}
export default Importer
export {Importer}