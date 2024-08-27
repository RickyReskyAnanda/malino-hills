import { useFormik } from 'formik';
import React, { useContext, useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { axiosInstance,  } from '../../Utils/api';
import Select from '../../Components/Makro/Form/Select'
import SelectApi from '../../Components/Makro/Form/SelectApi'
import Input from '../../Components/Makro/Form/Input'
import InputFile from '../../Components/Makro/Form/InputFile'
import { createSchema } from '../../Schemas/BrandingShareSchema'
import { GlobalContext } from '../../Context/GlobalContext';
import { toast } from 'react-toastify';

function Form() {
    const navigate = useNavigate()
    const { setBreadcrumbs } = useContext(GlobalContext);

    useEffect(()=>{
        setBreadcrumbs({
            path:['Branding Share','Add Branding Share'],
            title:'Add Branding Share',
        })
    },[])

    const [isLoading, setIsLoading] = useState(false)

    const formik = useFormik({
        initialValues: {
            'month': '',
            'week': '',
            'cluster': '',
            'file_csv': null,
        },
        validationSchema: createSchema,
        onSubmit: values => {
            setIsLoading(true)
            
            // postItemWithFile('api/branding-share', values)
            // .then(res => {
            //     setIsLoading(false)
            //     toastify(res)
            //     if(res.code === 200){
            //         formik.resetForm()
            //     }
            // })

            // .catch(err => {
            //     setIsLoading(false)
            //     toastify(err)
            // });

            const uploadToastId = toast.info("Uploading file...", {
                autoClose: false,
                isLoading: true,
                pauseOnHover: false,
              });

            axiosInstance.post('api/branding-share',values, {
                headers: {
                    "Content-Type": 'multipart/form-data',
                  Accept: "application/json",
                },
                onUploadProgress: (progressEvent) => {
                    const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    if(percentCompleted < 100){
                        toast.update(uploadToastId, {
                            render: `Uploading: ${percentCompleted}%`,
                            type: 'info',
                        });
                        
                    }else 
                        toast.update(uploadToastId, {
                            render: `Processing..`,
                            type: 'info',
                        });
                },
            })
            .then((response) => {
                if(response.data.code === 200){

                    toast.update(uploadToastId, {
                        render: "File uploaded successfully.",
                        type: 'success',
                        isLoading: false,
                        autoClose: 1000,
                        pauseOnHover: false,
                    });

                    formik.resetForm()
                    navigate('/branding-share')
                }
                else 
                    toast.update(uploadToastId, {
                        render: "Error uploading file",
                        type: 'error',
                        isLoading: false,
                        autoClose: 3000,
                    });
                setIsLoading(false)


            })
            .catch((error) => {
                toast.update(uploadToastId, {
                    render: "Error uploading file",
                    type: 'error',
                    isLoading: false,
                    autoClose: 3000,
                  });
                setIsLoading(false)
            });
        },
    });
    return (
        <div className="container-fluid py-4">
            <div className="row">
                <div className="col-12">
                    <div className="card">
                        <form className="form" onSubmit={formik.handleSubmit}>
                            <div className="card-body">
                                <div className="row">
                                    <div className="col-lg-4 col-md-6 col-sm-12">
                                        <Input
                                            title="Tahun Bulan"
                                            type="month"
                                            name="month"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading} 
                                        />
                                    </div>                            
                                </div>                            
                                <div className="row">
                                    <div className="col-lg-4 col-md-6 col-sm-12">
                                        <Select
                                            title="Week"
                                            name="week"
                                            options={[
                                                {value: "W1", label: "W1"},
                                                {value: "W2", label: "W2"},
                                                {value: "W3", label: "W3"},
                                                {value: "W4", label: "W4"},
                                            ]}
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading} 
                                        />
                                    </div>
                                </div>                            
                                <div className="row">
                                    <div className="col-lg-4 col-md-6 col-sm-12">
                                        <SelectApi
                                            title="Cluster"
                                            name="cluster"
                                            parent={""}
                                            isNoParent={true}
                                            url={ `api/filter/clusters` }
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading} 
                                        />
                                    </div>
                                </div>                            
                                <div className="row">
                                    <div className="col-lg-5 col-md-6 col-sm-12">
                                        <InputFile
                                            title="Upload file disini"
                                            name="file_csv"
                                            accept='.csv'
                                            formik={formik}
                                            onChange={(event) => {
                                                formik.setFieldValue("file_csv", event.currentTarget.files[0]);
                                            }}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                        />
                                        <p className='text-sm '>Gunakan template CSV dibawah untuk mengupload data<br/>
                                            <a href={document.querySelector('meta[name="base-url"]').getAttribute('content') + '/branding-share/template_branding_share.csv'} className='text-bold text-danger'>Download Template From Server</a>
                                        </p>
                                    </div>       
                                </div>
                                
                            </div>
                            <div className="card-footer text-start">
                                <button
                                    type="submit"
                                    className="btn btn-info float-right px-5"
                                    disabled={isLoading}
                                >Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Form;