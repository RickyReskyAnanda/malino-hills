import * as Yup from 'yup';

export const updateSchema = Yup.object().shape({
  title: Yup.string()
    .max(50, 'Judul tidak boleh lebih dari 50 karakter')
    .required('Judul wajib diisi'),
  description: Yup.string()
    .max(400, 'Deskripsi tidak boleh lebih dari 400 karakter')
    .required('Deskripsi wajib diisi')
});