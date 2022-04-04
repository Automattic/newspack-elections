import { useState, useEffect } from "react"
import apiFetch from "./../ApiFetch"
import InfoPanel from "./InfoPanel";
import Error from "./Error";
import stage from "./../stages"

const Checking = (props) => {

    return (
        <div>
            <InfoPanel heading="Checking...">
                <>Looking for Imports in Progress..</>
            </InfoPanel>
        </div>
    )
}


export default Checking
export {Checking}
