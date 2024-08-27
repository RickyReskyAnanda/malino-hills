import React, { useEffect, useState } from 'react';
import toastify from './../../../Utils/toastify'
import { getIndex } from '../../../Utils/api';

function FilterSelectApi({  title,  parent, onChange, url, ...props  }) {

    const [options, setOptions] = useState([])

    useEffect(()=>{
        if(parent !== 'all' && parent !== '')
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
                className={"form-control"}
                {...props}
                onChange={e=>onChange(e.target)}
            >
                <option value="">All {title}</option>
                { options.map((d,i)=> <option key={'options'+props.name+i} value={d.value}>{d.label}</option>) }
            </select>
        </div>
    );
}

export default FilterSelectApi;