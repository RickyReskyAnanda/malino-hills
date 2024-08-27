import React, { useContext } from 'react';
import { GlobalContext } from './../../Context/GlobalContext';
import { Link } from 'react-router-dom';

function Breadcrumb() {
    const { breadcrumbs } = useContext(GlobalContext);
    return (
        <nav aria-label="breadcrumb">
            <ol className="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li className="breadcrumb-item text-sm"><Link to="/" className="opacity-5 text-dark" href="javascript:;">Greats</Link></li>
                { breadcrumbs?.path?.length > 0 && breadcrumbs?.path.map((title,i)=>(
                    <li className="breadcrumb-item text-sm text-dark active" aria-current="page">{ title }</li>
                ))}
            </ol>
            <h6 className="font-weight-bolder mb-0">{ breadcrumbs?.title }</h6>
        </nav>

    );
}

export default Breadcrumb;