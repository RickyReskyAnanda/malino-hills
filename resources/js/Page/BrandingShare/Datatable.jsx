import React, { useEffect } from 'react';
function Datatable({ data }) {
    useEffect(() => {
        // Inisialisasi DataTables setelah komponen dirender
        if (window.$) {
            $('#tableBrandingShare').DataTable({
                info: false,
                autoWidth: true,
                fixedHeader: true,
                fixedColumns: true,
                scrollX: true,
                scrollY: '400px',
                paging: false,
                searching: false,
                ordering :false,
                columns: [
                    { data: 'teritory', name: 'teritory'},
                    { data: 'telkomsel', name: 'telkomsel', class:"text-end" },
                    { data: 'indihome', name: 'indihome', class:"text-end" },
                    { data: 'isat_3', name: 'isat_3', class:"text-end" },
                    { data: 'xl_smart', name: 'xl_smart', class:"text-end" },
                ],
                columnDefs: [ 
                    { 
                        "targets": [0,1,2,3,4],
                        "createdCell": function (td, cellData, rowData, row, col) {
                            const teritory = ['AREA', 'REGIONAL', 'BRANCH', 'SUBBRANCH', 'CLUSTER', 'KABUPATEN']
                            if ( teritory.includes(rowData.teritory) ) {
                                $(td).addClass("color-gray text-dark font-weight-bold")
                                $(td).css({
                                    'background-color': '#E0E0E0',
                                });
                            }
                        }
                    },
               
               
                ],
            });
        }

        // Fungsi pembersihan untuk menghentikan DataTables saat komponen dihapus
        return () => {
            if (window.$) {
                $('#tableBrandingShare').DataTable().destroy(true);
            }
        };
    }, []);


    useEffect(() => {
        $('#tableBrandingShare').DataTable().clear(); // Menghapus semua data yang ada di tabel
        $('#tableBrandingShare').DataTable().rows.add(data); // Menambahkan data baru ke tabel
        $('#tableBrandingShare').DataTable().draw();
    }, [data]);


    return (
        <>
        <table className="table table-bordered align-items-center mb-0 text-xs" width="100%" id="tableBrandingShare">
            <thead className='bg-danger text-uppercase '>
                <tr>
                    <th class="text-uppercase bg-danger text-light font-weight-bolder ps-2">Teritory</th>
                    <th class="text-uppercase bg-danger text-light font-weight-bolder text-center">%Telkomsel</th>
                    <th class="text-uppercase bg-danger text-light font-weight-bolder text-center">%Indihome</th>
                    <th class="text-uppercase bg-danger text-light font-weight-bolder text-center">%ISAT-3</th>
                    <th class="text-uppercase bg-danger text-light font-weight-bolder text-center">%XL-Smart</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        </>
    )
}

export default Datatable;