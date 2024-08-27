import React, { useContext, useEffect, useState } from 'react';
import {
    getIndex,
} from './../../Utils/api'
import SplineChart from '../../Components/Makro/Chart/SplineChart';
import { GlobalContext } from '../../Context/GlobalContext';


function Dashboard(props) {
    const { setBreadcrumbs } = useContext(GlobalContext);

    const [data_card, set_data_card] = useState(null)
    const [chart_data, set_chart_data] = useState(null)
    const [categories, setCategories] = useState(null)
    
    useEffect(()=>{
        getData()

        setBreadcrumbs({
            path:['Dashboard'],
            title:'Dashboard',
        })
    },[])

    function getData(){
        getIndex("api/dashboard")
        .then(res=>{
            if(res?.data?.data_card) set_data_card(res?.data?.data_card || null)
            if(res?.data?.chart_data){
            setCategories(res?.data?.chart_data.map(item => item.type_posmat))
            const chart_data = [
                    {
                        name: "Total",
                        data: res?.data?.chart_data.map(item => item.total),
                        type: 'line'
                    },
                    {
                        name: 'Delivery',
                        data: res?.data?.chart_data.map(item => item.delivery),
                        type: 'line'
                    },
                    
                ]

                set_chart_data(chart_data)
            }


        })
        .catch(err=>{
            console.log(err)
        })
    }

    return (
        <div className="container-fluid py-4">
            <div className="row">
                <div className="col-md-12 mb-4">
                <div className="row">
                    <div className="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                    <div className="card">
                        <div className="card-body p-3">
                        <div className="row">
                            <div className="col-8">
                            <div className="numbers">
                                <p className="text-sm mb-0 text-capitalize font-weight-bold">Total Order</p>
                                <h5 className="font-weight-bolder mb-0">
                                { data_card?.total || 0 }
                                </h5>
                            </div>
                            </div>
                            <div className="col-4 text-end">
                            <div className="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i className="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div className="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                    <div className="card">
                        <div className="card-body p-3">
                        <div className="row">
                            <div className="col-8">
                            <div className="numbers">
                                <p className="text-sm mb-0 text-capitalize font-weight-bold">Total Delivery</p>
                                <h5 className="font-weight-bolder mb-0">
                                    { data_card?.delivery || 0 }
                                </h5>
                            </div>
                            </div>
                            <div className="col-4 text-end">
                            <div className="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i className="ni ni-box-2 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <div className="col-md-12">
                    <div className="card mb-3">
                        <div className="card-body p-3">
                            <div className="chart">
                                <SplineChart
                                    title={""}
                                    data={chart_data}
                                    category={categories}
                                />
                            </div>
                        </div>
                    </div>
                </div>  
                
            </div>  
        </div>
    );
}

export default Dashboard;