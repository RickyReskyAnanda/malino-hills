import * as Yup from 'yup';

export const createSchema = Yup.object().shape({
  month: Yup.string()
    .required('Month is required')
    .max(7, 'Month cannot be longer than 7 characters'),
  
  week: Yup.string()
    .required('Week is required')
    .oneOf(['W1', 'W2', 'W3', 'W4'], 'Week must be in options'),
  
  cluster: Yup.string()
    .required('Cluster is required')
    .max(100, 'Cluster cannot be longer than 100 characters'),
  
  file_csv: Yup.mixed()
    .required('CSV file is required')
    .test(
      'fileSize',
      'File size cannot exceed 10 MB',
      value => value && value.size <= 10 * 1024 * 1024 // 10 MB in bytes
    )
    .test(
      'fileFormat',
      'File must be a CSV',
      value => value && value.type === 'text/csv'
    ),
});

