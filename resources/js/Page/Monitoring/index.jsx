import React, { useEffect, useState, useContext } from 'react';
import Filter from './Filter';
import Datatable from './Datatable';
import DatatableUser from './DatatableUser';
import { getIndex } from '../../Utils/api';
import Paginate from './../../Components/Makro/Filter/Paginate'
import Form from './Form';
import { GlobalContext } from './../../Context/GlobalContext';
import { role } from '../../Contants/usertype';


function Monitoring() {

    const { setBreadcrumbs, authUser } = useContext(GlobalContext);


    const [filter, setFilter] = useState({
        regional: '',
        branch: '',
        cluster: '',
        product: '',
        page: 1,
    })
    const [data, setData] = useState({
        items:[],
        total: 0,
        current_page: 0,
        last_page: 0,
        per_page: 0,
    });


    const [order, setOrder] = useState(null)
    useEffect(()=>{
        setBreadcrumbs({
            path:['Monitoring'],
            title:'Monitoring',
        })
    },[])
    useEffect(()=>{
        getData()
    },[filter])

    function getData(){
        getIndex(`api/monitoring`, filter)
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

    const handleClose = () => {
        setOrder(null)
        getData()
    }

    return (<>
        <div className="container-fluid py-4">
            <div className="row">
                <div className="col-md-12">
                    <div className="card mb-4">
                        <div className="card-body">
                            <Filter onChange={ft => setFilter({...filter, ...ft})}/>
                            
                            { authUser?.role === role?.admin && 
                                <Datatable
                                    data={data}
                                    onEdit={ val => setOrder(val) }
                                    onOrder={(orderData) => setFilter({ ...filter, ...orderData  })}
                                />}
                            { authUser?.role === role?.guest &&
                                <DatatableUser
                                    data={data}
                                    onEdit={ val => setOrder(val) }
                                    onOrder={(orderData) => setFilter({ ...filter, ...orderData  })}
                                />}
                                
                            { data?.last_page > 1 && <Paginate
                                pageCount={data?.last_page || 1}
                                onPageChange={(e) => setFilter({ ...filter, page: e.selected + 1  })}
                               /> }
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Form formValues={order} onClose={handleClose}/>
    </>
    );
}

export default Monitoring;