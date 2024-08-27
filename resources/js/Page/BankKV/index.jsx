import React, { useContext, useEffect, useState } from 'react';
import FilterSearch from './../../Components/Makro/Filter/FilterSearch'
import { getIndex } from '../../Utils/api';
import { GlobalContext } from '../../Context/GlobalContext';
import Viewer from 'react-viewer';
import Paginate from '../../Components/Makro/Filter/Paginate';
function BankKV(props) {
    const { setBreadcrumbs } = useContext(GlobalContext);

    const [isViewerOpen, setIsViewerOpen] = useState(false)
    const [imageUrl, setImageUrl] = useState("")
    const [filter, setFilter] = useState({
        page: 1,
        search: '',
    })
    const [data, setData] = useState({
        items:[],
        total: 0,
        current_page: 0,
        last_page: 0,
        per_page: 0,
    });

    useEffect(()=>{
        setBreadcrumbs({
            path:['Bank KV'],
            title:'Bank KV',
        })
    },[])

    

    useEffect(()=>{
        getData()
    },[filter])

    function getData(){
        getIndex(`api/bank-kv`, filter)
        .then(res=>{
            if(res?.data){
                setData({
                    items: res?.data,
                    current_page: res?.meta?.current_page || 0,
                    last_page: res?.meta?.last_page || 0,
                    per_page: res?.meta?.per_page || 0,
                    total: res?.meta?.total || 0,
                })
            }
        })
        .catch(err=>{
            console.log(err)
        })
    }
    const handleOpenImage = (url)=>{
        setImageUrl(url)
        setIsViewerOpen(true)
    }

    return (
        <>
        <Viewer
            visible={isViewerOpen}
            onClose={() => { setIsViewerOpen(false); } }
            images={[{src: imageUrl, alt: 'Preview Image'}]}
        />
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="mb-1">Gallary KV</h6>
                                    <p class="text-sm">Kumpulan KV</p>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-end align-items-center">
                                        <FilterSearch onChange={(e)=>setFilter({ ...filter, search: e.value })} /> 
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="row">
                                    { data?.items?.length > 0 && data?.items?.map((d,i)=>(
                                        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                                            <div class="card card-blog card-plain shadow shadow-xl border-radius-xl">
                                                <div class="position-relative" style={{height: '250px'}}>
                                                    <div class="d-block " onClick={()=>handleOpenImage(d.kv)} style={{ width: '100%', height: '100%' }}>
                                                        <img src={d.kv} alt="img-blur-shadow" class="img-fluid  border-radius-xl" style={{ minWidth: '100%', height: '100%', objectFit: 'cover' }}/>
                                                    </div>
                                                </div>
                                                <div class="card-body ">
                                                    <h6> { d.title } </h6>
                                                    <p class="mb-4 text-sm">
                                                        Produk: { d.produk }<br/>
                                                        Jenis: { d.jenis }
                                                    </p>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <a href={ d.link_download } type="button" class="btn btn-outline-primary btn-sm mb-0">Unduh</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                                { data?.last_page > 1 && <Paginate
                                    pageCount={data?.last_page || 1}
                                    onPageChange={(e) => setFilter({ ...filter, page: e.selected + 1  })}
                               /> }
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </>
    );
}

export default BankKV;