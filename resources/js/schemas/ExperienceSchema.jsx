import * as Yup from 'yup';

export const createSchema = Yup.object().shape({
  title: Yup.string()
    .max(255, 'Judul konten tidak boleh lebih dari 255 karakter')
    .required('Judul konten wajib diisi'),
  
  status: Yup.string()
    .oneOf(['PUBLISHED', 'DRAFT'], 'Status harus PUBLISHED atau DRAFT')
    .required('Status wajib diisi'),
  
  thumbnail: Yup.mixed()
    .test('fileType', 'Hanya file gambar yang diperbolehkan', (value) => {
      return value === null || (value && ['image/jpeg', 'image/png', 'image/gif'].includes(value.type));
    })
    .required('Thumbnail wajib diupload'),
  short_description: Yup.string()
    .min(20, 'Deskripsi singkat tidak boleh kurang dari 20 karakter')
    .max(255, 'Deskripsi singkat tidak boleh lebih dari 255 karakter')
    .required('Deskripsi singkat wajib diisi'),
  content: Yup.string()
    .min(20, 'Konten tidak boleh kurang dari 20 karakter')
    .required('Konten wajib diisi'),
});

export const updateSchema = Yup.object().shape({
  title: Yup.string()
    .max(255, 'Judul konten tidak boleh lebih dari 255 karakter')
    .required('Judul konten wajib diisi'),
  
  status: Yup.string()
    .oneOf(['PUBLISHED', 'DRAFT'], 'Status harus PUBLISHED atau DRAFT')
    .required('Status wajib diisi'),
  
  thumbnail: Yup.mixed()
    .test('fileType', 'Hanya file gambar yang diperbolehkan', (value) => {
      return value === null || (value && ['image/jpeg', 'image/png', 'image/gif'].includes(value.type));
    }).nullable(),
    short_description: Yup.string()
    .min(20, 'Deskripsi singkat tidak boleh kurang dari 20 karakter')
    .max(255, 'Deskripsi singkat tidak boleh lebih dari 255 karakter')
    .required('Deskripsi singkat wajib diisi'),
  content: Yup.string()
    .min(20, 'Konten tidak boleh kurang dari 20 karakter')
    .required('Konten wajib diisi'),
});