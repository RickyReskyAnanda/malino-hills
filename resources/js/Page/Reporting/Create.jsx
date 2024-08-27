import React, {  useContext, useEffect, useState } from 'react';
import { useFormik } from 'formik';
import { postItemWithFile } from '../../Utils/api';
import { createSchema } from '../../Schemas/ReportingSchema';

import Select from '../../Components/Makro/Form/Select';
import Textarea from '../../Components/Makro/Form/Textarea';
import Input from '../../Components/Makro/Form/Input';
import SelectApi from '../../Components/Makro/Form/SelectApi';
import AutoSuggest from '../../Components/Makro/Form/AutoSuggest';
import toastify from '../../Utils/toastify';
import { useSearchParams } from 'react-router-dom';
import { GlobalContext } from '../../Context/GlobalContext';
import ButtonSubmit from '../../Components/Mikro/ButtonSubmit';


function Create(props) {
    const { setBreadcrumbs } = useContext(GlobalContext);

    useEffect(()=>{
        setBreadcrumbs({
            path:['Reporting','Add Report'],
            title:'Add Report',
        })
    },[])
    const [searchParams, setSearchParams] = useSearchParams();

  // Mendapatkan nilai dari query string
    const nomor_order = searchParams.get('nomor_order');

    const [isLoading, setIsLoading] = useState(false)
    
    const formik = useFormik({
        initialValues: {
            'nomor_order': nomor_order,
            'regional': '',
            'branch': '',
            'cluster': '',
            'type': '',
            'nama': '',
            'alamat': '',
            'outlet_id': '',
            'foto': null,
        },
        validationSchema: createSchema,
        onSubmit: values => {
            setIsLoading(true)
            
                postItemWithFile('api/reporting', {...values, outlet_id: values?.outlet_id?.value || null})
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
                        <div class="card-header p-0 mx-3 mt-3">
                            <h6>Reporting</h6>
                        </div>
                        <form className="form" onSubmit={formik.handleSubmit}>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <Input
                                            type="number"
                                            title="No Order"
                                            name="nomor_order"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                        /> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <Select
                                            title="Regional"
                                            name="regional"
                                            formik={formik}
                                            options={[
                                                { value: "KALIMANTAN", label:"KALIMANTAN" },
                                                { value: "SULAWESI", label:"SULAWESI" },
                                                { value: "PUMA", label:"PUMA" },
                                            ]}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                        /> 
                                    </div>

                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
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
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
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
                                </div>

                                <div class="row">
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <Select
                                            title="Type"
                                            name="type"
                                            formik={formik}
                                            options={[
                                                { value: "Outlet", label:"Outlet" },
                                                { value: "Fasilitas Umum", label:"Fasilitas Umum" },
                                            ]}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                        /> 
                                    </div>
                                </div>
                                <div class="row">
                                { formik?.values?.type !== '' && <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <Input
                                            type="text"
                                            title={ formik?.values?.type === 'Outlet' ? "Nama Outlet":"Nama Fasilitas Umum" }
                                            name="nama"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                        /> 
                                    </div> }
                                    { formik?.values?.type === 'Fasilitas Umum' && <div class="col-lg-4 col-md-6 col-sm-12">
                                        <Textarea
                                            title="Alamat"
                                            name="alamat"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                        /> 
                                    </div>}
                                    {formik?.values?.type === 'Outlet' && <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <AutoSuggest
                                            formik={formik}
                                            parent={formik.values.cluster}
                                            name={"outlet_id"}
                                            title="Id Outlet"
                                            onChange={(option) => formik.setFieldValue("outlet_id", option)}
                                            onBlur={() => formik.setFieldTouched("outlet_id", true)}
                                            placeholder='Pilih ID Outlet'
                                            disabled={isLoading}
                                        />
                                    </div>}
                                    { formik?.values?.type !== '' && <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                        <div className="form-group">
                                            <label for="foto">Foto</label>
                                            <input
                                                type="file"
                                                name="foto"
                                                accept="image/*"
                                                className={"form-control " +
                                                    (formik.touched['foto'] && formik.errors['foto']
                                                    ? " is-invalid border-danger"
                                                    : "form-control-solid")}
                                                onChange={(event) => {
                                                    formik.setFieldValue("foto", event.currentTarget.files[0]);
                                                }}
                                                onBlur={formik.handleBlur}
                                                disabled={isLoading}
                                            />
                                            {formik.touched['foto'] && formik.errors['foto'] && (
                                                <p className="error text-danger"><small>{formik.errors['foto']}</small></p>
                                            )}
                                        </div>
                                    </div>}

                                </div>
                            </div>
                            <div className='card-footer text-start'>
                                <ButtonSubmit label={"Save"} />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Create;