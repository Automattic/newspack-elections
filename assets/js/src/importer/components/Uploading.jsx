import InfoPanel from "./InfoPanel";

const Uploading = (props) => {
    return (
       <InfoPanel heading="Uploading">
            <progress style={{width:"100%"}} id="upload_progress" max="100" value={props.progress}> {props.progress}% </progress>
        </InfoPanel>
    )
}

export {Uploading}
export default Uploading