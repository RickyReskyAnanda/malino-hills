import * as Yup from 'yup';

export const createSchema = Yup.object().shape({
  name: Yup.string()
    .min(2, 'Name must be at least 2 characters long')
    .max(100, 'Name cannot exceed 100 characters')
    .required('Name is required'),
  username: Yup.string()
    .min(3, 'Username must be at least 3 characters long')
    .max(64, 'Username cannot exceed 64 characters')
    .required('Username is required'),
  password: Yup.string()
    .min(3, 'Password must be at least 3 characters long')
    .max(64, 'Password cannot exceed 64 characters')
    .required('Password is required'),
  confirm: Yup.string()
    .min(3, 'Confirm Password must be at least 3 characters long')
    .max(64, 'Confirm Password cannot exceed 64 characters')
    .oneOf([Yup.ref('password'), null], 'Confirm Password must match Password')
    .required('Confirm Password is required'),
  status: Yup.string()
    .oneOf(['active', 'inactive'], 'Status must be either active or inactive')
    .required('Status is required')
});

export const updateSchema = Yup.object().shape({
  name: Yup.string()
    .min(2, 'Name must be at least 2 characters long')
    .max(100, 'Name cannot exceed 100 characters')
    .required('Name is required'),
  username: Yup.string()
    .min(3, 'Username must be at least 3 characters long')
    .max(64, 'Username cannot exceed 64 characters')
    .required('Username is required'),
  password: Yup.string()
    .min(3, 'Password must be at least 3 characters long')
    .max(64, 'Password cannot exceed 64 characters')
    .nullable(),
  confirm: Yup.string()
    .min(3, 'Confirm Password must be at least 3 characters long')
    .max(64, 'Confirm Password cannot exceed 64 characters')
    .oneOf([Yup.ref('password'), null], 'Confirm Password must match Password')
    .nullable(),
  status: Yup.string()
    .oneOf(['active', 'inactive'], 'Status must be either active or inactive')
    .required('Status is required')
});
