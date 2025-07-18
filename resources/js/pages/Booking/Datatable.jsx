import React, { useEffect, useState } from 'react';
import { generateTableHeaders, getDaysInMonth } from '../../utils/date';
import { date } from 'yup';

const pathUrl = "booking"
function Datatable({ data, year_month, onChange }) {
    const [dateArray, setDateArray] = useState([]);

    
    useEffect(() => {
        const ft = year_month.split('-')
        setDateArray(generateTableHeaders(getDaysInMonth(ft[0], ft[1]).days))
    }, [year_month]);

    return (<>
        
        <div className='table-responsive'>
            <table className="table table-hover align-items-center mb-0 text-xs border-0" width="100%">
                <thead className='text-uppercase' style={{ background:"#eec36d" }}>
                    <tr>
                        <th className="text-uppercase text-white text-center text-xxs font-weight-bolder p-1">Villa</th>
                        <th className="text-uppercase text-white text-center text-xxs font-weight-bolder p-1">Nomor</th>
                        {dateArray.map((_, index) => (
                            <th className='text-uppercase text-white text-center text-xxs font-weight-bolder p-1' key={index}>{index + 1}</th>
                        ))}
                    </tr>
                </thead>
                <tbody>
                    { data.map((d,i)=><tr>
                        <td className="text-xxs fw-bold">{ d.villa }</td>
                        <td className="text-xxs fw-bold">{ d.number }</td>
                        {dateArray.map((_, index) => (
                            <td className='text-center text-xxs' key={index}>
                                <input
                                    type='checkbox'
                                    checked={parseInt(d['d_'+(index+1)]) === 1 ? true:false}
                                    onChange={(e) => onChange({
                                        villa_id: d.villa_id,
                                        room_number: d.number,
                                        day: index+1,
                                        date: year_month+'-'+String(index+1).padStart(2, '0'),
                                        sts: parseInt(d['d_'+(index+1)]) === 1? 0:1,
                                        villa: d.villa,
                                        villa_count: d.villa_count
                                    })}
                                />
                            </td>
                        ))}
                    </tr>
                    ) }
                </tbody>
            </table>
        </div>
    </>
    )
}

export default Datatable;