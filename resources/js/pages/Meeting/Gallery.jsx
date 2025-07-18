import React, { useState, useEffect, useRef, forwardRef, useImperativeHandle  } from "react"
import { deleteItem, getIndex, postItemWithFile } from "../../utils/api";
import NoDataAvailable from './../../components/Mikro/NoDataAvailable'
import Viewer from "react-viewer";
import Paginate from "./../../Components/Makro/Filter/Paginate";
import toastify from './../../utils/toastify'
import { confirm } from "../../utils/sweetalert";
import { useParams } from "react-router-dom";


const pathUrl = "gallery"
const limitUploadFile = 5;

export default function Gallery() {
    const imagesGridRef = useRef()

    const handlePushUploadedImage = (pushImage) =>{
        // Memanggil function dari child component
        if (imagesGridRef.current) {
            imagesGridRef.current.handleAcceptNewFile(pushImage);
        }
    }
    return <>
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title">Foto Carousel</h5>
            </div>
            <div class="card-body">
                <Form onPush={handlePushUploadedImage}/>
                <ImagesGrid ref={imagesGridRef}/>
            </div>
        </div>
    </>
}

const ImagesGrid = forwardRef((props, ref) => {
    useImperativeHandle(ref, () => ({
        handleAcceptNewFile(pushImage) {
          let data = images?.items

          data.unshift(pushImage)

          setImages({ ...images, items: data })
        }
    }));
    const { id:idVilla } = useParams()
    const [isViewerOpen, setIsViewerOpen] = useState(false)
    const [imageUrl, setImageUrl] = useState("")
    
    const [images, setImages] = useState({
        items:[],
        total: 0,
        current_page: 0,
        last_page: 0,
        per_page: 0,
    });

    const [filter, setFilter] = useState({
        page: 1,
        limit: 15,
    })

    useEffect(()=>{
        getImages()
    },[filter])

    const getImages = () =>{
        getIndex(`api/meeting-room/${pathUrl}`, filter)
        .then(res=>{
            if(res?.data){
                setImages({
                    items: res?.data,
                    current_page: res?.meta?.current_page || 0,
                    last_page: res?.meta?.last_page || 0,
                    per_page: res?.meta?.per_page || 0,
                    total: res?.meta?.total || 0,
                })
            }
        })
        .catch(err=>toastify({ status: 'ERROR', message: err.message }))
    }

    
    const handleOpenImage = (url)=>{
        setImageUrl(url)
        setIsViewerOpen(true)
    }

    const handleDeleteImage = (id) => {
        confirm(()=>{
            deleteItem(`api/meeting-room/${pathUrl}/${id}`)
            .then(res=>{
                toastify(res)
                setFilter({ ...filter, page: 1 })
            })
            .catch(err=>{
                toastify({ status: 'ERROR', message: err.message })
            })
        })
}

    return <>
        <Viewer
            visible={isViewerOpen}
            onClose={() => { setIsViewerOpen(false); } }
            images={[{src: imageUrl, alt: 'Preview Image'}]}
        />
  
            { images?.items?.length > 0 && <div class="row row-cols-1 row-cols-md-5 g-4 mb-4">
            { images?.items?.map((d,i)=>(
                <div class="col">
                    <div class="card rounded-0">
                        <img
                            src={ d?.url }
                            className="card-img-top rounded-0"
                            alt={"Photo "+i}
                            onClick={()=>handleOpenImage(d.url)}
                        />
                        <div
                            className="file-action-btn text-center my-2 w-100 text-danger"
                            onClick={()=>handleDeleteImage(d.id)}
                        >Delete</div>
                    </div>
                </div>))}
            </div>}
            { images?.items?.length === 0 && <NoDataAvailable/> }

            { images?.last_page > 1 && <div>
                <Paginate
                    pageCount={images?.last_page || 1}
                    onPageChange={(e) => setFilter({ ...filter, page: e.selected + 1  })}
                />
            </div>}
          
    </>
});

function Form({ onPush }) {
    const { id:idVilla } = useParams()
    const [selectedfile, SetSelectedFile] = useState([]);
    const [Files, SetFiles] = useState([]);
    const [isUploading, setIsUploading] = useState(false);

    const filesizes = (bytes, decimals = 2) => {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }

    const InputChange = (e) => {
        // --For Multiple File Input
        SetSelectedFile([]);
        for (let i = 0; i < e.target.files.length; i++) {
            if(i < limitUploadFile){
                let reader = new FileReader();
                let file = e.target.files[i];
                reader.onloadend = () => {
                    SetSelectedFile((preValue) => {
                        return [
                            ...preValue,
                            {
                                id: i,
                                filename: file.name,
                                progress: 0,
                                fileimage: reader.result,
                                file:e.target.files[i],
                                datetime: file.lastModifiedDate.toLocaleString('en-IN'),
                                filesize: filesizes(file.size)
                            }
                        ]
                    });
                }
                if (file) {
                    reader.readAsDataURL(file);
                }
            }
        }
    }


    const DeleteSelectFile = (id) => {
        if(window.confirm("Are you sure you want to delete this Image?")){
            const result = selectedfile.filter((data) => data.id !== id);
            SetSelectedFile(result);
        }else{
            // alert('No');
        }
        
    }

    const FileUploadSubmit = async (e) => {
        e.preventDefault();

        setIsUploading(true)
        let selectedfiles = [...selectedfile]
        // form reset on submit 
        if (selectedfile.length > 0) {
            for (let index = 0; index < selectedfile.length; index++) {
                try {
                    await postItemWithFile(`api/meeting-room/gallery`, { image: selectedfile[index].file })
                    .then( (res)=>{
                        if(res.code !== 200 ) toastify(res)
                        if(res?.data)
                            onPush(res?.data)
                        
                        selectedfiles = selectedfiles.filter(v => v.id !== selectedfile[index].id)
                        SetSelectedFile(selectedfiles)
                    }).catch(err=>console.log(err.message))
                } catch (error) {
                    console.error("There was an error uploading the files!", error);
                }
            }
            // SetSelectedFile(selectedfile);
            await setIsUploading(false)

        } else {
            alert('Please select files');
        }
    }

    return(
       
        <div className="kb-data-box mb-5">
            <form onSubmit={FileUploadSubmit}>
                <p className="m-0 text-secondary">Maksimal { limitUploadFile } foto dengan size 1 foto maksimal 10MB</p>
                <div className="kb-file-upload">
                    <div className="file-upload-box">
                        <input
                            type="file"
                            id="fileupload"
                            accept="image/jpg,image/jpeg, image/png"
                            className="file-upload-input"
                            onChange={InputChange}
                            multiple/>
                        <span>Drag and drop or <span className="file-link">Choose your files</span></span>
                    </div>
                </div>
                    
                <div className="kb-attach-box mb-3">
                    <div class="row row-cols-1 row-cols-md-5 g-4 fs-6">
                        {
                            selectedfile.map((data, index) => {
                                const { id, filename, filetype, fileimage, datetime, filesize } = data;
                                return (
                                    <div class="col" key={id}>
                                        <div>
                                            <img src={fileimage} class="card-img-top rounded-0 mb-3" alt="Photo 1"/>
                                            <h6>{filename}</h6>
                                            <p><span>Size : {filesize}</span></p>
                                            {!isUploading && <button type="button" className="file-action-btn" onClick={() => DeleteSelectFile(id)}>Delete</button>}
                                        </div>
                                    </div>
                                )
                            })
                        }
                    </div>
                </div>
                <div className="d-flex justify-content-between g-1">
                    <button type="submit" className="btn btn-primary me-3" disabled={isUploading}>{ isUploading ? 'Uploading...':'Upload' }</button>
                    {!isUploading && <button type="button" className="btn btn-danger " onClick={()=>SetSelectedFile([])}  disabled={isUploading}>Reset</button>}
                </div>
            </form>
        </div>
    );
}
