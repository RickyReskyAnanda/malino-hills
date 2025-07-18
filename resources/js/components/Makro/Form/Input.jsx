import React from 'react';

function Input({ title, name, formik, ...props}) {
    return (
        <div className="form-group">
            <label for="title">{ title }</label>
            <input
                name={name}
                className={"form-control rounded-1 " +
                    (formik?.touched[name || 'file'] && formik?.errors[name || 'file']
                        ? " is-invalid border-danger"
                        : "form-control-solid")}
                value={formik?.values[name]}
                {...props}
            />
            {formik?.touched[name || 'file'] && formik?.errors[name || 'file'] && (
                <p className="error text-danger"><small>{formik.errors[name || 'file']}</small></p>
            )}
            
        </div>
    );
}

export default Input;