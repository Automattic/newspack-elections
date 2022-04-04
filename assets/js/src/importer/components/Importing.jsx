import { useState, useEffect } from "react"
import apiFetch from "./../ApiFetch"
import InfoPanel from "./InfoPanel";
import Error from "./Error";
import stage from "./../stages"

const Importing = (props) => {

    let [importProgress, setImportProgress] = useState(0)
    let [total, setTotal] = useState(0)
    let [done, setDone] = useState(0)

    const Tick = async () => {
        await apiFetch( {
            path: '/govpack/v1/import/progress',
            method: 'GET',
        } ).then( ( res ) => {
			
			let {total, done, todo} = res.data

			total = parseInt(total)
			done = parseInt(done)
			todo = parseInt(todo)

            setImportProgress( (100 / total * done).toFixed(2) )
            setTotal(total)
            setDone(done)

            if(todo === 0){
                props.updateStep(stage.DONE)
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

        console.log("UseEffectCalled")
        Tick();
        timeout = setTimeout( () => {
            Tock(timeout)
        }, 3000)

        return () => { clearTimeout(timeout) }
    }, [timeout] )

    return (
        <div>
            <InfoPanel heading="Importing">
				{ (done === 0) && (
					<p>Your Import have been queued and will start shortly</p>
				) }
                <progress style={{
					width:"100%",
					marginBottom: "1rem",

				}} id="import_progress" max="100" value={importProgress}> {importProgress}% </progress>
                <div>
                    <strong>{importProgress}%</strong> : <em>{done}</em>/<span>{total}</span>
                </div>
            </InfoPanel>
        </div>
    )
}


export default Importing
export {Importing}
