import React, { useEffect, useState } from 'react';
import { formatNumber } from '../../Utils/formatter';
import Viewer from 'react-viewer';
import { useNavigate } from 'react-router-dom';

let prevOrderField = '';
let prevOrderDirection = '';

function Datatable({ data, onEdit, onOrder }) {

    const navigate = useNavigate()
    const [isViewerOpen, setIsViewerOpen] = useState(false)
    const [imageUrl, setImageUrl] = useState("")


    useEffect(() => {
        // Inisialisasi DataTables setelah komponen dirender
        if (window.$) {
            const table = $('#tableMonitoring').DataTable({
                info: false,
                autoWidth: true,
                fixedHeader: true,
                fixedColumns: true,
                scrollX: true,
                scrollY: '400px',
                paging: false,
                searching: false,
                columns: [
                    { data: 'nomor_order', name: 'nomor_order', orderable: false, class:"text-end"},
                    { data: 'regional', name: 'regional' },
                    { data: 'branch', name: 'branch' },
                    { data: 'cluster', name: 'cluster' },
                    { data: 'type_posmat', name: 'type_posmat' },
                    { data: 'product', name: 'product' },
                    { data: 'qty', name: 'qty', class:"text-end" },
                    { data: 'alamat', name: 'alamat', orderable: false },
                    { data: 'tgl_pesan', name: 'tgl_pesan' },
                    { data: 'due_date', name: 'due_date' },
                    { data: 'approvel_number', name: 'approvel_number', class:"text-end" },
                    { data: 'production_week', name: 'production_week' },
                    { data: 'delivery_week', name: 'delivery_week' },
                    { data: 'tgl_penerimaan', name: 'tgl_penerimaan' },
                    { 
                        data: 'foto_penerimaan', 
                        orderable: false,
                    },
                    { data: 'progress_reporting', name: 'progress_reporting', orderable: false, class:"text-center" },
                    { data: 'progress', name: 'progress', orderable: false },
                    { data: 'nomor_order', name: 'nomor_order', orderable: false, class:"text-end"},
                ],
                columnDefs: [ 
                    { 
                        "targets": [6, 10],
                        orderable: true,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            if(cellData){
                                $(td).text(formatNumber(cellData))
                            }
                        }
                    },{ 
                        "targets": [11],
                        orderable: true,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            if(rowData.production_week && rowData.production_month)
                                $(td).text(rowData.production_month+ " "+(rowData.production_week ? `(${rowData.production_week})` : ''))
                        }
                    },{ 
                        "targets": [12],
                        orderable: true,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            if(rowData.delivery_week && rowData.delivery_month)
                            $(td).text(rowData.delivery_month+ " "+(rowData.delivery_week ? `(${rowData.delivery_week})` : ''))
                        }
                    },
                    { 
                        "targets": [14],
                        orderable: true,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            if(cellData){
                                $(td).html( `<div class="preview-image">
                                    <img src="${cellData}" class="avatar avatar-sm me-3 " alt="foto">
                                    </div>`);
                                $(td).find('.preview-image').on('click', function() {
                                    handleOpenImage(cellData); // Panggil fungsi React di sini
                                });
                            }
                        }
                    },
                    { 
                        "targets": [16],
                        orderable: true,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            const classStatus = {
                                'Propose': 'bg-gradient-secondary',
                                'Approvel': 'bg-gradient-info',
                                'Production': 'bg-gradient-warning',
                                'Delivery': 'bg-gradient-danger',
                                'Accepted': 'bg-gradient-primary',
                            };
                            if(cellData){
                                $(td).html( `<span class="badge badge-sm ${classStatus[cellData]} status p-2 pointer">${cellData}</span>`);
                                $(td).find('.status').on('click', function() {
                                    onEdit(rowData); // Panggil fungsi React di sini
                                });
                            }
                           
                        }
                    },
                    { 
                        "targets": [17],
                        orderable: true,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            if(cellData){
                                $(td).html( `<span class="badge badge-sm bg-gradient-dark reporting-data p-2 pointer">Reporting</span>`);
                                $(td).find('.reporting-data').on('click', function() {
                                    navigate(`/reporting/add?nomor_order=${cellData}`);
                                });
                            }
                        }
                    }
               
                ],
            });

            table.on('order.dt', function() {
                const order = table.order(); // Get current ordering info
                const columnIdx = order[0][0]; // Index of the column being ordered
                const orderDirection = order[0][1]; // 'asc' or 'desc'
        
                // Get the field to order by based on column index
                const orderField = table.column(columnIdx).dataSrc();

                if (prevOrderField !== orderField || prevOrderDirection !== orderDirection) {
                    prevOrderField = orderField;
                    prevOrderDirection = orderDirection;
                    onOrder({ orderField, orderDirection });
                  }
                // Fetch data with the selected order field and direction
            });
        }

        // Fungsi pembersihan untuk menghentikan DataTables saat komponen dihapus
        return () => {
            if (window.$) {
                $('#tableMonitoring').DataTable().destroy(true);
            }
        };
    }, []);


    useEffect(() => {
        $('#tableMonitoring').DataTable().clear(); // Menghapus semua data yang ada di tabel
        $('#tableMonitoring').DataTable().rows.add(data.items); // Menambahkan data baru ke tabel
        $('#tableMonitoring').DataTable().draw();
    }, [data]);


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
        <table className="table table-striped align-items-center mb-0 text-xs" width="100%" id="tableMonitoring">
            <thead className='bg-danger text-uppercase '>
                <tr>
                    <th className="text-white text-xs font-weight-bolder">No Order</th>
                    <th className="text-white text-xs font-weight-bolder ps-2">Regional</th>
                    <th className="text-white text-xs font-weight-bolder ps-2">Branch</th>
                    <th className="text-white text-xs font-weight-bolder ps-2">Cluster</th>
                    <th className="text-white text-xs font-weight-bolder">Type Posmat</th>
                    <th className="text-white text-xs font-weight-bolder">Product</th>
                    <th className="text-white text-xs font-weight-bolder">Qty</th>
                    <th className="text-white text-xs font-weight-bolder">Alamat</th>
                    <th className="text-white text-xs font-weight-bolder">Tgl Pesan</th>
                    <th className="text-white text-xs font-weight-bolder">Due Date</th>
                    <th className="text-white text-xs font-weight-bolder">Approvel Number</th>
                    <th className="text-white text-xs font-weight-bolder">Production Week</th>
                    <th className="text-white text-xs font-weight-bolder">Delivery Week</th>
                    <th className="text-white text-xs font-weight-bolder">Tgl Penerimaan</th>
                    <th className="text-white text-xs font-weight-bolder">Foto Penerimaan</th>
                    <th className="text-white text-xs font-weight-bolder">Progress</th>
                    <th className="text-white text-xs font-weight-bolder">Status</th>
                    <th className="text-white text-xs font-weight-bolder">Reporting</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        </>
    )
}

export default Datatable;