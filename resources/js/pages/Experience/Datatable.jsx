import React, { useEffect, useState } from 'react';
import Viewer from 'react-viewer';
let prevOrderField = ''
let prevOrderDirection = ''

function Datatable({ data, onDelete, onEdit, onOrder }) {
    const [isViewerOpen, setIsViewerOpen] = useState(false)
    const [imageUrl, setImageUrl] = useState("")

    useEffect(() => {
        // Inisialisasi DataTables setelah komponen dirender
        if (window.$) {
            const table = $('#tableListKonten').DataTable({
                info: false,
                autoWidth: true,
                fixedHeader: true,
                fixedColumns: true,
                scrollX: true,
                scrollY: '60vH',
                paging: false,
                searching: false,
                columns: [
                    { data: 'no', name: 'no' },
                    { data: 'title', name: 'title' },
                    { data: 'status', name: 'status' },
                    { data: 'id', name: 'id', clas:"align-middle text-center" },
                ],
                columnDefs: [ 
                    { 
                        "targets": [3],
                        orderable: true,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).html( `<div class="d-flex align-items-center justify-content-center gap-1">
                                <div class="btn btn-warning px-3 py-1 mb-0 btnEdit"> Edit </div>
                                <div class="btn btn-danger px-3 py-1 mb-0 btnDelete"> Delete </div>
                            </div>`);
                            $(td).find('.btnEdit').on('click', function() {
                                onEdit(cellData); // Panggil fungsi React di sini
                            });
                            $(td).find('.btnDelete').on('click', function() {
                                onDelete(cellData); // Panggil fungsi React di sini
                            });
                        }
                    },
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
                $('#tableListKonten').DataTable().destroy(true);
            }
        };
    }, []);
    useEffect(() => {
        $('#tableListKonten').DataTable().clear(); // Menghapus semua data yang ada di tabel
        $('#tableListKonten').DataTable().rows.add(data.items); // Menambahkan data baru ke tabel
        $('#tableListKonten').DataTable().draw();
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
        <table className="table table-striped align-items-center mb-0 text-xs border-0" width="100%" id="tableListKonten">
            <thead className='bg-danger text-uppercase'>
                <tr>
                    <th class="text-uppercase text-white text-xxs font-weight-bolder" style={{ width:"20px" }}>No</th>
                    <th class="text-uppercase text-white text-xxs font-weight-bolder">Judul Konten</th>
                    <th class="text-uppercase text-white text-xxs font-weight-bolder ps-2">Status</th>
                    <th class="text-center text-uppercase text-white text-xxs font-weight-bolder">Action</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </>
    )
}

export default Datatable;