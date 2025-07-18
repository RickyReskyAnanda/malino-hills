import React, { useContext, useEffect, useState } from 'react';
import Datatable from './Datatable';
import { deleteItem, getIndex } from '../../Utils/api';
import { confirm } from '../../Utils/sweetalert';
import { Link, useNavigate } from 'react-router-dom';
import toastify from '../../Utils/toastify';
import { GlobalContext } from '../../Context/GlobalContext';
import Paginate from './../../Components/Makro/Filter/Paginate'

const pathUrl = "experience"

function UploadKV(props) {
    const { setBreadcrumbs } = useContext(GlobalContext);

    useEffect(()=>{
        setBreadcrumbs({
            path:['Experience'],
            title:'Experience',
        })
    },[])

    const navigate = useNavigate()
    const [filter, setFilter] = useState({
        // regional: 'all',
        // branch: 'all',
        // cluster: 'all',
        // regional: 'all'
    })
    const [data, setData] = useState({
        items:[],
        total: 0,
        current_page: 0,
        last_page: 0,
        per_page: 0,
    });

    useEffect(()=>{
        getData()
    },[filter])

    function getData(){
        getIndex(`api/${pathUrl}`, filter)
        .then(res=>{
            if(res?.data){
                setData({
                    items: res?.data,
                    current_page: res?.meta?.current_page || 0,
                    last_page: res?.meta?.last_page || 0,
                    per_page: res?.meta?.per_page || 0,
                    total: res?.meta?.total || 0,
                })
            }
        })
        .catch(err=>{
            console.log(err)
        })
    }

    const handleDelete = (id)=>{
        confirm(()=>{
            deleteItem(`api/${pathUrl}/${id}`)
            .then(res=>{
                toastify(res)
                getData()
            })
            .catch(err=>{
                toastify({ status: 'ERROR', message: err.message })
            })
        })
    }

    return (
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>List KV</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body ">
                            <Link to="/${pathUrl}/add" class="btn btn-sm btn-info">Upload KV</Link>
                            <Datatable
                                data={ data }
                                onEdit={id=>navigate(`/${pathUrl}/edit/${id}`)}
                                onDelete={id => handleDelete(id)}
                                onOrder={(orderData) => setFilter({ ...filter, ...orderData  })}
                            />

                            { data?.last_page > 1 && <Paginate
                                pageCount={data?.last_page || 1}
                                onPageChange={(e) => setFilter({ ...filter, page: e.selected + 1  })}
                            /> }
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default UploadKV;