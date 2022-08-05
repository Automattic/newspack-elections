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

    let [importData, setImportData] = useState()
    let [dataSources, setDataSources] = useState({})
    let [selectedSource, setSelectedSource] = useState("")

    const [hasError, setHasError] = useState(false)
    const [errorMessage, setErrorMessage] = useState("")


    const allowed = ["text/csv"]

    // 0 = No
    // 1 = Yes
    // 2 = Doing
    let [loadedSources, setLoadedSources] = useState(0)
    let [isDownloaded, setIsDownloaded] = useState(0)

    let sourceOptions = []
    
    Object.keys(dataSources).forEach( (value, index) => {
        let group = dataSources[value]

        sourceOptions.push({
            value : value,
            label : group.label,
            disabled : true
        })

        Object.keys(group.items).forEach( (key) => {
           sourceOptions.push( {
            value : group.items[key].key,
            label : group.items[key].label,
           })
        })

    } )

    useEffect( () => {

        console.log("useEffect")

        // if datasources has already been set, kill this call - only do once
        if(loadedSources !== 0){
            return
        }
        setLoadedSources(2)

        apiFetch( {
            path: '/govpack/v1/import/sources',
            method: 'GET',

        } ).then( ( res ) => {
            setDataSources(res.data)
            setLoadedSources(1)
        } );

    }, [loadedSources] )

 
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

    const onImport = () => {
        console.log("Import Clicked", selectedSource)
        setIsDownloaded(2)
        apiFetch( {
            path: '/govpack/v1/import/download',
            method: 'POST',
            data: {
                source_file : selectedSource
            }
        } ).then( ( res ) => {
            setIsDownloaded(1)
            props.updateStep(stage.PROCESSING)
        } );e

    }

    const showSpinner = ( (loadedSources === 2 ) || (isDownloaded === 2))
    const showSelector = !showSpinner

    return (
        <>
            <InfoPanel
                heading="Upload Data?"
            >
                <VStack
                      spacing="4"
                >  
                    <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In faucibus elit nec urna imperdiet, ut molestie orci viverra. Fusce interdum rutrum leo. Praesent non pretium purus, vel molestie orci. Cras hendrerit enim non dolor sollicitudin ultricies. 
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
            {/*
            <InfoPanel
                heading = "From GovPack"
            >
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In faucibus elit nec urna imperdiet, ut molestie orci viverra. Fusce interdum rutrum leo. Praesent non pretium purus, vel molestie orci. Cras hendrerit enim non dolor sollicitudin ultricies. 
                </p>

           

                <HStack
                    spacing="4"
                    justify="flex-start"
                >
                    
                    { showSpinner && (
                        <Spinner />
                    )}

                     { showSelector && (
                         <>
                            <SelectControl
                                value = {selectedSource}
                                onChange = {(change) => {
                                    setSelectedSource(change)
                                }}
                                label={'Select some users:'}
                                options = {sourceOptions}
                            >
                            
                            </SelectControl>
                            <Button 
                                isPrimary={true}
                                onClick = {onImport}
                                disabled = {selectedSource ? false : true}
                            >
                                Import
                            </Button>
                        </>
                     )}
                   
                </HStack>

            </InfoPanel>
                            */}
        </>
    )
}


export default Uploader
export {Uploader}