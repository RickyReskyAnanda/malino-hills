import React, { useEffect, useState } from 'react';
import { useFormik } from 'formik';
import { updateSchema } from '../../Schemas/InfoSocMedSchema'
import { getIndex, postItem, postItemWithFile, patchItem } from '../../Utils/api';
import toastify from '../../Utils/toastify';

import Input from '../../Components/Makro/Form/Input'
import ButtonSubmit from '../../Components/Mikro/ButtonSubmit';

function InfoSocMed() {
    const [isLoading, setIsLoading] = useState(false)
    
    const formik = useFormik({
        initialValues: {
            sosmed_ig: '',
            sosmed_tiktok: '',
            sosmed_facebook: '',
            sosmed_youtube: '',
        },
        validationSchema: updateSchema,
        onSubmit: values => {
            setIsLoading(true)
            
            patchItem(`api/info-socmed`, values)
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
            getIndex(`api/info-socmed`)
            .then(res=>{
                formik.setValues({
                    sosmed_ig: res?.data?.sosmed_ig || '',
                    sosmed_tiktok: res?.data?.sosmed_tiktok || '',
                    sosmed_facebook: res?.data?.sosmed_facebook || '',
                    sosmed_youtube: res?.data?.sosmed_youtube || '',
                });
            })
            .catch(err=>{
                toastify({ status:'ERROR', message: err,message })
            })
    },[])

    return (
        <div className="card">
            <div className="card-header p-2 mx-3 mt-3">
                <h6>Info Sosial Media</h6>
            </div>
            <form
                className="form"
                id="kt_form"
                onSubmit={formik.handleSubmit}>
                <div className="card-body">
                    <div className='row mb-1'>
                        <div className='col-xl-7 col-lg-8 col-md-12'>
                            <Input
                                type="url"
                                title="Link Profil Instagram*"
                                name="sosmed_ig"
                                formik={formik}
                                onChange={formik.handleChange}
                                onBlur={formik.handleBlur}
                                disabled={isLoading}
                                placeholder="Masukkan link profil instagram"
                            />
                        </div>
                    </div>
                    <div className='row mb-1'>
                        <div className='col-xl-7 col-lg-8 col-md-12'>
                            <Input
                                type="url"
                                title="Link Profil TikTok*"
                                name="sosmed_tiktok"
                                formik={formik}
                                onChange={formik.handleChange}
                                onBlur={formik.handleBlur}
                                disabled={isLoading}
                                placeholder="Masukkan link profil TikTok"
                            />
                        </div>
                    </div>
                    <div className='row mb-1'>
                        <div className='col-xl-7 col-lg-8 col-md-12'>
                            <Input
                                type="url"
                                title="Link Profil Facebook*"
                                name="sosmed_facebook"
                                formik={formik}
                                onChange={formik.handleChange}
                                onBlur={formik.handleBlur}
                                disabled={isLoading}
                                placeholder="Masukkan link profil Facebook"
                            />
                        </div>
                    </div>
                    <div className='row mb-1'>
                        <div className='col-xl-7 col-lg-8 col-md-12'>
                            <Input
                                type="url"
                                title="Link Profil Youtube*"
                                name="sosmed_youtube"
                                formik={formik}
                                onChange={formik.handleChange}
                                onBlur={formik.handleBlur}
                                disabled={isLoading}
                                placeholder="Masukkan link profil Youtube"
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

export default InfoSocMed;