import React, { useContext, useEffect } from 'react';
import Breadcrumb from './Breadcrumb'
import { GlobalContext } from '../../contexts/GlobalContext';

function Navbar(props) {
const { authUser } = useContext(GlobalContext);
return (
    <nav className="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div className="container-fluid py-1 px-3">
      <Breadcrumb />
      <div className="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <div className="ms-md-auto pe-md-3 d-flex align-items-center">
         
        </div>
        <ul className="navbar-nav  justify-content-end">
          <li className="nav-item d-flex pe-2 align-items-center">
            <div className="nav-link text-body font-weight-bold px-0">
              <i className="fa fa-user me-sm-1"></i>
              <span className="d-sm-inline d-none">{ authUser?.name }</span>
            </div>
          </li>
          <li className="nav-item d-flex align-items-center">
            <a href={document.querySelector('meta[name="base-url"]').getAttribute('content')+"/logout"} className="nav-link text-body font-weight-bold px-0">
              <span className="d-sm-inline d-none">Logout</span>
              <i className="fa fa-sign-out-alt me-sm-1"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  );
}

export default Navbar;