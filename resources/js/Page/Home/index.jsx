import React, { useContext, useEffect } from 'react';
// @section('title', 'Greats - Order')
// @section('breadcrumb', 'Order')
import BGHomeImg from './../../Assets/Background/bg_home.png'
import { GlobalContext } from '../../Context/GlobalContext';


function Home(props) {
    const { setBreadcrumbs } = useContext(GlobalContext);

    useEffect(()=>{
        setBreadcrumbs({
            path:['Home'],
            title:'Home',
        })
    },[])

    return (
        <div class="container-fluid py-4">
            <img className='img-fluid rounded' src={ BGHomeImg } />
        </div>
    );
}

export default Home;