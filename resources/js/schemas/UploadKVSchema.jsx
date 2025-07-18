import * as Yup from 'yup';

export const createSchema = Yup.object({
  title: Yup.string()
    .required('Title is required')
    .min(3, 'Title must be at least 3 characters')
    .max(255, 'Title cannot exceed 255 characters'),
    
  produk: Yup.string()
    .required('Product is required')
    .min(2, 'Product must be at least 2 characters')
    .max(100, 'Product cannot exceed 100 characters'),
    
  jenis: Yup.string()
    .required('Type is required')
    .min(2, 'Type must be at least 2 characters')
    .max(100, 'Type cannot exceed 100 characters'),
    
  kv: Yup.mixed()
    .required('Image is required')
    .test('fileSize', 'Image size is too large', value => !value || (value && value.size <= 2048 * 1024))
    .test('fileFormat', 'Unsupported format', value => !value || (value && ['image/jpeg', 'image/png', 'image/jpg'].includes(value.type))),
    
  kv_cdr: Yup.mixed()
    .required('File is required')
    .test('fileSize', 'File size is too large', value => !value || (value && value.size <= 10240 * 1024)),
});



export const updateSchema = Yup.object({
  title: Yup.string()
    .required('Title is required')
    .min(3, 'Title must be at least 3 characters')
    .max(255, 'Title cannot exceed 255 characters'),
    
  produk: Yup.string()
    .required('Product is required')
    .min(2, 'Product must be at least 2 characters')
    .max(100, 'Product cannot exceed 100 characters'),
    
  jenis: Yup.string()
    .required('Type is required')
    .min(2, 'Type must be at least 2 characters')
    .max(100, 'Type cannot exceed 100 characters'),
    
  kv: Yup.mixed()
    .nullable()
    .test('fileSize', 'Image size is too large', value => !value || (value && value.size <= 2048 * 1024))
    .test('fileFormat', 'Unsupported format', value => !value || (value && ['image/jpeg', 'image/png', 'image/jpg'].includes(value.type))),
    
  kv_cdr: Yup.mixed()
    .nullable()
    .test('fileSize', 'File size is too large', value => !value || (value && value.size <= 10240 * 1024)),
});