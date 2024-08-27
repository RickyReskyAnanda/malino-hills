import { useFormik } from 'formik';
import React, { useContext, useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { postItemWithFile } from '../../Utils/api';
import Select from './../../Components/Makro/Form/Select'
import SelectApi from './../../Components/Makro/Form/SelectApi'
import Input from './../../Components/Makro/Form/Input'
import Textarea from './../../Components/Makro/Form/Textarea'
import toastify from '../../Utils/toastify';
import { createSchema } from './../../Schemas/OrderSchema'
import { GlobalContext } from '../../Context/GlobalContext';

function Order(props) {

    const { setBreadcrumbs } = useContext(GlobalContext);

    useEffect(()=>{
        setBreadcrumbs({
            path:['Order'],
            title:'Order',
        })
    },[])

    const [isLoading, setIsLoading] = useState(false)
    const navigate = useNavigate()

    const formik = useFormik({
        initialValues: {
            'regional': '',
            'branch': '',
            'cluster': '',
            'type_posmat': '',
            'product': '',
            'qty': '',
            'alamat': '',
            'due_date': '',
        },
        validationSchema: createSchema,
        onSubmit: values => {
            setIsLoading(true)
            
            postItemWithFile('api/order', values)
            .then(res => {
                setIsLoading(false)
                toastify(res)
                if(res.code === 200){
                    formik.resetForm()
                }
            })


            .catch(err => {
                setIsLoading(false)
                toastify(err)
            });
        },
    });
    return (
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-2 mx-3 mt-3">
                            <h6>Order</h6>
                        </div>
                        <form className="form" onSubmit={formik.handleSubmit}>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <Select
                                            title="Regional"
                                            name="regional"
                                            options={[
                                                {value:'KALIMANTAN', label: 'KALIMANTAN'},
                                                {value:'SULAWESI', label: 'SULAWESI'},
                                                {value:'PUMA', label: 'PUMA'},
                                            ]}
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading} 
                                        />
                                    </div>                            
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <SelectApi
                                            title="Branch"
                                            name="branch"
                                            parent={ formik.values.regional }
                                            url={ `api/filter/branches` }
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading} 
                                        />
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <SelectApi
                                            title="Cluster"
                                            name="cluster"
                                            parent={ formik.values.branch }
                                            url={ `api/filter/clusters` }
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading} 
                                        />
                                    </div>
                                    
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <Select
                                            title="Type Posmat"
                                            name="type_posmat"
                                            options={[
                                                {value:'Poster', label: 'Poster'},
                                                {value:'Layar Toko', label: 'Layar Toko'},
                                                {value:'x Banner', label: 'x Banner'},
                                                {value:'Sticker Perdana', label: 'Sticker Perdana'},
                                                {value:'Tripod', label: 'Tripod'},
                                                {value:'Sticker Etakase', label: 'Sticker Etakase'},
                                            ]}
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading} 
                                        />
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <Select
                                            title="Produk"
                                            name="product"
                                            options={[
                                                {value:"Super Seru", label:"Super Seru"},
                                                {value:"Telkomsel Lite", label:"Telkomsel Lite"},
                                                {value:"ByU", label:"ByU"},
                                                {value:"Orbit", label:"Orbit"},
                                                {value:"Jitu 1", label:"Jitu 1"},
                                                {value:"MyTsel", label:"MyTsel"},
                                                {value:"Kartu Halo", label:"Kartu Halo"},
                                            ]}
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading} 
                                        />
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <Input
                                            type="number"
                                            title="Quantity"
                                            name="qty"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                            placeholder="Masukkan kuantitas"
                                        />
                                    </div>                            
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <Textarea 
                                            title="Alamat"
                                            name="alamat"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                            placeholder="Masukkan alamat"
                                            rows="5"
                                        />
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                     
                                        <Input
                                            type="date"
                                            title="Due Date"
                                            name="due_date"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                        />
                                    </div>       
                                </div>
                                
                            </div>
                            <div className='card-footer text-start'>
                                <button type="submit" class="btn btn-info float-right px-5">Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Order;