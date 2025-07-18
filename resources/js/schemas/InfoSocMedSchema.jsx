import * as Yup from 'yup';

export const updateSchema = Yup.object().shape({
  sosmed_ig: Yup.string()
    .url('Format URL Instagram tidak valid')
    .required('URL Instagram wajib diisi'),
  sosmed_tiktok: Yup.string()
    .url('Format URL TikTok tidak valid')
    .required('URL TikTok wajib diisi'),
  sosmed_facebook: Yup.string()
    .url('Format URL Facebook tidak valid')
    .required('URL Facebook wajib diisi'),
    sosmed_youtube: Yup.string()
    .url('Format URL Youtube tidak valid')
    .required('URL Youtube wajib diisi'),
});