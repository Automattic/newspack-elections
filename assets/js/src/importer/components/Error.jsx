const Error = (props) => {
    return (
        <div 
            className="components-notice is-error" 
            style={{
                marginBottom:"1rem",
                marginTop:"0rem",
                marginLeft:0
            }}
        >
            {props.message}
        </div>
    )
}

export {Error}
export default Error