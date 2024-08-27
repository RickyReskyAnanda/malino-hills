import React, { useContext, useEffect, useRef, useState } from 'react';
import Modals from '../../Components/Makro/Popup/Modals';
import { useFormik } from 'formik';
import { patchItem, postItemWithFile } from '../../Utils/api';
import FilterSelect from '../../Components/Makro/Filter/FilterSelect';
import Select from '../../Components/Makro/Form/Select';
import Input from '../../Components/Makro/Form/Input';
import toastify from '../../Utils/toastify';
import {
    updateApprovalSchema,
    updateProductionSchema,
    updateDeliverySchema,
    updateAcceptedSchema,
} from '../../Schemas/MonitoringUpdateProgressSchrema';
import { role } from '../../Contants/usertype';
import { GlobalContext } from '../../Context/GlobalContext';

function Form({ formValues, onClose }) {
    const {  authUser } = useContext(GlobalContext);
    

    const refFormApprovel = useRef();
    const refFormProduction = useRef();
    const refFormDelivery = useRef();
    const refFormAccepted = useRef();
    
    const [progress, setProgress] = useState(formValues?.progress)

    useEffect(()=>{
        setProgress(formValues?.progress || '')
    },[formValues])

    const submitData = () => {
        patchItem(`api/monitoring/${formValues.id}/progress`, {progress})
            .then(res => {
                toastify(res)
                onClose()
            })
            .catch(err => {
                toastify(err)
            });
    }
    const handleSubmit = () => {
        if(progress === 'Propose' && authUser?.role === role.admin) submitData()
        else if(progress === 'Approvel' && authUser?.role === role.admin) refFormApprovel.current.submitForm()
        else if(progress === 'Production' && authUser?.role === role.admin) refFormProduction.current.submitForm()
        else if(progress === 'Delivery' && authUser?.role === role.admin) refFormDelivery.current.submitForm()
        
        if(authUser?.role === role.guest) refFormAccepted.current.submitForm()
        
    }
    return (
        <div>
            <Modals
                title={"Update Progress"}
                isOpen={parseInt(formValues?.id) > 0}
                onSubmit={handleSubmit}
                onClose={onClose}
            >
                    { authUser?.role === role.admin && <FilterSelect
                        title="Progress"
                        name={"progress"}
                        options={[
                            { value: "Propose", label:"Propose" },
                            { value: "Approvel", label:"Approvel" },
                            { value: "Production", label:"Production" },
                            { value: "Delivery", label:"Delivery" },
                        ]}
                        value={progress || formValues?.progress}
                        onChange={e=>setProgress(e.value)}
                    /> }
                    { progress === 'Approvel' && authUser?.role === role.admin &&  <FormApprovel ref={refFormApprovel}  formValues={formValues} onClose={onClose} /> }
                    { progress === 'Production' && authUser?.role === role.admin &&  <FormProduction ref={refFormProduction} formValues={formValues} onClose={onClose} /> }
                    { progress === 'Delivery' && authUser?.role === role.admin &&  <FormDelivery ref={refFormDelivery} formValues={formValues} onClose={onClose} /> }
                    { authUser?.role === role.guest && <FormAccepted ref={refFormAccepted} formValues={formValues} onClose={onClose} /> }
               
            </Modals>
        </div>
    );
}

export default Form;


const FormApprovel = React.forwardRef(({ formValues, onClose }, ref) => {
    React.useImperativeHandle(ref, () => ({
      submitForm() {
        formik.submitForm()
      }
    }))
    
    const [isLoading, setIsLoading] = useState(false)
    

    
    const formik = useFormik({
        initialValues: {
            'approvel_number': '',
            'progress': 'Approvel'
        },
        validationSchema: updateApprovalSchema,
        onSubmit: values => {
            setIsLoading(true)
            
            patchItem(`api/monitoring/${formValues.id}/progress`, values)
            .then(res => {
                setIsLoading(false)
                toastify(res)
                if(res.code === 200){
                    formik.resetForm()
                    onClose()
                }
            })
            .catch(err => {
                setIsLoading(false)
                toastify(err)
            });
        },
    });
    
    useEffect(()=>{
        formik.setFieldValue('approvel_number', formValues?.approvel_number || '')
    },[formValues])

    return (
        <div className="form-group approvel-input-group" >
            <Input 
                type="number"
                title="Approvel Number"
                name={"approvel_number"}
                formik={formik}
                onChange={formik.handleChange}
                onBlur={formik.handleBlur}
                disabled={isLoading}
            />
        </div>
    );

});


const FormProduction = React.forwardRef(({ formValues, onClose }, ref) => {
    React.useImperativeHandle(ref, () => ({
      submitForm() {
        formik.submitForm()
      }
    }))
    
    const [isLoading, setIsLoading] = useState(false)

    const formik = useFormik({
        initialValues: {
            'progress': 'Production',
            'production_month': '',
            'production_week': '',
        },
        validationSchema: updateProductionSchema,
        onSubmit: values => {
            setIsLoading(true)
            
            patchItem(`api/monitoring/${formValues.id}/progress`, values)
            .then(res => {
                setIsLoading(false)
                toastify(res)
                if(res.code === 200){
                    formik.resetForm()
                    onClose()
                }
            })

            .catch(err => {
                setIsLoading(false)
                toastify(err)
            });
        },
    });
    useEffect(()=>{
        formik.setValues({
            ...formik.values,
            'production_month': formValues?.production_month,
            'production_week': formValues?.production_week,
        })
    },[formValues])
    
    return (
        <>
            <Input
                title="Month"
                type="month"
                name="production_month"
                formik={formik}
                onChange={formik.handleChange}
                onBlur={formik.handleBlur}
                disabled={isLoading}
            />
        
            <Select
                title="Production Week"
                name="production_week"
                options={[
                    {value:'W2', label: 'W2'},
                    {value:'W4', label: 'W4'},
                ]}
                formik={formik}
                onChange={formik.handleChange}
                onBlur={formik.handleBlur}
                disabled={isLoading} 
            />
        </>
    );
})

const FormDelivery = React.forwardRef(({ formValues, onClose }, ref) => {
    React.useImperativeHandle(ref, () => ({
      submitForm() {
        formik.submitForm()
      }
    }))
    
    const [isLoading, setIsLoading] = useState(false)

    const formik = useFormik({
        initialValues: {
            'progress': 'Delivery',
            'delivery_month': '',
            'delivery_week': '',
        },
        validationSchema: updateDeliverySchema,
        onSubmit: values => {
            setIsLoading(true)
            
            patchItem(`api/monitoring/${formValues.id}/progress`, values)
            .then(res => {
                setIsLoading(false)
                toastify(res)
                if(res.code === 200){
                    formik.resetForm()
                    onClose()
                }
            })

            .catch(err => {
                setIsLoading(false)
                toastify(err)
            });
        },
    });

    useEffect(()=>{
        formik.setValues({
            ...formik.values,
            'delivery_month': formValues?.delivery_month,
            'delivery_week': formValues?.delivery_week,
        })
    },[formValues])
    
    return (
        <>
            <Input
                title="Month"
                type="month"
                name="delivery_month"
                formik={formik}
                onChange={formik.handleChange}
                onBlur={formik.handleBlur}
                disabled={isLoading}
            />
        
            <Select
                title="Delivery Week"
                name="delivery_week"
                options={[
                    {value:'W2', label: 'W2'},
                    {value:'W4', label: 'W4'},
                ]}
                formik={formik}
                onChange={formik.handleChange}
                onBlur={formik.handleBlur}
                disabled={isLoading} 
            />
        </>
    );
})

const FormAccepted = React.forwardRef(({ formValues, onClose }, ref) => {
    React.useImperativeHandle(ref, () => ({
      submitForm() {
        formik.submitForm()
      }
    }))
    
    const [isLoading, setIsLoading] = useState(false)

    const formik = useFormik({
        initialValues: {
            'progress': 'Accepted',
            'tgl_penerimaan': '',
            'foto_penerimaan': '',
        },
        validationSchema: updateAcceptedSchema,
        onSubmit: values => {
            setIsLoading(true)
            
            postItemWithFile(`api/monitoring/${formValues.id}/progress_user`, values)
            .then(res => {
                setIsLoading(false)
                toastify(res)
                if(res.code === 200){
                    formik.resetForm()
                    onClose()
                }
            })

            .catch(err => {
                setIsLoading(false)
                toastify(err)
            });
        },
    });

    useEffect(()=>{
        formik.setValues({
            ...formik.values,
            'tgl_penerimaan': '',
            'foto_penerimaan': '',
        })
    },[formValues])
    
    return (
        <>
            <Input
                title="Progress"
                type="text"
                name="progress"
                formik={formik}
                onChange={formik.handleChange}
                onBlur={formik.handleBlur}
                readOnly={true}
            />
            <Input
                title="Month"
                type="date"
                name="tgl_penerimaan"
                formik={formik}
                onChange={formik.handleChange}
                onBlur={formik.handleBlur}
                disabled={isLoading}
            />
            <div className="form-group">
                <label for="foto_penerimaan">Foto (PNG/JPEG)</label>
                <input
                    type="file"
                    id="foto_penerimaan"
                    name="foto_penerimaan"
                    accept=".png, .jpg, .jpeg"
                    className={"form-control " +
                        (formik.touched.foto_penerimaan && formik.errors.foto_penerimaan
                            ? " is-invalid border-danger"
                            : "form-control-solid")}
                    onChange={(event) => {
                    formik.setFieldValue("foto_penerimaan", event.currentTarget.files[0]);
                    }}
                    onBlur={formik.handleBlur}
                />
                {formik.touched.foto_penerimaan && formik.errors.foto_penerimaan && (
                    <p className="error text-danger"><small>{formik.errors.foto_penerimaan}</small></p>
                )}
            </div>
        </>
    );
})