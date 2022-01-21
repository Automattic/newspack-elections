import { useState, useEffect } from "react"
import apiFetch from "./../ApiFetch"
import InfoPanel from "./InfoPanel";
import stage from "./../stages"

import {isUndefined} from "lodash"

import { 
    Button, 
    FormFileUpload, 
    __experimentalHStack as HStack,
    __experimentalSpacer as Spacer,
    Spinner,
    SelectControl
} from '@wordpress/components';



// .5MB Chunk to Upload
const CHUNK_SIZE = 0.5 * 1024 * 1024;

const Uploader = (props) => {

    let [file, setFile] = useState()
    let [importData, setImportData] = useState()
    let [dataSources, setDataSources] = useState({})
    let [selectedSource, setSelectedSource] = useState("")

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
        setFile(event.target.files[0])
	};

    const onFilesUpload = (  ) => {

        props.updateStep(stage.UPLOADING)

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
                path: '/govpack/v1/upload',
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
        props.updateStep(stage.PROCESSING)
        
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
        } );

    }

    const showSpinner = ( (loadedSources === 2 ) || (isDownloaded === 2))
    const showSelector = !showSpinner

    return (
        <>
            <InfoPanel
                heading="Upload Data"
            >
                <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In faucibus elit nec urna imperdiet, ut molestie orci viverra. Fusce interdum rutrum leo. Praesent non pretium purus, vel molestie orci. Cras hendrerit enim non dolor sollicitudin ultricies. 
                </p>

                <HStack
                    spacing="4"
                    justify="flex-start"
                >
                    <FormFileUpload
                        variant="primary"
                        onChange={ onFileChosen }
                    >
                        Choose File
                    </FormFileUpload>

                    { file && (
                        <>
                            <span>{file.name}</span>
                            <Button 
                                isSecondary={true}
                                onClick = {onFilesUpload}
                            >
                            Upload
                            </Button>
                        </>
                    )}
                </HStack>
            </InfoPanel>
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
        </>
    )
}


export default Uploader
export {Uploader}