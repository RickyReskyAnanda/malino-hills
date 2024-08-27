import React from 'react';

function Select({  formik, title,  options, name, ...props  }) {
    return (
        <div className="form-group">
            <label>{title}</label>
            <select 
                name={name}
                className={"form-control " +
                    (formik.touched[name] && formik.errors[name]
                    ? " is-invalid border-danger"
                    : "form-control-solid")}
                value={formik.values[name]}
                {...props}
            >
                <option value="">Pilih {title}</option>
                { options.map((d,i)=> <option key={'options'+name+i} value={d.value}>{d.label}</option>) }
            </select>
            {formik.touched[name] && formik.errors[name] && (
                <p className="error text-danger"><small>{formik.errors[name]}</small></p>
            )}
        </div>
    );
}

export default Select;