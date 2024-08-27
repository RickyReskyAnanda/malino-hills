import React, { useContext, useEffect, useState } from 'react';
import { useFormik } from 'formik';
import {createSchema, updateSchema} from '../../Schemas/UserAccountSchema'
import { getIndex, postItem, postItemWithFile, updateItemWithFile } from '../../Utils/api';
import toastify from '../../Utils/toastify';
import { useNavigate, useParams } from 'react-router-dom';
import Input from '../../Components/Makro/Form/Input';
import InputPassword from '../../Components/Makro/Form/InputPassword';
import ButtonSubmit from '../../Components/Mikro/ButtonSubmit';

import Select from '../../Components/Makro/Form/Select';
import { GlobalContext } from '../../Context/GlobalContext';

function Create(props) {
    const { id } = useParams()
    const { setBreadcrumbs } = useContext(GlobalContext);

    useEffect(()=>{
        const title = id > 0 ? "Edit":'Add'
        setBreadcrumbs({
            path:['User Account',title+ ' User Account'],
            title:title+ ' User Account',
        })
    },[])

    const [isLoading, setIsLoading] = useState(false)
    const navigate = useNavigate()

    
    const formik = useFormik({
        initialValues: {
            'name': '',
            'username': '',
            'role': '',
            'status': '',
            'password': '',
        },
        validationSchema: parseInt(id) > 0 ?  updateSchema : createSchema,
        onSubmit: values => {
            setIsLoading(true)
            
            if(!id)
                postItemWithFile('api/user-account', values)
                .then(res => {
                    setIsLoading(false)
                    toastify(res)
                    if(res.code === 200)
                        navigate('/user-account')
                })
                .catch(err => {
                    setIsLoading(false)
                    toastify(err)
                });
            else
                updateItemWithFile(`api/user-account/${id}`, values)
                .then(res => {
                    setIsLoading(false)
                    toastify(res)

                    if(res.code === 200)
                        navigate('/user-account')
                })
                .catch(err => {
                    setIsLoading(false)
                    toastify(err)
                });
            
        },
    });



    useEffect(()=>{
        if(parseInt(id) > 0 ){
            getIndex(`api/user-account/${id}`)
            .then(res=>{
                formik.setValues({
                    'name': res?.data?.name || '',
                    'username': res?.data?.username || '',
                    'role': res?.data?.role || '',
                    'status': res?.data?.status || '',
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
                        <div className="card-header p-0 mx-3 mt-3">
                            <h6>{id > 0 ? "Edit":'Add'} User Account</h6>
                        </div>
                        <form className="form" id="kt_form" onSubmit={formik.handleSubmit}>
                            <div className="card-body">
                                <div className='row'>
                                    <div className='col-lg-4'>
                                        <Input
                                            title="Name"
                                            type="text"
                                            placeholder="Name"
                                            name="name"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                        />
                                    </div>
                                </div>
                                <div className='row'>
                                    <div className='col-lg-3 col-md-4 col-sm-6'>
                                        <Input
                                            title="Username"
                                            type="text"
                                            placeholder="Username"
                                            name="username"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                        />
                                    </div>
                                    <div className='col-lg-3 col-md-4 col-sm-6'>
                                        <Select
                                            title="Role"
                                            name="role"
                                            formik={formik}
                                            options={[
                                                { value: "admin", label: "Admin" },
                                                { value: "guest", label: "Guest" },
                                            ]}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                        />
                                    </div>
                                </div>
                                <div className='row mb-1'>
                                    <div className='col-lg-3 col-md-4 col-sm-6'>
                                        <InputPassword
                                            title="Password"
                                            placeholder="Masukkan Password"
                                            name="password"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                        />
                                    </div>
                                    <div className='col-lg-3 col-md-4 col-sm-6'>
                                        <InputPassword
                                            title="Ulangi Password"
                                            placeholder="Masukkan Ulang Password"
                                            name="confirm"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                        />
                                    </div>
                                </div>
                                <div className='row'>
                                    <div className='col-lg-3 col-md-4 col-sm-6'>
                                        <Select
                                            title="Status"
                                            name="status"
                                            formik={formik}
                                            options={[
                                                { value: "active", label: "Active" },
                                                { value: "inactive", label: "Inactive" },
                                            ]}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                        />
                                    </div>
                                </div>
                                
                            </div>
                            <div className='card-footer text-start'>
                                <ButtonSubmit label="Save" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Create;