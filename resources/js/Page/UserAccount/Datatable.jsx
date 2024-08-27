import React, { useEffect, useState } from 'react';

let prevOrderField = ''
let prevOrderDirection = ''

function Datatable({ data, onEdit, onDelete, onOrder }) {

    useEffect(() => {
        // Inisialisasi DataTables setelah komponen dirender
        if (window.$) {
            const table = $('#tableUserAccount').DataTable({
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
                    { data: 'name', name: 'name', class:"text-start" },
                    { data: 'username', name: 'username' },
                    { data: 'role', name: 'role', class:"text-center text-uppercase" },
                    { data: 'status', name: 'status', class:"text-center text-uppercase" },
                    { data: 'id', name: 'id', class:"text-center" },
                ],
                columnDefs: [ 
                    { 
                        "targets": [3],
                        orderable: true,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            const classStatus = {
                                'admin': 'bg-gradient-info',
                                'guest': 'bg-gradient-warning',
                            };
                            if(cellData){
                                $(td).html( `<span class="badge badge-sm ${classStatus[cellData]} status p-2 pointer">${cellData}</span>`);
                            }
                        }
                    },
                    { 
                        "targets": [4],
                        orderable: true,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            const classStatus = {
                                'active': 'bg-gradient-success',
                                'inactive': 'bg-gradient-secondary',
                            };
                            if(cellData){
                                $(td).html( `<span class="badge badge-sm ${classStatus[cellData]} status p-2 pointer">${cellData}</span>`);
                            }
                        }
                    },
                    { 
                        "targets": [5],
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

        return () => {
            if (window.$) {
                $('#tableUserAccount').DataTable().destroy(true);
            }
        };
    }, []);

    useEffect(() => {
        $('#tableUserAccount').DataTable().clear(); // Menghapus semua data yang ada di tabel
        $('#tableUserAccount').DataTable().rows.add(data.items); // Menambahkan data baru ke tabel
        $('#tableUserAccount').DataTable().draw();
    }, [data]);

    return (<>
      
        <table className="table table-striped table-bordered align-items-center mb-0 text-xs" width="100%" id="tableUserAccount">
            <thead className='bg-danger text-uppercase '>
                <tr>
                    <th class="text-white text-xs font-weight-bolder">No</th>
                    <th class="text-white text-xs font-weight-bolder">Name</th>
                    <th class="text-white text-xs font-weight-bolder ps-2">Username</th>
                    <th class="text-white text-xs font-weight-bolder ps-2">Role</th>
                    <th class="text-white text-xs font-weight-bolder ps-2">Status</th>
                    <th class="text-white text-xs font-weight-bolder ps-2">Action</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </>
    )
}

export default Datatable;