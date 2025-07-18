import React from 'react';

function InputFile({ title, name, formik, ...props}) {
    return (
        <div className="form-group">
            <label for="title">{ title }</label>
            {props.tint}
            <input
                type="file"
                name={name}
                className={"form-control " +
                    (formik.touched[name || 'file'] && formik.errors[name || 'file']
                        ? " is-invalid border-danger"
                        : "form-control-solid")}
                {...props}
            />
            {formik.touched[name || 'file'] && formik.errors[name || 'file'] && (
                <p className="error text-danger"><small>{formik.errors[name || 'file']}</small></p>
            )}
            
        </div>
    );
}

export default InputFile;