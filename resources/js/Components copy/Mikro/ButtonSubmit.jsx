import React from 'react';

function ButtonSubmit({ label }) {
    return (
        <button type="submit" className="btn btn-info px-5">{label}</button>
    );
}

export default ButtonSubmit;