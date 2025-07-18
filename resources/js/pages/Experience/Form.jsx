import React, { useContext, useEffect, useState, useRef } from 'react';
import { useFormik } from 'formik';
import {createSchema, updateSchema} from '../../Schemas/ExperienceSchema'
import { getIndex,  postItemWithFile, updateItemWithFile } from '../../Utils/api';
import toastify from '../../Utils/toastify';
import { useNavigate, useParams } from 'react-router-dom';
import { GlobalContext } from '../../contexts/GlobalContext';

import Input from './../../Components/Makro/Form/Input'
import Select from './../../Components/Makro/Form/Select'
import ButtonSubmit from '../../Components/Mikro/ButtonSubmit';

import InputFile from '../../Components/Makro/Form/InputFile';
import BGDefaultPortrait from './../../assets/Background/bg_default_portrait.png'



const pathUrl = "experience"
function Form(props) {
    const { id } = useParams()


    const { setBreadcrumbs } = useContext(GlobalContext);

    useEffect(()=>{
        const title = id > 0 ? "Edit":'Add'
        setBreadcrumbs({
            path:['Experience',title+ ' Experience'],
            title:title+ ' Experience',
        })
    },[])


    const [isLoading, setIsLoading] = useState(false)
    const [imagePreview, setImagePreview] = useState(null)
    
    const navigate = useNavigate()

    
    const formik = useFormik({
        initialValues: {
            'title': '',
            'status': '',
            'short_description': '',
            'content': '',
            'thumbnail': null,
        },
        validationSchema: parseInt(id) > 0 ?  updateSchema : createSchema,
        onSubmit: values => {
            setIsLoading(true)
            console.log(values)
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
                    'title': res?.data?.title || '',
                    'status': res?.data?.status || '',
                    'short_description': res?.data?.short_description || '',
                    'content': res?.data?.content || '',
                    'thumbnail': null,
                });

                setImagePreview( res?.data?.thumbnail )
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

    console.log(formik.errors)
    return (
        <div className="container-fluid py-4">
            <div className="row">
                <div className="col-12">
                    <div className="card">
                        <div className="card-header p-2 mx-3 mt-3">
                            <h6>{id > 0 ? "Edit":'Add'} Experience</h6>
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
                                                src={ imagePreview || BGDefaultPortrait }
                                                className="rounded img-fluid mb-4"
                                                style={{ maxHeight: '500px' }}
                                                alt={"Photo "}
                                            />
                                            {formik?.values?.thumbnail && <div
                                                className="file-action-btn text-center my-2 w-100 text-danger"
                                            >Delete</div>}
                                        </div>
                                        <InputFile
                                            title="Upload Gambar"
                                            name="thumbnail"
                                            accept=".png, .jpg, .jpeg"
                                            formik={formik}
                                            onChange={(event) => {
                                                handleImageChange(event)
                                                formik.setFieldValue("thumbnail", event.currentTarget.files[0]);
                                            }}
                                            onBlur={formik.handleBlur}
                                            tint={<p><small>* upload gambar dalam ratio portrait </small></p>}
                                        />
                                        
                                        
                                    </div>
                                </div>
                                <div className='row'>
                                    <div className='col-xl-6 col-lg-6 col-md-12'>
                                        <Input
                                            type="text"
                                            title="Judul Konten"
                                            name="title"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                            placeholder="Masukkan judul konten"
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
                                            rows="4"
                                            title="Deskripsi Singkat"
                                            name="short_description"
                                            formik={formik}
                                            onChange={formik.handleChange}
                                            onBlur={formik.handleBlur}
                                            disabled={isLoading}
                                        />
                                    </div>
                                </div>
                                <div className='row'>
                                    <div className='col-xl-8 col-lg-10 col-md-12 '>
                                        <div className="form-group">
                                            <label for="kv_cdr">Isi Konten</label>
                                            <ReactQuill 
                                                theme="snow"
                                                modules={{
                                                    toolbar:[
                                                        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                                                        ['blockquote'],
                                                        // ['link', 'image', 'video', 'formula'],
                                                        ['link'],
                                                      
                                                        [{ 'header': 1 }, { 'header': 2 }],               // custom button values
                                                        [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
                                                        [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                                                        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                                                        [{ 'direction': 'rtl' }],                         // text direction
                                                      
                                                        [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
                                                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                                                      
                                                        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                                                        [{ 'font': [] }],
                                                        [{ 'align': [] }],
                                                      
                                                        ['clean']                                         // remove formatting button
                                                      ]
                                                    }}
                                                value={formik.values.content}
                                                onChange={value => formik.handleChange({target:{name:'content',value}})}
                                                onBlur={value=> formik.handleBlur({target:{name:'content',value}})}
                                                readOnly={isLoading}
                                            />
                                            {formik?.touched?.content && formik?.errors?.content && (
                                                <p className="error text-danger"><small>{formik.errors.content}</small></p>
                                            )}
                                        </div>
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