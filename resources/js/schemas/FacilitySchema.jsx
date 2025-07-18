import * as Yup from 'yup';

export const createSchema = Yup.object().shape({
  name: Yup.string()
    .max(255, 'Nama fasilitas tidak boleh lebih dari 255 karakter')
    .required('Nama fasilitas wajib diisi'),
  
  status: Yup.string()
    .oneOf(['PUBLISHED', 'DRAFT'], 'Status harus PUBLISHED atau DRAFT')
    .required('Status wajib diisi'),
  
  image: Yup.mixed()
    .test('fileType', 'Hanya file gambar yang diperbolehkan', (value) => {
      return value === null || (value && ['image/jpeg', 'image/png', 'image/gif'].includes(value.type));
    })
    .required('Gambar wajib diupload'),
  description: Yup.string()
    .min(20, 'Deskripsi tidak boleh kurang dari 20 karakter')
    .required('Deskripsi wajib diisi'),
});

export const updateSchema = Yup.object().shape({
  name: Yup.string()
    .max(255, 'Nama fasilitas tidak boleh lebih dari 255 karakter')
    .required('Nama fasilitas wajib diisi'),
  
  status: Yup.string()
    .oneOf(['PUBLISHED', 'DRAFT'], 'Status harus PUBLISHED atau DRAFT')
    .required('Status wajib diisi'),
  
  image: Yup.mixed()
  .nullable()
  .test(
    'fileType',
    'Hanya file gambar yang diperbolehkan',
    (value) => {
      if (value === null) {
        return true; // Jika nilainya null, validasi dianggap lolos
      }
      // Jika tidak null, periksa tipe file
      return value && ['image/jpeg', 'image/png', 'image/gif'].includes(value.type);
    }
  ),
  
  description: Yup.string()
    .min(20, 'Deskripsi tidak boleh kurang dari 20 karakter')
    .required('Deskripsi wajib diisi'),
});