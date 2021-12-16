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


export default Importing
export {Importing}
