import React from 'react';

function Modals({ onClose, onSubmit, title, isOpen, children }) {
    if(!isOpen) return <></>
    return (<>
        <div class={`modal-backdrop fade show`}></div>
        <div class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style={{ display: 'block' }}>
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{ title }</h5>
                        <button type="button" class="btn-close text-dark" onClick={onClose}>
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        { children }
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary btn-sm" onClick={onClose}>Close</button>
                        <button type="button" class="btn bg-gradient-primary btn-sm" onClick={onSubmit}>Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </>
    );
}

export default Modals;