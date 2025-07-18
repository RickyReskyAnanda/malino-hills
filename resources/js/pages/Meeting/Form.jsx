import React, { useEffect, useState } from 'react';
import { useFormik } from 'formik';
import { updateSchema } from '../../Schemas/InfoMeetingRoomSchema'
import { getIndex, patchItem } from '../../Utils/api';
import toastify from '../../Utils/toastify';
import { useParams } from 'react-router-dom';

import Input from '../../Components/Makro/Form/Input'
import TextArea from '../../Components/Makro/Form/TextArea'
import ButtonSubmit from '../../Components/Mikro/ButtonSubmit';

function InfoContact() {
    const [isLoading, setIsLoading] = useState(false)
    
    const formik = useFormik({
        initialValues: {
            title: '',
            description: ''
        },
        validationSchema: updateSchema,
        onSubmit: values => {
            setIsLoading(true)
            
            patchItem(`api/meeting-room`, values)
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
        getIndex(`api/meeting-room`)
        .then(res=>{
            formik.setValues({
                title: res?.data?.title || '',
                description: res?.data?.description || ''
            });
        })
        .catch(err=>{
            toastify({ status:'ERROR', message: err,message })
        })
    },[])

    return (
        <div className="card mb-3">
            <div className="card-header p-2 mx-3 mt-3">
                <h6>Info Meeting Room</h6>
            </div>
            <form
                className="form"
                id="kt_form"
                onSubmit={formik.handleSubmit}>
                <div className="card-body">
                    <div className='row mb-1'>
                        <div className='col-lg-4 col-md-6'>
                            <Input
                                type="text"
                                title="Judul*"
                                name="title"
                                formik={formik}
                                onChange={formik.handleChange}
                                onBlur={formik.handleBlur}
                                disabled={isLoading}
                                placeholder="Masukkan judul disini"
                            />
                        </div>
                    </div>
                    <div className='row mb-1'>
                        <div className='col-lg-6'>
                            <TextArea
                                title="Deskripsi*"
                                name="description"
                                formik={formik}
                                onChange={formik.handleChange}
                                onBlur={formik.handleBlur}
                                disabled={isLoading}
                                placeholder="Ketikkan deskripsi disini"
                                rows={6}
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