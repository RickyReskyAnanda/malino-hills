import * as Yup from 'yup';

export const createSchema = Yup.object().shape({
  regional: Yup.string()
    .required('Regional is required')
    .min(3, 'Regional must be at least 3 characters')
    .max(100, 'Regional must not exceed 100 characters'),
  
  branch: Yup.string()
    .required('Branch is required')
    .min(3, 'Branch must be at least 3 characters')
    .max(100, 'Branch must not exceed 100 characters'),
  
  cluster: Yup.string()
    .required('Cluster is required')
    .min(3, 'Cluster must be at least 3 characters')
    .max(100, 'Cluster must not exceed 100 characters'),
  
  type_posmat: Yup.string()
    .required('Type Posmat is required')
    .min(2, 'Type Posmat must be at least 2 characters')
    .max(100, 'Type Posmat must not exceed 100 characters'),
  
  product: Yup.string()
    .required('Product is required')
    .min(3, 'Product must be at least 3 characters')
    .max(100, 'Product must not exceed 100 characters'),
  
  qty: Yup.number()
    .required('Quantity is required')
    .min(1, 'Quantity must be at least 1 ')
    .typeError('Quantity must be a number'),
  
  alamat: Yup.string()
    .required('Alamat is required')
    .max(1000, 'Alamat must not exceed 1000 characters'),
  
  due_date: Yup.string()
    .required('Due Date is required')
    .max(10, 'Due Date must not exceed 10 characters'),
});

