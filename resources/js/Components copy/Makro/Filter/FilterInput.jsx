import React from 'react';

function FilterInput({ title,  onChange, ...props}) {
    return (
        <div className="form-group">
            <label for="title">{ title }</label>
            <input
                className={"form-control"}
                onChange={e=>onChange(e.target)}
                {...props}
            />
        </div>
    );
}

export default FilterInput;