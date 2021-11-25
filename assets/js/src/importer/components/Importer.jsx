import { useState } from "react"
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

 
apiFetch.setFetchHandler( ( options ) => {
    const { url, path, data, method } = options;

    return axios( {
        url: url || path,
        method,
        data,
        onUploadProgress: function (progressEvent) {
            console.log(progressEvent)
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

        props.updateStep(1)

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

        let start = 0
        while(start <= file.size){
            createChunk(start)
            start = (start + CHUNK_SIZE)
        }
        
        console.log("chunks: ", chunks)

        let promises = chunks.map( (chunk, index) => {
            // POST
            return apiFetch( {
                path: '/wp-json/govpack/v1/upload',
                method: 'POST',
                data: { 
                    blob : chunk,
                    file_name : file.name
                },
            } ).then( ( res ) => {
                
                upload_progress = upload_progress + upload_progress_per_chunk
                console.log(upload_progress)
                props.onUploadProgress( upload_progress )
            } );
        })

        Promise.all(promises).then( (res) => {
            props.updateStep(2)
        } )

        
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
		            accept="image/*"
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
    return (
        <div>
            <InfoPanel heading="Processing">
                <p>Reading your file to make sure we can import it</p>
            </InfoPanel>
        </div>
    )
}

const Importing = (props) => {

    let [importProgress, setImportProgress] = useState(50)

    return (
        <div>
            <InfoPanel heading="Importing">
                <progress style={{width:"100%"}} id="import_progress" max="100" value={importProgress}> {importProgress}% </progress>
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

    let [step, setStep] = useState(3)
    let [uploadProgress, setUploadProgress] = useState(0)

    if(step === 0){
        return (<Uploader 
            updateStep = {setStep}
            onUploadProgress = {setUploadProgress}
        />)
    }

    if(step === 1){
        return (<Uploading 
            progress = {uploadProgress}
        />)
    }

    if(step === 2){
        return (<Processing 
            updateStep = {setStep}
        />)
    }

    if(step === 3){
        return (<Importing 
           
        />)
    }

    if(step === 4){
        return (<Done />)
    }
    
}
export default Importer
export {Importer}