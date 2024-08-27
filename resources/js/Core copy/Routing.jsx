import React, {  lazy } from 'react';
const Home = lazy(() => import('./../Page/Home'));
const Dashboard = lazy(() => import('./../Page/Dashboard'));
const Order = lazy(() => import('./../Page/Order'));
const Monitoring = lazy(() => import('./../Page/Monitoring'));
const Reporting = lazy(() => import('./../Page/Reporting'));
const AddReport = lazy(() => import('./../Page/Reporting/Create'));
const BrandingShare = lazy(() => import('./../Page/BrandingShare'));
const FormBrandingShare = lazy(() => import('./../Page/BrandingShare/Create'));
const BankKV = lazy(() => import('./../Page/BankKV'));
const UploadKV = lazy(() => import('./../Page/UploadKV'));
const FormUploadKV = lazy(() => import('./../Page/UploadKV/Form'));
const UserAccount = lazy(() => import('./../Page/UserAccount'));
const FormUserAccount = lazy(() => import('./../Page/UserAccount/Form'));


export const routes = [
    {
        path: '/',
        element: <Home />,
    },
    {
        path: '/dashboard',
        element: <Dashboard />,
    },
    {
        path: '/order',
        element: <Order />,
    },
    {
        path: '/monitoring',
        element: <Monitoring />,
    },
    {
        path: '/reporting',
        element: <Reporting />,
    },
    {
        path: '/reporting/add',
        element: <AddReport />,
    },
    {
        path: '/branding-share',
        element: <BrandingShare />,
    },
    {
        path: '/branding-share/add',
        element: <FormBrandingShare />,
    },
    {
        path: '/bank-kv',
        element: <BankKV />,
    },
    {
        path: '/upload-kv',
        element: <UploadKV />,
        role:'admin'
    },
    {
        path: '/upload-kv/add',
        element: <FormUploadKV />,
        role:'admin'
    },
    {
        path: '/upload-kv/edit/:id',
        element: <FormUploadKV />,
        role:'admin'
    },
    {
        path: '/user-account',
        element: <UserAccount />,
        role:'admin'
    },
    {
        path: '/user-account/add',
        element: <FormUserAccount />,
        role:'admin'
    },
    {
        path: '/user-account/edit/:id',
        element: <FormUserAccount />,
        role:'admin'
    },
]