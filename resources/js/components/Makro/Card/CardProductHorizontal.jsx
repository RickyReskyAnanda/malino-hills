import React from 'react';
import { useNavigate } from 'react-router-dom';
import ImageWithFallback from '../../Mikro/ImageWithFallback';
import BGDefault from './../../../assets/Background/bg_default.png';
import ButtonDelete from './../../Mikro/ButtonDelete'
import ButtonEdit from './../../Mikro/ButtonEdit'
function CardProductHorizontal({ url, name, description, status, imageUrl,onDelete, added1=null }) {
    const navigate = useNavigate()
    return (
        <div
            className="card m-0 d-flex flex-row border p-3 pointer"
        >
            <div className="card-img" style={{ 
                width: '180px',
                height: '180px',
                backgroundSize: 'cover',
                backgroundPosition: 'center',
                flexShrink: 0,
                backgroundImage: "url("+imageUrl+")"
            }}></div>
            <div className="card-body d-flex flex-column justify-content-between py-0">
                <div>
                    <h5 className="card-title">{ name }</h5>
                    {status  && <p className="mb-2"><span className='badge bg-secondary'>{ status }</span></p>}
                    <p className="card-text">{ description }</p>
                    { added1 }
                </div>
                <div className='d-flex gap-3'>
                    <ButtonEdit onClick={()=>navigate(url)}/>
                    { onDelete && <ButtonDelete onClick={()=>onDelete()}/> } 
                </div>
            </div>
        </div>
    );
}

export default CardProductHorizontal;