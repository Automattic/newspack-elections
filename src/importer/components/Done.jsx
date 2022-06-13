import InfoPanel from "./InfoPanel";

const Done = () => {

	console.log(wp.data.select('core'))
	return (
        <div>
            <InfoPanel heading="Done!">
			Your import is complete. <a href="#">Visit your newly created available profiles</a>.
            </InfoPanel>
        </div>
    )
}

export {Done}
export default Done