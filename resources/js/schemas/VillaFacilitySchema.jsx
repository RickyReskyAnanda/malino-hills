import * as Yup from 'yup';

export const highlightFacilitySchema = Yup.object({
  highlight_facilities: Yup.array().of(
    Yup.object({
      id: Yup.number().required(),
      name: Yup.string().required('Nama fasilitas wajib diisi').max(50, 'Maksimal 50 karakter'),
    })
  ),
});

export const facilitySchema = Yup.object({
  facilities: Yup.array().of(
    Yup.object({
      id: Yup.number().nullable(),
      name: Yup.string().required('Nama fasilitas wajib diisi').max(50, 'Maksimal 50 karakter'),
    })
  ),
});