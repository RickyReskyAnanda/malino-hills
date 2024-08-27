import React, { useEffect, useState } from 'react';
import Viewer from 'react-viewer';
let prevOrderField = '';
let prevOrderDirection = '';
function Datatable({ data, onEdit, onOrder }) {

    const [isViewerOpen, setIsViewerOpen] = useState(false)
    const [imageUrl, setImageUrl] = useState("")
    const [ft, setFt] = useState({ orderField:'no', orderDirection:'asc' })

    useEffect(() => {
        
        // Inisialisasi DataTables setelah komponen dirender
        if (window.$) {
            const table = $('#tableReporting').DataTable({
                info: false,
                autoWidth: true,
                fixedHeader: true,
                fixedColumns: true,
                scrollX: true,
                scrollY: '400px',
                paging: false,
                searching: false,
                columns: [
                    { data: 'no', name: 'no', orderable: false, class:"text-end" },
                    { data: 'nomor_order', name: 'nomor_order', class:"text-end" },
                    { data: 'regional', name: 'regional' },
                    { data: 'branch', name: 'branch' },
                    { data: 'cluster', name: 'cluster' },
                    { data: 'type', name: 'type', class:"text-center" },
                    { data: 'nama', name: 'nama' },
                    { data: 'outlet_id', name: 'outlet_id' },
                    { data: 'alamat', name: 'alamat' },
                    { data: 'foto', orderable: false, class:"text-center" }
                ],
                columnDefs: [ 
                    // { 
                    //     "targets": [6, 10],
                    //     orderable: true,
                    //     "createdCell": function (td, cellData, rowData, row, col) {
                    //         if(cellData){
                    //             $(td).text(formatNumber(cellData))
                    //         }
                    //     }
                    // },{ 
                    //     "targets": [11],
                    //     orderable: true,
                    //     "createdCell": function (td, cellData, rowData, row, col) {
                    //         if(rowData.production_week && rowData.production_month)
                    //             $(td).text(rowData.production_month+ " "+(rowData.production_week ? `(${rowData.production_week})` : ''))
                    //     }
                    // },{ 
                    //     "targets": [12],
                    //     orderable: true,
                    //     "createdCell": function (td, cellData, rowData, row, col) {
                    //         if(rowData.delivery_week && rowData.delivery_month)
                    //         $(td).text(rowData.delivery_month+ " "+(rowData.delivery_week ? `(${rowData.delivery_week})` : ''))
                    //     }
                    // },
                    { 
                        "targets": [9],
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
                    // { 
                    //     "targets": [15],
                    //     orderable: true,
                    //     "createdCell": function (td, cellData, rowData, row, col) {
                    //         const classStatus = {
                    //             'Propose': 'bg-gradient-secondary',
                    //             'Approvel': 'bg-gradient-info',
                    //             'Production': 'bg-gradient-warning',
                    //             'Delivery': 'bg-gradient-danger',
                    //             'Accepted': 'bg-gradient-primary',
                    //         };
                    //         if(cellData){
                    //             $(td).html( `<span class="badge badge-sm ${classStatus[cellData]} status p-2 pointer">${cellData}</span>`);
                    //             $(td).find('.status').on('click', function() {
                    //                 onEdit(rowData); // Panggil fungsi React di sini
                    //             });
                    //         }
                           
                    //     }
                    // },
               
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
                $('#tableReporting').DataTable().destroy(true);
            }
        };
    }, []);


    useEffect(() => {
        $('#tableReporting').DataTable().clear(); // Menghapus semua data yang ada di tabel
        $('#tableReporting').DataTable().rows.add(data.items); // Menambahkan data baru ke tabel
        $('#tableReporting').DataTable().draw();
    }, [data]);


    const handleOpenImage = (url)=>{
        setImageUrl(url)
        setIsViewerOpen(true)
    }

    return (<>
        <Viewer
            visible={isViewerOpen}
            onClose={() => { setIsViewerOpen(false); } }
            images={[{src: imageUrl, alt: 'Preview Image'}]}
        />
      
        <table className="table table-striped table-bordered align-items-center mb-0 text-xs" width="100%" id="tableReporting">
            <thead className='bg-danger text-uppercase '>
                <tr>
                    <th class="text-white text-xs font-weight-bolder">No</th>
                    <th class="text-white text-xs font-weight-bolder">No Order</th>
                    <th class="text-white text-xs font-weight-bolder ps-2">Regional</th>
                    <th class="text-white text-xs font-weight-bolder ps-2">Branch</th>
                    <th class="text-white text-xs font-weight-bolder ps-2">Cluster</th>
                    <th class="text-white text-xs font-weight-bolder">Type</th>
                    <th class="text-white text-xs font-weight-bolder">Nama</th>
                    <th class="text-white text-xs font-weight-bolder">Id Outlet</th>
                    <th class="text-white text-xs font-weight-bolder">Alamat</th>
                    <th class="text-white text-xs font-weight-bolder">Foto</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </>
    )
}

export default Datatable;