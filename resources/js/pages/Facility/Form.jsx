import React, { useContext, useEffect, useState, useRef } from 'react';
import { useFormik } from 'formik';
import {createSchema, updateSchema} from '../../Schemas/FacilitySchema'
import { getIndex,  postItemWithFile, updateItemWithFile } from '../../Utils/api';
import toastify from '../../Utils/toastify';
import { useNavigate, useParams } from 'react-router-dom';
import { GlobalContext } from '../../contexts/GlobalContext';

import Input from './../../Components/Makro/Form/Input'
import Select from './../../Components/Makro/Form/Select'
import ButtonSubmit from '../../Components/Mikro/ButtonSubmit';

import InputFile from '../../Components/Makro/Form/InputFile';

import BGDefault from './../../assets/Background/bg_default.png'


const pathUrl  ='facility'
function Form(props) {
    const { id } = useParams()


    const { setBreadcrumbs } = useContext(GlobalContext);

    useEffect(()=>{
        const title = id > 0 ? "Edit":'Add'
        setBreadcrumbs({
            path:['Facility',title+ ' Facility'],
            title:title+ ' Facility',
        })
    },[])


    const [isLoading, setIsLoading] = useState(false)
    const [imagePreview, setImagePreview] = useState(null)
    
    const navigate = useNavigate()

    
    const formik = useFormik({
        initialValues: {
            'name': '',
            'status': '',
            'description': '',
            'image': null,
        },
        validationSchema: parseInt(id) > 0 ?  updateSchema : createSchema,
        onSubmit: values => {
            setIsLoading(true)
            
            if(!id)
                postItemWithFile(`api/${pathUrl}`, values)
                .then(res => {
                    setIsLoading(false)
                    toastify(res)
                    if(res.code === 200)
                        navigate(`/${pathUrl}`)
                })
                .catch(err => {
                    setIsLoading(false)
                    toastify(err)
                });
            else
                updateItemWithFile(`api/${pathUrl}/${id}`, values)
                .then(res => {
                    setIsLoading(false)
                    toastify(res)

                    if(res.code === 200)
                        navigate(`/${pathUrl}`)
                })
                .catch(err => {
                    setIsLoading(false)
                    toastify(err)
                });
            
        },
    });



    useEffect(()=>{
        if(parseInt(id) > 0 ){
            getIndex(`api/${pathUrl}/${id}`)
            .then(res=>{
                formik.setValues({
                    'name': res?.data?.name || '',
                    'status': res?.data?.status || '',
                    'description': res?.data?.description || '',
                    'image': null,
                  });

                setImagePreview(res?.data?.thumbnail)
            })
            .catch(err=>{
                toastify({ status: 'ERROR', message:err.message })
            })
        }
    },[])
    const handleImageChange = (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onloadend = () => {
                setImagePreview(reader.result);
            };
            reader.readAsDataURL(file);
           
        }
    };
    return (
        <div className="container-fluid py-4">
            <div className="row">
                <div className="col-12">
                    <div className="card">
                        <div className="card-header p-2 mx-3 mt-3">
                            <h6>{id > 0 ? "Edit":'Add'} Facility</h6>
                        </div>
                        <form
                            className="form"
                            id="kt_form"
                            onSubmit={formik.handleSubmit}>
                            <div className="card-body">
                                <div className='row'>
                                    <div className='col-lg-4 col-md-6'>
                                        <div className='text-center'>
                                            <img
                                                src={ imagePreview || BGDefault }
                                                className="rounded img-fluid mb-4"
                                                style={{ maxWidth: '300px' }}
                                                alt={"Photo "}
                                            />
                                            {formik?.values?.image && <div
                                                className="file-action-btn text-center my-2 w-100 text-danger"
                                            >Delete</div>}
                                        </div>
                                        <InputFile
                                            title="Upload Gambar"
                                            name="image"
                                            accept=".png, .jpg, .jpeg"
                                            formik={formik}
                                            onChange={(event) => {
                                                handleImageChange(event)
                                                formik.setFieldValue("image", event.currentTarget.files[0]);
                                            }}
                                            onBlur={formik.handleBlur}
                                        />
                                        
                                    </div>
                                </div>
                                <div className='row'>
                                    <div className='col-xl-6 col-lg-6 col-md-12'>
                                        <Input
                                            type="text"
                                            title="Nama Fasilitas"
                                            name="name"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                            placeholder="Masukkan nama fasilitas"
                                        />
                                    </div>
                                </div>
                                
                                <div className='row'>
                                    <div className='col-xl-3 col-lg-4 col-md-6 '>
                                        <Select
                                            title="Status Publikasi"
                                            name="status"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            options={[
                                                { value:"PUBLISHED", label:"PUBLISHED" },
                                                { value:"DRAFT", label:"DRAFT" },
                                            ]}
                                            disabled={isLoading}
                                        />
                                    </div>
                                </div>
                                <div className='row'>
                                    <div className='col-xl-8 col-lg-10 col-md-12 '>
                                        <Textarea
                                            title="Deskripsi"
                                            name="description"
                                            rows="4"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                        />
                                    </div>
                                </div>
                            </div>
                            <div className='card-footer text-start'>
                                <ButtonSubmit disabled={isLoading} label={"Simpan"} />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Form;

import ReactQuill from 'react-quill';
import 'react-quill/dist/quill.snow.css';
import Textarea from '../../Components/Makro/Form/Textarea';
const QuillEditor = ({ name, value, onChange }) => {
    const editorRef = useRef(null);

    useEffect(() => {
        const editor = new Quill(editorRef.current, {
            debug: 'info',
            modules: {
                toolbar: true,
            },
            placeholder: 'Compose an epic...',
            theme: 'snow'
        });

        editor.on('text-change', () => {
            onChange(editor.root.innerHTML);
        });

        // Set initial value
        editor.root.innerHTML = value;

        return () => {
            editor.off('text-change');
        };
    }, [value, onChange]);

    return <div ref={editorRef} />;
};