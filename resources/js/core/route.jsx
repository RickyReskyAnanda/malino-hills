import React, {  lazy } from 'react';
const Booking = lazy(() => import('../pages/Booking'));
const Facility = lazy(() => import('../pages/Facility'));
const FormFacility = lazy(() => import('../pages/Facility/Form'));
const Gallery = lazy(() => import('../pages/Gallery'));
const Information = lazy(() => import('../pages/Information'));
const LandingPage = lazy(() => import('../pages/LandingPage'));
const Meeting = lazy(() => import('../pages/Meeting'));
const Villa = lazy(() => import('../pages/Villa'));
const FormVilla = lazy(() => import('../pages/Villa/Form/Form'));
// const Reservation = lazy(() => import('../pages/Reservation'));
const Experience = lazy(() => import('../pages/Experience'));
const FormExperience = lazy(() => import('../pages/Experience/Form'));

const UserAccount = lazy(() => import('../pages/UserAccount'));
const FormUserAccount = lazy(() => import('../pages/UserAccount/Form'));


export const routes = [
    {
        path: '/',
        element: <Booking />,
    },
    {
        path: '/villa',
        element: <Villa />,
    },
    {
        path: '/villa/edit/:id',
        element: <FormVilla />,
    },
    {
        path: '/villa/add',
        element: <FormVilla />,
    },
    {
        path: '/facility',
        element: <Facility />,
    },
    {
        path: '/facility/add',
        element: <FormFacility />,
    },
    {
        path: '/facility/edit/:id',
        element: <FormFacility />,
    },
    {
        path: '/gallery',
        element: <Gallery />,
    },
    {
        path: '/information',
        element: <Information />,
    },
    {
        path: '/meeting',
        element: <Meeting />,
    },
    
    {
        path: '/experience',
        element: <Experience />,
    },
    {
        path: '/experience/add',
        element: <FormExperience />,
    },
    {
        path: '/experience/edit/:id',
        element: <FormExperience />,
    },
    
    {
        path: '/user-account',
        element: <UserAccount />,
    },
    {
        path: '/user-account/add',
        element: <FormUserAccount />,
        role:'admin'
    },
    {
        path: '/user-account/edit/:id',
        element: <FormUserAccount />,
    },
]