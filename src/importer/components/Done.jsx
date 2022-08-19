import InfoPanel from "./InfoPanel";

const Done = (props) => {

	console.log(props)

	return (
        <div>
            <InfoPanel heading="Done!">
			Your import is complete. <a href={props.clickThrough}>Visit your newly created available profiles</a>.
            </InfoPanel>
        </div>
    )
}

export {Done}
export default Done