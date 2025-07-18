import React, { useContext, useEffect, useState, useRef } from 'react';
import { useFormik } from 'formik';
import { highlightFacilitySchema, facilitySchema } from '../../../Schemas/VillaFacilitySchema'
import { getIndex, updateItem } from '../../../utils/api';
import toastify from '../../../utils/toastify';
import { useParams } from 'react-router-dom';
import { GlobalContext } from '../../../contexts/GlobalContext';
import ButtonSubmit from '../../../Components/Mikro/ButtonSubmit';
import 'react-quill/dist/quill.snow.css';
import { CheckCircleIcon, TrashIcon } from '../../../components/Mikro/SVGIcon';

const pathUrl = "facility"

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
    const [newFacility, setNewFacility] = useState("")
    

    const getData = ()=>{
        getIndex(`api/villa/${id}/${pathUrl}`)
        .then(res=>{

            formik.setValues({ facilities: res.data })
        })
        .catch(err=>{
            toastify({ status: 'ERROR', message:err.message })
        })
    }

    const formik = useFormik({
        initialValues: {
          facilities: [],  // Mengisi initial value dari data
        },
        validationSchema: facilitySchema,
        onSubmit: (values) => {
            updateItem(`api/villa/${id}/${pathUrl}`,{ type: 'REGULER', ...values })
            .then(res=>{
                toastify(res)
            })
            .catch(err=>{
                toastify({ status: 'ERROR', message:err.message })
            })
        },
    });

    const handleAddFacility = () => {
        formik.setValues({ facilities: [...formik.values.facilities, {  id: null, name: newFacility }]  })
        setNewFacility("")
    }

    const handleDeleteFacility = (index) =>{
        console.log(index)
        const newFacilities = formik.values.facilities
        newFacilities.splice(index, 1)
        formik.setValues({ facilities: newFacilities })
    }

    return (
        <div className="card mb-3">
            <div className="card-header p-2 mx-3 mt-3">
                <h6>Fasilitas Lainnya</h6>
            </div>
            <form
                className="form"
                id="kt_form"
                onSubmit={formik.handleSubmit}>
                <div className="card-body">
                    <div className='row'>
                        <div className='col-lg-6'>
                            <div className='d-flex flex-column'>
                                { formik.values?.facilities?.map((d,index)=>(
                                    <div className='d-flex gap-3 align-items-center'>
                                        <div style={{ color:'#ab8965' }}>
                                            <CheckCircleIcon/>
                                        </div>
                                        <div className='flex-grow-1'>
                                            <input
                                                className={"form-control my-2"}
                                                id={`facilities.${index}.name`}
                                                name={`facilities.${index}.name`}
                                                type="text"
                                                value={formik.values.facilities[index]?.name}
                                                onChange={formik?.handleChange}
                                                onBlur={formik?.handleBlur}
                                            />
                                            {formik?.touched?.facilities &&
                                            formik?.touched?.facilities[index] &&
                                            formik?.errors?.facilities &&
                                            formik?.errors?.facilities[index] ? (
                                                <div>{formik?.errors?.facilities[index]?.name}</div>
                                            ) : null}
                                        </div>
                                        <div style={{ color:'#ff0000' }} className='pointer' onClick={() => handleDeleteFacility(index)}>
                                            <TrashIcon/>
                                        </div>
                                    </div>
                                ))}
                                <div className='d-flex gap-3 align-items-center'>
                                    <div style={{ color:'#ab8965' }}>
                                        <CheckCircleIcon/>
                                    </div>
                                    <div className='flex-grow-1'>
                                        <input
                                            className={"form-control my-2"}
                                            type="text"
                                            value={newFacility}
                                            onChange={(e)=> setNewFacility(e.target.value) }
                                        />
                                    </div>
                                    <div>
                                        <div className='btn btn-outline-info m-0' onClick={handleAddFacility}>Add</div>
                                    </div>
                                </div>
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