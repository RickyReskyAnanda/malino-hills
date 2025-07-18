import * as Yup from 'yup';

export const createSchema = Yup.object().shape({
  name: Yup.string()
    .required('Name is required')
    .max(255, 'Name must be at most 255 characters'),
    
  reservations: Yup.array()
    .of(
      Yup.object().shape({
        villa_id: Yup.number()
          .typeError('Villa ID must be a number')
          .required('Villa ID is required'),

        room_number: Yup.number()
          .typeError('Room number must be a number')
          .required('Room number is required'),

        booked: Yup.boolean()
          .required('Booked field is required'),
      })
    )
    .min(1, 'At least one reservation is required')
});