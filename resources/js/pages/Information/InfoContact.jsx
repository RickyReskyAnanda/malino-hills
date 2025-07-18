import React, { useEffect, useState } from 'react';
import { useFormik } from 'formik';
import { updateSchema } from '../../Schemas/InfoContactSchema'
import { getIndex, patchItem } from '../../Utils/api';
import toastify from '../../Utils/toastify';
import { useParams } from 'react-router-dom';

import Input from '../../Components/Makro/Form/Input'
import ButtonSubmit from '../../Components/Mikro/ButtonSubmit';

function InfoContact() {
    const { id } = useParams()

    const [isLoading, setIsLoading] = useState(false)
    
    const formik = useFormik({
        initialValues: {
            no_wa: '',
            email: ''
        },
        validationSchema: updateSchema,
        onSubmit: values => {
            setIsLoading(true)
            
            patchItem(`api/info-contact`, values)
            .then(res => {
                setIsLoading(false)
                toastify(res)

            })
            .catch(err => {
                setIsLoading(false)
                toastify(err)
            });
        },
    });



    useEffect(()=>{
            getIndex(`api/info-contact`)
            .then(res=>{
                formik.setValues({
                    no_wa: res?.data?.no_wa || '',
                    email: res?.data?.email || ''
                  });
            })
            .catch(err=>{
                toastify({ status:'ERROR', message: err,message })
            })
    },[])

    return (
        <div className="card mb-3">
            <div className="card-header p-2 mx-3 mt-3">
                <h6>Info Kontak</h6>
            </div>
            <form
                className="form"
                id="kt_form"
                onSubmit={formik.handleSubmit}>
                <div className="card-body">
                    <div className='row mb-1'>
                        <div className='col-xl-4 col-lg-4 col-md-6'>
                            <Input
                                type="number"
                                title="Nomor Whatsapp*"
                                name="no_wa"
                                formik={formik}
                                onChange={formik.handleChange}
                                onBlur={formik.handleBlur}
                                disabled={isLoading}
                                placeholder="Contoh: 628123456789"
                            />
                        </div>
                    </div>
                    <div className='row mb-1'>
                        <div className='col-xl-4 col-lg-4 col-md-6'>
                            <Input
                                type="email"
                                title="Email Informasi*"
                                name="email"
                                formik={formik}
                                onChange={formik.handleChange}
                                onBlur={formik.handleBlur}
                                disabled={isLoading}
                                placeholder="Contoh: info@malinohills.com"
                            />
                        </div>
                    </div>
                </div>
                <div className='card-footer text-start'>
                    <ButtonSubmit label={"Simpan"} />
                </div>
            </form>
        </div>
    );
}

export default InfoContact;