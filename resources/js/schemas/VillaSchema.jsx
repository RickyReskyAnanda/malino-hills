import * as Yup from 'yup';

export const updateSchema = Yup.object().shape({
  name: Yup.string()
    .required('Nama wajib diisi')
    .min(3, 'Nama harus memiliki minimal 3 karakter')
    .max(255, 'Nama tidak boleh melebihi 255 karakter'),
  
  status: Yup.string()
    .required('Status wajib diisi')
    .oneOf(['PUBLISHED', 'DRAFT'], 'Status harus PUBLISHED atau DRAFT'),
  
  
  content: Yup.string()
    .required('Konten wajib diisi')
    .max(2000, 'Konten tidak boleh melebihi 2000 karakter'),
  
  price: Yup.number()
    .required('Harga wajib diisi')
    .typeError('Harga harus berupa angka'),


  villa_count: Yup.number()
    .required('Jumlah villa wajib diisi')
    .typeError('Jumlah villa harus berupa angka'),

  thumbnail: Yup.mixed()
    .nullable()
    .test('fileType', 'Format file tidak didukung', (value) => {
      if (!value) return true; // Validasi required sudah ditangani
      const supportedFormats = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
      return value && supportedFormats.includes(value.type);
    })
    .test('fileSize', 'File terlalu besar', (value) => {
      if (!value) return true; // Validasi required sudah ditangani
      return value && value.size <= 1024 * 1024 * 10; // Maksimal ukuran dalam byte (2048 KB)
    }),
});