import React from 'react';

function ButtonSubmit({ label, disabled }) {
    return (
        <button type="submit" className="btn btn-info px-5" disabled={disabled}>{label}</button>
    );
}

export default ButtonSubmit;