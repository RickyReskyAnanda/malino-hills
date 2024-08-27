import React, { useContext, useEffect, useState } from 'react';
import Filter from './Filter';
import Datatable from './Datatable';
import Paginate from '../../Components/Makro/Filter/Paginate'

import { deleteItem, getIndex } from '../../Utils/api';
import { Link, useNavigate } from 'react-router-dom';
import toastify from '../../Utils/toastify';
import { confirm } from '../../Utils/sweetalert';
import { GlobalContext } from '../../Context/GlobalContext';

function Reporting(props) {
    const { setBreadcrumbs } = useContext(GlobalContext);

    useEffect(()=>{
        setBreadcrumbs({
            path:['User Account'],
            title:'User Account',
        })
    },[])

    const navigate = useNavigate()
    const [filter, setFilter] = useState({
        role: '',
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
        getIndex(`api/user-account`, filter)
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
            deleteItem(`api/user-account/${id}`)
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
                    <div class="card">
                        <div class="card-body">
                            
                            <Filter onChange={ft => setFilter({...filter, ...ft})}/>
                            <div className='d-flex w-100'>
                                <Link to="/user-account/add" className="btn btn-sm btn-info">Add User Account</Link>
                            </div>
                            <Datatable
                                data={ data }
                                onEdit={(id) => navigate('/user-account/edit/'+id)}
                                onDelete={(id) => handleDelete(id)}
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

export default Reporting;