import React, { useEffect, useState } from 'react';
import { useFormik } from 'formik';
import { updateSchema } from '../../Schemas/InfoLocationSchema'
import { getIndex, postItem, postItemWithFile, patchItem } from '../../Utils/api';
import toastify from '../../Utils/toastify';
import { useParams } from 'react-router-dom';

import Input from '../../Components/Makro/Form/Input'
import Textarea from '../../Components/Makro/Form/Textarea'
import ButtonSubmit from '../../Components/Mikro/ButtonSubmit';

function InfoLocation() {
    const { id } = useParams()

    const [isLoading, setIsLoading] = useState(false)
    
    const formik = useFormik({
        initialValues: {
            address: '',
            longitude: '',
            lattitude: '',
            position_1: '',
            position_2: '',
            position_3: '',
            position_4: '',
            position_5: '',
        },
        validationSchema: updateSchema,
        onSubmit: values => {
            setIsLoading(true)
            
            patchItem(`api/info-location`, values)
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
            getIndex(`api/info-location`)
            .then(res=>{
                formik.setValues({
                    address: res?.data?.address || '',
                    longitude: res?.data?.longitude || '',
                    lattitude: res?.data?.lattitude || '',
                    position_1: res?.data?.position_1 || '',
                    position_2: res?.data?.position_2 || '',
                    position_3: res?.data?.position_3 || '',
                    position_4: res?.data?.position_4 || '',
                    position_5: res?.data?.position_5 || '',
                  });
            })
            .catch(err=>{
                toastify({ status:'ERROR', message: err,message })
            })
    },[])

    return (
        <div className="card mb-3">
            <div className="card-header p-2 mx-3 mt-3">
                <h6>Info Lokasi</h6>
            </div>
            <form
                className="form"
                id="kt_form"
                onSubmit={formik.handleSubmit}>
                <div className="card-body">
                    <div className='row mb-1'>
                        <div className='col-xl-6 col-lg-6 col-md-6'>
                            <Textarea
                                rows="2"
                                title="Alamat*"
                                name="address"
                                formik={formik}
                                onChange={formik.handleChange}
                                onBlur={formik.handleBlur}
                                disabled={isLoading}
                                placeholder="Masukkan alamat lengkap"
                            />
                        </div>
                    </div>

                    <div className='row mb-1'>
                        <div className='col-xl-3 col-lg-4 col-md-6'>
                            <Input
                                type="text"
                                title="Longitude*"
                                name="longitude"
                                formik={formik}
                                onChange={formik.handleChange}
                                onBlur={formik.handleBlur}
                                disabled={isLoading}
                                placeholder="longitude"
                            />
                        </div>
                        <div className='col-xl-3 col-lg-4 col-md-6'>
                            <Input
                                type="text"
                                title="Lattitude*"
                                name="lattitude"
                                formik={formik}
                                onChange={formik.handleChange}
                                onBlur={formik.handleBlur}
                                disabled={isLoading}
                                placeholder="lattitude"
                            />
                        </div>
                    </div>

                    <div className='row mb-1'>
                        <div className='col-lg-6'>
                            <Input
                                type="text"
                                title="Position 1*"
                                name="position_1"
                                formik={formik}
                                onChange={formik.handleChange}
                                onBlur={formik.handleBlur}
                                disabled={isLoading}
                                placeholder="Describe position"
                            />
                        </div>
                    </div>
                    <div className='row mb-1'>
                        <div className='col-lg-6'>
                            <Input
                                type="text"
                                title="Position 2*"
                                name="position_2"
                                formik={formik}
                                onChange={formik.handleChange}
                                onBlur={formik.handleBlur}
                                disabled={isLoading}
                                placeholder="Describe position"
                            />
                        </div>
                    </div>
                    <div className='row mb-1'>
                        <div className='col-lg-6'>
                            <Input
                                type="text"
                                title="Position 3*"
                                name="position_3"
                                formik={formik}
                                onChange={formik.handleChange}
                                onBlur={formik.handleBlur}
                                disabled={isLoading}
                                placeholder="Describe position"
                            />
                        </div>
                    </div>
                    <div className='row mb-1'>
                        <div className='col-lg-6'>
                            <Input
                                type="text"
                                title="Position 4"
                                name="position_4"
                                formik={formik}
                                onChange={formik.handleChange}
                                onBlur={formik.handleBlur}
                                disabled={isLoading}
                                placeholder="Describe position"
                            />
                        </div>
                    </div>
                    <div className='row mb-1'>
                        <div className='col-lg-6'>
                            <Input
                                type="text"
                                title="Position 5"
                                name="position_5"
                                formik={formik}
                                onChange={formik.handleChange}
                                onBlur={formik.handleBlur}
                                disabled={isLoading}
                                placeholder="Describe position"
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

export default InfoLocation;