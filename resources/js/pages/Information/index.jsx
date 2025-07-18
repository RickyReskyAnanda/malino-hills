import React, { useContext, useEffect, useState } from 'react';
import { GlobalContext } from '../../contexts/GlobalContext';

import InfoContact from './InfoContact';
import InfoLocation from './InfoLocation';
import InfoSocmed from './InfoSocMed';

function Information(props) {
    const { setBreadcrumbs } = useContext(GlobalContext);

    useEffect(()=>{
        setBreadcrumbs({
            path:['Information'],
            title:'Information',
        })
    },[])


    return (
        <div className="container-fluid py-4">
            <div className="row">
                <div className="col-12">
                    <InfoContact />
                    <InfoLocation />
                    <InfoSocmed />
                </div>
            </div>
        </div>
    );
}

export default Information;