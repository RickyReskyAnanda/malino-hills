import React, { useState } from 'react';
import { EyeIcon, EyeSlashIcon } from '../../Mikro/SVGIcon';

function InputPassword({ title, name, formik, ...props}) {
    const [show, setShow] = useState(false)
    return (
        <div className="form-group">
            <label for="title">{ title }</label>
            <div class="input-group">
                <input
                    name={name}
                    type={show ? 'text':'password'}
                    className={"form-control " +
                    (formik.touched[name || 'file'] && formik.errors[name || 'file']
                        ? " is-invalid border-danger"
                        : "")}
                    value={formik.values[name]}
                    style={{ borderRadius: '0.5rem 0 0 0.5rem' }}
                    {...props}
                />
                <div className='input-group-append' onClick={()=>setShow(!show)}>
                    <span class="input-group-text" style={{ borderRadius: '0 0.5rem 0.5rem 0', borderRight:'1px solid #d2d6da' }}>
                        { show ? <EyeIcon/> : <EyeSlashIcon/> }
                    </span>
                </div>
            </div>
            {formik.touched[name || 'file'] && formik.errors[name || 'file'] && (
                <p className="error text-danger"><small>{formik.errors[name || 'file']}</small></p>
            )}
            
        </div>
    );
}

export default InputPassword;