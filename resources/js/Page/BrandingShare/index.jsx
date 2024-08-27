import React, { useContext, useEffect, useState } from 'react';
import { GlobalContext } from '../../Context/GlobalContext';
import Filter from './Filter';
import { Link } from 'react-router-dom';
import { getIndex } from '../../Utils/api';
import Datatable from './Datatable';
function BrandingShare(props) {
    const { setBreadcrumbs } = useContext(GlobalContext);
    const [filter, setFilter] = useState({})
    const [data, setData] = useState([])



    useEffect(()=>{
        setBreadcrumbs({
            path:['Branding Share'],
            title:'Branding Share',
        })
    },[])

    useEffect(()=>{
        if(filter?.month)
        getData()
    },[filter])
    function getData(){
        getIndex('api/branding-share',filter).then(res=>{
            if(res?.code === 200)
            setData(res?.data)
        }).catch(err=>{

        })
    }


    
    return (
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body px-3 py-1">
                            <Filter onChange={(ft) => setFilter({...filter,...ft})} />
                            <div className='d-flex gap-2'>
                                <Link to={"/branding-share/add"} className='btn btn-sm btn-info'>Upload</Link>
                                <a href={document.querySelector('meta[name="base-url"]').getAttribute('content') + '/api/branding-share/download'+ (filter?.month ? '?'+(new URLSearchParams(filter)).toString() : '')} className='btn btn-sm btn-success'>Download</a>
                            </div>
                            <Datatable data={data}/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default BrandingShare;