import * as Yup from 'yup';

export const updateSchema = Yup.object().shape({
  address: Yup.string()
    .max(255, 'Address tidak boleh lebih dari 255 karakter')
    .required('Address wajib diisi'),
  longitude: Yup.string()
    .max(255, 'Longitude tidak boleh lebih dari 255 karakter')
    .required('Longitude wajib diisi'),
  lattitude: Yup.string()
    .max(255, 'Lattitude tidak boleh lebih dari 255 karakter')
    .required('Lattitude wajib diisi'),
  position_1: Yup.string()
    .max(255, 'Position 1 tidak boleh lebih dari 255 karakter')
    .required('Position 1 wajib diisi'),
  position_2: Yup.string()
    .max(255, 'Position 2 tidak boleh lebih dari 255 karakter')
    .required('Position 2 wajib diisi'),
  position_3: Yup.string()
    .max(255, 'Position 3 tidak boleh lebih dari 255 karakter')
    .required('Position 3 wajib diisi'),
  position_4: Yup.string()
    .max(255, 'Position 4 tidak boleh lebih dari 255 karakter')
    .nullable(),
  position_5: Yup.string()
    .max(255, 'Position 5 tidak boleh lebih dari 255 karakter')
    .nullable(),
});