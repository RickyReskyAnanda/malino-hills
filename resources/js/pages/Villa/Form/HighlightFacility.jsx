import React, { useContext, useEffect, useState, useRef } from 'react';
import { useFormik } from 'formik';
import { highlightFacilitySchema } from '../../../Schemas/VillaFacilitySchema'
import { getIndex, updateItem } from '../../../utils/api';
import toastify from '../../../utils/toastify';
import { useParams } from 'react-router-dom';
import { GlobalContext } from '../../../contexts/GlobalContext';
import ButtonSubmit from '../../../Components/Mikro/ButtonSubmit';
import 'react-quill/dist/quill.snow.css';

const pathUrl = "highlight-facility"

function Content(props) {
    const { id } = useParams()

    const { setBreadcrumbs } = useContext(GlobalContext);

    useEffect(()=>{
        const title = id > 0 ? "Edit":'Add'
        setBreadcrumbs({
            path:['Villa',title+ ' Villa'],
            title:title+ ' Villa',
        })

        getData()
    },[])


    const [isLoading, setIsLoading] = useState(false)
    

    const getData = ()=>{
        getIndex(`api/villa/${id}/${pathUrl}`)
        .then(res=>{

            formik.setValues({ highlight_facilities: res.data })
        })
        .catch(err=>{
            toastify({ status: 'ERROR', message:err.message })
        })
    }

    const formik = useFormik({
        initialValues: {
          highlight_facilities: [],  // Mengisi initial value dari data
        },
        validationSchema: highlightFacilitySchema,
        onSubmit: (values) => {
            updateItem(`api/villa/${id}/${pathUrl}`,{ type: 'HIGHLIGHT', ...values })
            .then(res=>{
                toastify(res)
            })
            .catch(err=>{
                toastify({ status: 'ERROR', message:err.message })
            })
        },
    });

    return (
        <div className="card mb-3">
            <div className="card-header p-2 mx-3 mt-3">
                <h6>4 Fasilitas Utama</h6>
            </div>
            <form
                className="form"
                id="kt_form"
                onSubmit={formik.handleSubmit}>
                <div className="card-body">
                    <div className='row'>
                        <div className='col-lg-6'>
                            <div className='d-flex flex-column'>
                                { formik.values?.highlight_facilities.map((d,index)=>(
                                    <div className='d-flex gap-3 align-items-center'>
                                        <div>
                                            <img style={{ maxWidth: '25px' }} src={d.icon}/>
                                        </div>
                                        <div className='flex-grow-1'>
                                            <input
                                                className={"form-control my-2"}
                                                id={`highlight_facilities.${index}.name`}
                                                name={`highlight_facilities.${index}.name`}
                                                type="text"
                                                value={formik.values.highlight_facilities[index]?.name}
                                                onChange={formik?.handleChange}
                                                onBlur={formik?.handleBlur}
                                            />
                                            {formik?.touched?.highlight_facilities &&
                                            formik?.touched?.highlight_facilities[index] &&
                                            formik?.errors?.highlight_facilities &&
                                            formik?.errors?.highlight_facilities[index] ? (
                                                <p className="error text-danger"><small>{formik?.errors?.highlight_facilities[index]?.name}</small></p>
                                            ) : null}
                                        </div>
                                    </div>
                                ))}
                            </div>


                        </div>
                    </div>
                </div>
                <div className='card-footer text-start'>
                    <ButtonSubmit disabled={isLoading} label={"Simpan"} />
                </div>
            </form>
        </div>
    );
}

export default Content;