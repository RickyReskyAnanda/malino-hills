import React, { useEffect, useState } from 'react';
import FilterSelect from '../../Components/Makro/Filter/FilterSelect';
import FilterSelectApi from '../../Components/Makro/Filter/FilterSelectApi';
import FilterSearch from '../../Components/Makro/Filter/FilterSearch';

function Filter({ onChange }) {
    const [filter, setFilter] = useState({
        regional: '',
        branch: '',
        cluster: '',
        regional: '',
        product: '',
        type_posmat: '',
        search: '',
    })

    useEffect(()=>{
        onChange(filter)
    },[filter])
    
    return (
        <div className="row mb-3">

            <div className="col-md-3">
                <FilterSearch onChange={e =>setFilter({ ...filter, search: e.value })}/>
            </div>
            <div className="col-md-3">
                <FilterSelect
                    title={"Regional"}
                    name={"regional"}
                    options={[
                        {value: "KALIMANTAN", label: "KALIMANTAN"},
                        {value: "SULAWESI", label: "SULAWESI"},
                        {value: "PUMA", label: "PUMA"},
                    ]}
                    onChange={e =>setFilter({ ...filter, regional: e.value })} />
            </div>
            <div className="col-md-3">
                <FilterSelectApi
                    title="Branch"
                    name="branch"
                    url={`api/filter/branches`}
                    parent={filter?.regional}
                    onChange={e =>setFilter({ ...filter, branch: e.value })} />
            </div>
            <div className="col-md-3">
                <FilterSelectApi
                    title="Cluster"
                    name="cluster"
                    url={`api/filter/clusters`}
                    parent={filter?.branch}
                    onChange={e =>setFilter({ ...filter, cluster: e.value })} />
            </div>
            <div className="col-md-3">
                <FilterSelect
                    title="Type Posmat"
                    name="type_posmat"
                    options={[
                        {value: "Poster", label: "Poster"},
                        {value: "Layar Toko", label: "Layar Toko"},
                        {value: "x Banner", label: "x Banner"},
                        {value: "Sticker Perdana", label: "Sticker Perdana"},
                        {value: "Tripod", label: "Tripod"},
                        {value: "Sticker Etakase", label: "Sticker Etakase"},
                    ]}
                    onChange={e =>setFilter({ ...filter, type_posmat: e.value })}
                />
            </div>
            <div className="col-md-3">
                <FilterSelect
                    title="Produk"
                    name="product"
                    options={[
                        {value:"Super Seru", label:"Super Seru"},
                        {value:"Telkomsel Lite", label:"Telkomsel Lite"},
                        {value:"ByU", label:"ByU"},
                        {value:"Orbit", label:"Orbit"},
                        {value:"Jitu 1", label:"Jitu 1"},
                        {value:"MyTsel", label:"MyTsel"},
                        {value:"Kartu Halo", label:"Kartu Halo"},
                    ]}
                    onChange={e =>setFilter({ ...filter, product: e.value })}
                />
            </div>
        </div>
    );
}

export default Filter;