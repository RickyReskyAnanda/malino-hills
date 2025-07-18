import React from 'react';

function FilterSelect({ title, options, onChange, ...props  }) {

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

export default FilterSelect;