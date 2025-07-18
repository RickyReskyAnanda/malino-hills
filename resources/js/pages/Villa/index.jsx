import React, { useContext, useEffect, useState } from 'react';
import { deleteItem, getIndex } from '../../utils/api';
import { confirm } from '../../utils/sweetalert';
import { Link, useNavigate } from 'react-router-dom';
import toastify from '../../utils/toastify';
import { GlobalContext } from '../../contexts/GlobalContext';
import CardProductHorizontal from '../../components/Makro/Card/CardProductHorizontal';
import NoDataAvailable from '../../components/Mikro/NoDataAvailable';

const pathUrl = "villa"

export default function Villa(props) {
    const { setBreadcrumbs } = useContext(GlobalContext);

    useEffect(()=>{
        setBreadcrumbs({
            path:['Villa'],
            title:'Villa',
        })
    },[])

    const [filter, setFilter] = useState({
        search: 'all',
        page: 'all'
    })

    const [data, setData] = useState([]);

    useEffect(()=>{
        getData()
    },[filter])

    function getData(){
        getIndex(`api/${pathUrl}`, filter)
        .then(res=>{
            if(res?.data){
                setData(res?.data)
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
handleDelete
    return (
        <div className="container-fluid py-4">
            <div className="row">
                <div className="col-12">
                    <div className="card mb-4">
                        <div className="card-header pb-0">
                            <div className="row">
                                <div className="col-md-6">
                                    <h6>Villa</h6>
                                </div>
                            </div>
                        </div>
                        <div className="card-body ">
                            <Link to={`/${pathUrl}/add`} className="btn btn-sm btn-info">Add Villa</Link>

                            <div className="row row-cols-1 row-cols-md-1 g-3">
                                { data?.length > 0 && data.map((d,i) => (
                                    <div className="col" key={"facility"+i}>
                                        <CardProductHorizontal
                                            url={`/${pathUrl}/edit/${d.id}`}
                                            name={ d.name }
                                            added1={<p className="card-text mb-3 fw-bold">{ 'Harga: '+d.price }</p>}
                                            status={ d.status }
                                            description={ d.short_description }
                                            imageUrl={ d.thumbnail }
                                        />
                                    </div>
                                ))}
                                
                            </div>
                            { data?.length === 0 && <NoDataAvailable/> }
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}