import React, { useContext, useEffect, useState } from 'react';
import Datatable from './Datatable';
import { deleteItem, getIndex } from '../../utils/api';
import { confirm } from '../../utils/sweetalert';
import { Link, useNavigate } from 'react-router-dom';
import toastify from '../../utils/toastify';
import { GlobalContext } from '../../contexts/GlobalContext';
import Paginate from './../../components/Makro/Filter/Paginate'

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
        search: 'all',
        page: 1
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
        <div className="container-fluid py-4">
            <div className="row">
                <div className="col-12">
                    <div className="card mb-4">
                        <div className="card-header pb-0">
                            <div className="row">
                                <div className="col-md-6">
                                    <h6>Experience</h6>
                                </div>
                            </div>
                        </div>
                        <div className="card-body ">
                            <Link to={`/${pathUrl}/add`} className="btn btn-sm btn-info">Add Experience</Link>
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