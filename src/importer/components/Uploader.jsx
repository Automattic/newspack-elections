import { useState, useEffect } from "react"
import apiFetch from "./../../components/ApiFetch"
import InfoPanel from "./InfoPanel";
import Error from "./../../components/Error";
import stage from "./../stages"

import {isUndefined} from "lodash"

import { 
    Button, 
    FormFileUpload, 
    __experimentalHStack as HStack,
    __experimentalVStack as VStack,
    __experimentalSpacer as Spacer,
    Spinner,
    SelectControl
} from '@wordpress/components';



// .5MB Chunk to Upload
const CHUNK_SIZE = 0.5 * 1024 * 1024;

const Uploader = (props) => {

    const [hasError, setHasError] = useState(false)
    const [errorMessage, setErrorMessage] = useState("")
    const allowed = ["text/csv"]


    const onFileChosen = ( event ) => {

        let file = event.target.files[0]
        
        if(!isUndefined(allowed) && !allowed.includes(file.type)){
            props.setHasError(true)
            props.setErrorMessage(errorCodes['filetype'])
            return false;
        }
        
        props.setFile(file)
	};

    const onFilesUpload = (  ) => {

        const {
			file
		} = props

        let chunks = []
        let number_of_chunks = Math.ceil(file.size / CHUNK_SIZE)
        let current_chunk = 0
        let upload_progress = 0
        let upload_progress_per_chunk = (100 / number_of_chunks)

        const errorCodes = {
            "filetype" : "Sorry, that file type is not supported, please use a CSV"
        }


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
                path: '/govpack/v1/upload',
                method: 'POST',
                headers:  {
                    'content-type': 'multipart/form-data',
                    'Content-Range': "bytes "+ (index * CHUNK_SIZE) +"-"+ ((index + 1) * CHUNK_SIZE) + "/"+ file.size
                },
                data: data
            } ).then( ( res ) => {

                console.log(res)

                if(res.data[0][0].error){
                    setHasError(true)
                    setErrorMessage(res.data[0][0].error)
                    return
                }


                // First Chunk uploaded Successfully so move to upload bar
                if( index === 0 ){
                    props.updateStep(stage.UPLOADING)
                }

                upload_progress = upload_progress + upload_progress_per_chunk
                props.onUploadProgress( upload_progress )
                uploadChunk(index + 1)

                if((index + 1) === chunks.length){
                    props.updateStep(stage.PROCESSING)
                }
                
            } );

        }

        let start = 0
        while(start <= file.size){
            createChunk(start)
            start = (start + CHUNK_SIZE)
        }
        
        uploadChunk()
	};

    return (
        <>
            <InfoPanel
                heading="Upload Data?"
            >
                <VStack
                      spacing="4"
                >  
                    <p>
                    Please select a <code>.csv</code> file that has the same fields as our template. You can <a target="_blank" href="https://bit.ly/3B22gzA">download a copy of that template here</a>. If you need help, please contact <a href="mailto:hello@govpack.org">hello@govpack.org</a>. Your import file doesn’t have to include data for each field, but importing will not function properly if you change the column headers.
                    </p>

                    {props.hasError && (
                        <Error message={props.errorMessage} />
                    )}

                    <HStack  
                        spacing="4"
                        justify="flex-start"
                    >
                        <FormFileUpload
                            variant="primary"
                            isPrimary={true}
                            onChange={ onFileChosen }
                            accept={allowed }
                            disabled = {props.file}
                        >
                            Choose File
                        </FormFileUpload>

                        { props.file && (
                            <>
                                <span
                                    style={{
                                        display : "block",
                                        marginLeft : "0.5rem"
                                    }}
                                >
                                    {props.file.name}
                                </span>
                                <Button 
                                    variant="tertiary"
                                    onClick = { () => {
                                        props.setFile(false)
                                    }}
                                    icon = "no-alt"
                                    iconSize={12}
                                    isSmall = {true}
                                />
                                <Button 
                                    variant="primary"
                                    onClick = {onFilesUpload}
                                    className = {"components-button is-primary"}
                                >
                                Upload
                                </Button>
                            </>
                        )}
                    </HStack>
                </VStack>
            </InfoPanel>
            
        </>
    )
}


export default Uploader
export {Uploader}