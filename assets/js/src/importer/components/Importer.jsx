import { useState } from "react"
import { 
    Button, 
    FormFileUpload, 
    __experimentalHStack as HStack
} from '@wordpress/components';


const Uploader = (props) => {

    let [file, setFile] = useState()

    const onFileChosen = ( event ) => {
        setFile(event.target.files[0])
	};

    const onFilesUpload = (  ) => {

        console.log(file)
        
        /*

		onFilesPreUpload( files );

		let setMedia;
		setMedia = ( [ media ] ) => onSelect( media );
		
		mediaUpload( {
			allowedTypes,
			filesList: files,
			onFileChange: setMedia,
			onError,
		} );

        */
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

const Processing = (props) => {
    return (
        <div>
            Processing
            <Button 
                variant="primary"
                onClick = {() => {
                    console.log("Wut?")
                    props.updateStep(2)
                }}
            >
               Done
            </Button>
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

    let [step, setStep] = useState(0)

    if(step === 0){
        return (<Uploader 
            updateStep = {setStep}
        />)
    }

    if(step === 1){
        return (<Processing 
            updateStep = {setStep}
        />)
    }

    if(step === 2){
        return (<Done />)
    }
    
}
export default Importer
export {Importer}