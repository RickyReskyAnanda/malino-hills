import React, { useContext, useEffect, useState } from 'react';
import { GlobalContext } from '../../contexts/GlobalContext';

import Form from './Form';
import Gallery from './Gallery';

function Meeting(props) {
    const { setBreadcrumbs } = useContext(GlobalContext);

    useEffect(()=>{
        setBreadcrumbs({
            path:['Meeting'],
            title:'Meeting',
        })
    },[])


    return (
        <div className="container-fluid py-4">
            <div className="row">
                <div className="col-12">
                    <Form />
                    <Gallery />
                </div>
            </div>
        </div>
    );
}

export default Meeting;