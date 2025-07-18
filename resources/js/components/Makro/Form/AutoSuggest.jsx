import React from 'react';
import AsyncSelect from 'react-select/async';
import { getIndex } from '../../../Utils/api';

// Fungsi untuk mengambil data dari API


// Komponen AutocompleteSelect menggunakan AsyncSelect
function AutoSuggest({ formik, name, title, placeholder="", disabled, parent, onChange,  onBlur }) {
  const fetchOptions = async (inputValue, parent='') => {
    try {
      const response = await getIndex('api/filter/id-outlet', { parent, query: inputValue });
  
      // Sesuaikan dengan struktur data yang dikembalikan oleh API
      return response.data.map(item => ({
        label: item, // Label yang akan ditampilkan di dropdown
        value: item // Value yang terkait dengan label tersebut
      }));
    } catch (error) {
      console.error('Error fetching options:', error);
      return [];
    }
  };
  
  // Komponen AutocompleteSelect menggunakan AsyncSelect
    const loadOptions = (inputValue, callback) => {
      fetchOptions(inputValue, parent).then(options => {
        callback(options);
      });
    };

  return (
    <div className='form-group'>
      <label>{ title }</label>
      <AsyncSelect
        cacheOptions
        loadOptions={loadOptions}
        defaultOptions
        onChange={onChange}
        onBlur={onBlur}
        value={formik.values[name]}
        placeholder={placeholder}
        isDisabled={disabled}
      />
       {formik.touched[name] && formik.errors[name] && (
            <p className="error text-danger"><small>{formik.errors[name]}</small></p>
        )}
    </div>
  );
}

export default AutoSuggest;
