import React, { useEffect, useState } from 'react';
import toastify from './../../../Utils/toastify'
import { getIndex } from '../../../Utils/api';

function SelectApi({  formik, title,  parent, name, url, isNoParent, ...props  }) {

    const [options, setOptions] = useState([])

    useEffect(()=>{
        if((parent !== 'all' && parent !== '') || isNoParent )
            getData()
    },[parent])

    function getData(){
        getIndex(url,{ parent })
        .then(res => {
            if(res?.data)
                setOptions(res?.data || [])
        })
        .catch(err=>{
            toastify({ status: 'ERROR', message: err.message })
        })
    }

    return (
        <div className="form-group">
            <label>{title}</label>
            <select 
                name={name}
                className={"form-control " +
                    (formik.touched[name] && formik.errors[name]
                    ? " is-invalid border-danger"
                    : "form-control-solid")}
                onChange={formik.handleChange}
                onBlur={formik.handleBlur}
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

export default SelectApi;