import { 
    __experimentalSpacer as Spacer,
    __experimentalHeading as Heading,
} from '@wordpress/components';


const InfoPanel = (props) => {
    return (
        <div style={{  
            "backgroundColor" : "#fff",
            padding: "1rem",
            marginBottom : "1rem"
        }} >  
            <Spacer padding="4">
                <Heading level = "3">
                    {props.heading}
                </Heading>
                <Spacer marginBottom="4" />
                { props.children }
            </Spacer>
        </div>
    )
}

export {InfoPanel}
export default InfoPanel