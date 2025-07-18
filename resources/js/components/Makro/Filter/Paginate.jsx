import React from 'react';
import ReactPaginate from 'react-paginate';

function Paginate({ pageCount, onPageChange}) {
    return (<ReactPaginate
            pageCount={pageCount || 1}
            marginPagesDisplayed={2}
            pageRangeDisplayed={5}
            onPageChange={onPageChange}
            previousLabel={"Prev"}
            nextLabel={"Next"}
            breakLabel={"..."}
            breakClassName={"page-item"}
            breakLinkClassName={"page-link"}
            pageClassName={"page-item"}
            pageLinkClassName={"page-link"}
            previousClassName={"page-item"}
            previousLinkClassName={"page-link"}
            nextClassName={"page-item"}
            nextLinkClassName={"page-link"}
            activeClassName={"active"}
            containerClassName={'pagination justify-content-center text-dark mt-3'}
        /> 
    );
}

export default Paginate;