import React, { useContext, useEffect } from 'react';
import { GlobalContext } from '../Context/GlobalContext';

const NotFound = () => {
  const { setBreadcrumbs } = useContext(GlobalContext);

    useEffect(()=>{
        setBreadcrumbs({
            path:[''],
            title:'',
        })
    },[])
  return (
        <div class="container-fluid py-8">
      <h1 className='text-center mb-3'>404 - Not Found</h1>
      <p className='text-center'>The page you are looking for does not exist.</p>
    </div>
  );
};

export default NotFound;
