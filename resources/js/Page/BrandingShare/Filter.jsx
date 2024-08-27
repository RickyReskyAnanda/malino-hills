import React, { useEffect, useState } from 'react';
import FilterSelect from '../../Components/Makro/Filter/FilterSelect';
import FilterSelectApi from '../../Components/Makro/Filter/FilterSelectApi';
import FilterInput from '../../Components/Makro/Filter/FilterInput';
const now = new Date();
const year = now.getFullYear();
const month = String(now.getMonth() + 1).padStart(2, '0'); // +1 karena bulan mulai dari 0

// Format bulan dan tahun sebagai YYYY-MM
const formattedMonth = `${year}-${month}`;

function Filter({ onChange }) {
    const [filter, setFilter] = useState({
        regional: '',
        branch: '',
        cluster: '',
        kabupaten: '',
        month: formattedMonth,
        week: '',
    })

    useEffect(()=>{
        onChange(filter)
    },[filter])
    
    return (
        <div className="row mb-3">

            <div className="col-md-3">
                <FilterInput
                    title="Tahun Bulan" 
                    type="month"
                    value={filter?.month}
                    onChange={e =>setFilter({ ...filter, month: e.value })} />
            </div>
            <div className="col-md-3">
                <FilterSelect
                    title={"Week"}
                    name={"week"}
                    options={[
                        {value: "W1", label: "W1"},
                        {value: "W2", label: "W2"},
                        {value: "W3", label: "W3"},
                        {value: "W4", label: "W4"},
                    ]}
                    onChange={e =>setFilter({ ...filter, week: e.value })} />
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
                <FilterSelectApi
                    title="Kabupaten"
                    name="kabupaten"
                    url={`api/filter/kabupaten`}
                    parent={filter?.cluster}
                    onChange={e =>setFilter({ ...filter, kabupaten: e.value })} />
            </div>
        </div>
    );
}

export default Filter;