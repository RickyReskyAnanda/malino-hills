import React, { Suspense, useContext, useEffect } from 'react';
import Sidebar from './Components/Layouts/Sidebar';
import Navbar from './Components/Layouts/Navbar';
import { BrowserRouter, Routes, Route  } from 'react-router-dom';

import { ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

import { routes } from './core/route'
import NotFound from './pages/Others/NotFound';
import { GlobalContext } from './contexts/GlobalContext';

export default function App() {
    const { authUser, setBreadcrumbs } = useContext(GlobalContext);

    useEffect(()=>{
        setBreadcrumbs({
            path:[''],
            title:'',
        })
    },[])

    

    return <BrowserRouter basename="/app">
      <ToastContainer />
      <Sidebar />
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <Navbar/>
            <Routes>
                {routes.map((route, index) => 
                    (route.hasOwnProperty('role') && authUser?.role === route?.role ) || 
                    (!route.hasOwnProperty('role')) ?
                    <Route
                        key={index}
                        path={route.path}
                        element={
                            <Suspense fallback={<h4 className='text-center'>Loading...</h4>}>
                                {route.element}
                            </Suspense>
                        }
                    /> : <></>
                )}
                <Route path="*" element={<NotFound />} />
            </Routes>
        </main>
  
    </BrowserRouter>
}