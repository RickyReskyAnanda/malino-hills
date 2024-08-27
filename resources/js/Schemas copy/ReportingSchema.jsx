import * as Yup from 'yup';

export const createSchema = Yup.object().shape({
  nomor_order: Yup.string()
    .required('Nomor order is required')
    .min(3, 'Nomor Order must be at least 4 characters'),
  regional: Yup.string()
    .required('Regional is required')
    .min(3, 'Regional must be at least 3 characters')
    .max(100, 'Regional can be at most 100 characters'),
  branch: Yup.string()
    .required('Branch is required')
    .min(3, 'Branch must be at least 3 characters')
    .max(100, 'Branch can be at most 100 characters'),
  cluster: Yup.string()
    .required('Cluster is required')
    .min(3, 'Cluster must be at least 3 characters')
    .max(100, 'Cluster can be at most 100 characters'),
  type: Yup.string()
    .required('Type is required')
    .min(2, 'Type must be at least 2 characters')
    .max(100, 'Type can be at most 100 characters'),
  nama: Yup.string()
    .required('Nama is required')
    .min(2, 'Nama must be at least 2 characters'),
  foto: Yup.mixed()
    .required('Foto is required')
    .test('fileType', 'Unsupported File Format', value => {
      const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
      return value && validTypes.includes(value.type);
    })
    .test('fileSize', 'File Size is too large', value => {
      return value && value.size <= 4096 * 1024; // 2 MB
    }),
  alamat: Yup.string()
    .nullable()
    .min(2, 'Alamat must be at least 2 characters'),
  id_outlet: Yup.string()
    .nullable()
    .min(2, 'ID Outlet must be at least 2 characters'),
});

