import React, { createContext, useEffect, useState } from 'react';
import { getIndex } from '../Utils/api';

// Membuat Context
export const GlobalContext = createContext();


export const GlobalProvider = ({ children }) => {

  const [authUser, setAuthUser] = useState(null);
  const [breadcrumbs, setBreadcrumbs] = useState({
    path:['Home'],
    title:'Home',
  });

  useEffect(()=>{
    // getUser()
  },[])

  function getUser(){
    getIndex('api/user').then(res=> res?.data && setAuthUser(res?.data))
  }

  return (
    <GlobalContext.Provider
      value={{
        breadcrumbs,
        setBreadcrumbs,
        authUser,
      }}>
      {children}
    </GlobalContext.Provider>
  );
};
