import React, { useContext, useEffect, useState } from 'react';
import { useLocation } from 'react-router-dom';
import { Link } from 'react-router-dom';
import {
    HomeIcon,
    DashboardIcon,
    OrderIcon,
    MonitoringIcon,
    ReportingIcon,
    BrandingShareIcon,
    BankKVIcon,
    UploadKVIcon,
    UserAccountIcon,
} from './../Mikro/SVGIcon'
import LogoImg from '../../Assets/Logo/logo_greats.png'
import { GlobalContext } from '../../Context/GlobalContext';
import { role } from '../../Contants/usertype';

function Sidebar(props) {
    const { authUser } = useContext(GlobalContext);
    
    const location = useLocation();
  
    const [menus, set_menus] = useState([
        {
            title: "Home",
            icon: <HomeIcon/>,
            path: "/"
        },
        {
            title: "Dashboard",
            icon: <DashboardIcon/>,
            path: "/dashboard"
        },
        {
            title: "Order",
            icon: <OrderIcon/>,
            path: "/order"
        },
        {
            title: "Monitoring",
            icon: <MonitoringIcon/>,
            path: "/monitoring"
        },
        {
            title: "Reporting",
            icon: <ReportingIcon/>,
            child: [
                {
                    title: "Add Report",
                    path: "/reporting/add"
                },
                {
                    title: "Reporting",
                    path: "/reporting"
                },
            ]
        },
        {
            title: "Branding Share",
            icon: <BrandingShareIcon/>,
            path: "/branding-share"
        },
        {
            title: "Bank KV",
            icon: <BankKVIcon/>,
            path: "/bank-kv"
        },
        {
            title: "Upload KV",
            icon: <UploadKVIcon/>,
            role: role?.admin,
            child: [
                {
                    title: "Upload KV",
                    path: "/upload-kv/add"
                },
                {
                    title: "List KV",
                    path: "/upload-kv"
                },
            ]
        },
        {
            title: "User Account",
            icon: <UserAccountIcon/>,
            role: role?.admin,
            child: [
                {
                    title: "Add User Account",
                    path: "/user-account/add"
                },
                {
                    title: "User Account",
                    path: "/user-account"
                },
            ]
        },

    ])
    return (
        <aside className="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
            <div className="sidenav-header">
                <i className="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
                <Link className="navbar-brand m-0" to="/">
                    <img src={ LogoImg } className="navbar-brand-img h-100" alt="main_logo" />
                    
                </Link>
                
            </div>
            <hr className="horizontal dark mt-0"/>
            <div className="collapse navbar-collapse w-auto" style={{height: 'calc(100vh - 100px)'}} id="sidenav-collapse-main">
                <ul className="navbar-nav">
                    { menus.length > 0 && menus.map((d,i)=>{

                        if( 
                            (d.hasOwnProperty('role') && authUser?.role === d?.role ) || 
                            (!d.hasOwnProperty('role')) 
                        ){
                            if(d.child && d.child.length > 0){
                                return <MultiMenu {...d} is_active={false} pathname={ location.pathname } />
                            }else{
                                return <SingleMenu {...d} is_active={ location.pathname === d.path } />
                            }
                        }
                    }) }
                </ul>
            </div>
        </aside>
    );
}

export default Sidebar;


function SingleMenu({ icon, title, is_active, path }){
    return <li className="nav-item" key={title}>
            <Link className={"nav-link "+(is_active ? 'active':'')} to={ path }>
                <div className="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    { icon }
                </div>
                <span className="nav-link-text ms-1">{ title }</span>
            </Link>
        </li>
}


function MultiMenu({ child, title, icon,  pathname }){
    const [ is_toggle, set_is_toggle ] = useState(false)
    const [ is_active, set_is_active ] = useState(false)

    useEffect(()=>{

        const activeMenu = child.filter(v=>v.path === pathname)
        set_is_active(activeMenu.length > 0)
    },[pathname])

    return <li className="nav-item">
    <div className={"nav-link "+( is_active ? 'active':'' )} role="button" onClick={()=>set_is_toggle(!is_toggle)}>
        <div className="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
            { icon }
           
        </div>
        <span className="nav-link-text ms-1">{ title }</span>
    </div>
    <div className={"collapse"+(is_toggle ? ' show':'')}>
        <ul className="nav ms-4 ps-3">
            { child.map((d,i)=>(
                <li className="nav-item " key={title+i}>
                    <Link className={"nav-link "+( pathname === d.path ? 'active' : '' )} to={ d.path }>    
                        <span className="sidenav-mini-icon"> U </span>
                        <span className="sidenav-normal"> { d.title } </span>
                    </Link>
                </li>
            )) }
        </ul>
    </div>
</li>
}