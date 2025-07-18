import * as Yup from 'yup';

export const updateSchema = Yup.object().shape({
  no_wa: Yup.string()
    .required('Nomor WhatsApp wajib diisi')
    .matches(/^62[0-9]{9,}$/, 'Nomor WhatsApp harus berawalan 62 dan terdiri dari minimal 10 digit'),
  email: Yup.string()
    .required('Email wajib diisi')
    .email('Format email tidak valid'),
});