import React, { useContext, useEffect, useState } from 'react';
import { useFormik } from 'formik';
import {createSchema, updateSchema} from '../../Schemas/UploadKVSchema'
import { getIndex, postItem, postItemWithFile, updateItemWithFile } from '../../utils/api';
import toastify from '../../utils/toastify';
import { useNavigate, useParams } from 'react-router-dom';
import { GlobalContext } from '../../contexts/GlobalContext';

import Input from './../../components/Makro/Form/Input'
import Select from './../../components/Makro/Form/Select'
import ButtonSubmit from '../../components/Mikro/ButtonSubmit';

function Create(props) {
    const { id } = useParams()


    const { setBreadcrumbs } = useContext(GlobalContext);

    useEffect(()=>{
        const title = id > 0 ? "Edit":'Add'
        setBreadcrumbs({
            path:['KV',title+ ' KV'],
            title:title+ ' KV',
        })
    },[])


    const [isLoading, setIsLoading] = useState(false)
    const navigate = useNavigate()

    
    const formik = useFormik({
        initialValues: {
            'title': '',
            'produk': '',
            'jenis': '',
            'kv': null,
            'kv_cdr': null,
        },
        validationSchema: parseInt(id) > 0 ?  updateSchema : createSchema,
        onSubmit: values => {
            setIsLoading(true)
            
            if(!id)
                postItemWithFile('api/upload-kv', values)
                .then(res => {
                    setIsLoading(false)
                    toastify(res)
                    if(res.code === 200)
                        navigate('/upload-kv')
                })
                .catch(err => {
                    setIsLoading(false)
                    toastify(err)
                });
            else
                updateItemWithFile(`api/upload-kv/${id}`, values)
                .then(res => {
                    setIsLoading(false)
                    toastify(res)

                    if(res.code === 200)
                        navigate('/upload-kv')
                })
                .catch(err => {
                    setIsLoading(false)
                    toastify(err)
                });
            
        },
    });



    useEffect(()=>{
        if(parseInt(id) > 0 ){
            getIndex(`api/upload-kv/${id}`)
            .then(res=>{
                formik.setValues({
                    'title': res?.data?.title || '',
                    'produk': res?.data?.produk || '',
                    'jenis': res?.data?.jenis || '',
                  });
            })
            .catch(err=>{

            })
        }
    },[])

    return (
        <div className="container-fluid py-4">
            <div className="row">
                <div className="col-12">
                    <div className="card">
                        <div className="card-header p-2 mx-3 mt-3">
                            <h6>{id > 0 ? "Edit":'Add'} KV</h6>
                        </div>
                        <form
                            className="form"
                            id="kt_form"
                            onSubmit={formik.handleSubmit}>
                            <div className="card-body">
                                <div className='row mb-1'>
                                    <div className='col-xl-4 col-lg-4 col-md-6'>
                                        <Input
                                            type="text"
                                            title="Title"
                                            name="title"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                            placeholder="Title"
                                        />
                                    </div>
                                </div>
                                <div className='row mb-1'>
                                    <div className='col-xl-3 col-lg-4 col-md-6'>
                                        <Select
                                            title="Produk"
                                            name="produk"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            options={[
                                                { value:"Broadband", label:"Broadband" },
                                                { value:"Voice", label:"Voice" },
                                                { value:"DLS", label:"DLS" }, 
                                            ]}
                                            disabled={isLoading}
                                        />
                                    </div>
                                    <div className='col-xl-3 col-lg-4 col-md-6'>
                                        <Select
                                            title="Jenis"
                                            name="jenis"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            options={[
                                                { value:"CVM", label:"CVM" },
                                                { value:"PV", label:"PV" },
                                                { value:"Core", label:"Core" }, 
                                            ]}
                                            disabled={isLoading}
                                        />
                                    </div>
                                </div>

                                <div className='row mb-1'>
                                    <div className=' col-md-6'>
                                        <div className="form-group">
                                            <label for="kv">KV (PNG/JPEG)</label>
                                            <input
                                                type="file"
                                                id="kv"
                                                name="kv"
                                                accept=".png, .jpg, .jpeg"
                                                className={"form-control " +
                                                    (formik.touched.kv && formik.errors.kv
                                                        ? " is-invalid border-danger"
                                                        : "form-control-solid")}
                                                onChange={(event) => {
                                                    formik.setFieldValue("kv", event.currentTarget.files[0]);
                                                }}
                                                onBlur={formik.handleBlur}
                                            />
                                            {formik.touched.kv && formik.errors.kv && (
                                                <p className="error text-danger"><small>{formik.errors.kv}</small></p>
                                            )}
                                            
                                        </div>
                                    </div>
                                </div>
                                <div className='row'>
                                    <div className=' col-md-6'>
                                        <div className="form-group">
                                            <label for="kv_cdr">KV (CDR)</label>
                                            <input
                                                type="file"
                                                id="kv_cdr"
                                                name="kv_cdr"
                                                accept=".cdr"
                                                className={"form-control " +
                                                    (formik.touched.kv_cdr && formik.errors.kv_cdr
                                                        ? " is-invalid border-danger"
                                                        : "form-control-solid")}
                                                onChange={(event) => {
                                                    formik.setFieldValue("kv_cdr", event.currentTarget.files[0]);
                                                }}
                                                onBlur={formik.handleBlur}
                                            />
                                            {formik.touched.kv_cdr && formik.errors.kv_cdr && (
                                                <p className="error text-danger"><small>{formik.errors.kv_cdr}</small></p>
                                            )}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className='card-footer text-start'>
                                <ButtonSubmit label={"Upload"} />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Create;