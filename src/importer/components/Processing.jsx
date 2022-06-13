import { useState, useEffect } from "react"
import apiFetch from "./../ApiFetch"
import InfoPanel from "./InfoPanel";
import Error from "./Error";
import stage from "./../stages"

const Processing = (props) => {

	const [hasError, setHasError] = useState(false)
    const [errorMessage, setErrorMessage] = useState("")

    let timeout = null

    const Tick = async () => {
        await apiFetch( {
            path: '/govpack/v1/import',
            method: 'GET',
        } ).then( ( res ) => {  
            
            if(res.data.status === "running"){
                props.updateStep(stage.IMPORTING)
            }

        } ).catch(( error, res ) => {
            console.log(error)
            props.setHasError(true)
            props.setErrorMessage(error.response.data.message)
			props.updateStep(stage.UPLOADER)

        })
    }

    const Tock = (timeout) => {
        Tick()
        timeout = setTimeout( () => {
            Tock();
        }, 3000)
    }

     /*
        If something causes an error to be set, stop the fetch api from checking over and over
    */
    useEffect(() => {

        // if timeout already set then skip this
        if(timeout){
            return;
        }

        // if twe've encoutered an erro stop any subsequent calls to the useEffect starting it again
        if(hasError){
            return 
        }

        // Run the initial Test to see if the importer is running
        Tick()

         // rerun the test every few seconds
        timeout = setTimeout( () => {
            Tock(timeout)
        }, 3000)

        // need to clear up the timeout and stop it once the component unmounts
        return () => { clearTimeout(timeout) }

    }, [timeout, hasError] )

    /*
        If something causes an error to be set, stop the fetch api from checking over and over
    */
    useEffect(() => {
        clearTimeout(timeout)
    }, [hasError]);

    return (
        <div>
            <InfoPanel heading="Processing">
                <p>Reading your file to make sure we can import it</p>
            </InfoPanel>
        </div>
    )
}

export default Processing
export {Processing}