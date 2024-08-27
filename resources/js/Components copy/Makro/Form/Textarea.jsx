import React from 'react';

function Textarea({ title, name, formik, ...props}) {
    return (
        <div className="form-group">
            <label for="title">{ title }</label>
            <textarea
                name={name}
                className={"form-control " +
                    (formik.touched[name] && formik.errors[name]
                        ? " is-invalid border-danger"
                        : "form-control-solid")}
                value={formik.values[name]}
                {...props}
            ></textarea>
            {formik.touched[name] && formik.errors[name] && (
                <p className="error text-danger"><small>{formik.errors[name]}</small></p>
            )}
            
        </div>
    );
}

export default Textarea;