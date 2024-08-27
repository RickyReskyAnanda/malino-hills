import * as Yup from 'yup';

// Definisikan skema validasi
export const updateApprovalSchema = Yup.object().shape({
  approvel_number: Yup.string().required('Approvel number is required').min(1, 'Minimal 1'),
});

export const updateProductionSchema = Yup.object().shape({
  production_week: Yup.string()
    .required('Production week is required')
    .oneOf(['W2', 'W4'], 'Production week must be either W2 or W4'),
  production_month: Yup.string()
    .required('Production month is required'),
});

export const updateDeliverySchema = Yup.object().shape({
  delivery_week: Yup.string()
    .required('Delivery week is required')
    .oneOf(['W2', 'W4'], 'Delivery week must be either W2 or W4'),
  delivery_month: Yup.string()
    .required('Delivery month is required'),
});


export const updateAcceptedSchema = Yup.object().shape({
  tgl_penerimaan: Yup.string()
    .required('Tanggal penerimaan is required')
    .max(10, 'Due Date must not exceed 10 characters'),
  foto_penerimaan: Yup.mixed()
    .required('Foto penerimaan is required')
    .test('fileType', 'Unsupported File Format', value => {
      const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
      return value && validTypes.includes(value.type);
    })
    .test('fileSize', 'File Size is too large', value => {
      return value && value.size <= 2048 * 1024; // 2 MB
    }),
});
