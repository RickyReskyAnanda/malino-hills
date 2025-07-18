import React from 'react'
import { getIndex } from '../../utils/api';
import AsyncSelect from 'react-select/async';

export default function VillaMultiSelect({ value, onChange }) {
    const loadOptions = async (inputValue, callback) => {
        getIndex(`api/booking/select/villa`,{ q: inputValue })
        .then((res) => {
          
                callback(res.data);
        }).catch((error) => {
            console.error("Error fetching options:", error);
            callback([]);
        })
      };
      const customStyles = {
        control: (provided, state) => ({
          ...provided,
          backgroundColor: "#fff",
          borderColor: state.isFocused ? "#86b7fe" : "#ced4da",
          boxShadow: state.isFocused ? "0 0 0 0.25rem rgba(13, 110, 253, 0.25)" : null,
          borderRadius: "0.375rem",
          minHeight: "38px",
          fontSize: "0.875rem",
        }),
        menu: (provided) => ({
          ...provided,
          zIndex: 9999,
        }),
        multiValue: (provided) => ({
          ...provided,
          backgroundColor: "#e9ecef",
          fontSize: "13px"
        }),
        multiValueLabel: (provided) => ({
          ...provided,
          color: "#495057",
          fontSize: "13px"
        }),
        placeholder: (provided) => ({
          ...provided,
          color: "#6c757d",
        }),
        option: (provided, state) => ({
          ...provided,
          backgroundColor: state.isSelected
            ? "#0d6efd"
            : state.isFocused
            ? "#e9ecef"
            : "#fff",
          color: state.isSelected ? "#fff" : "#212529",
          fontSize: "14px", // <-- apply default font size
        }),
        noOptionsMessage: (provided) => ({
          ...provided,
          fontSize: "14px",
          color: "#6c757d",
        }),
      };
    
  return (
    <div>
      <label>Select Villa</label>
        <AsyncSelect
          closeMenuOnSelect={false}
            cacheOptions
            defaultOptions
            isMulti
            value={value}
            loadOptions={loadOptions}
            onChange={onChange}
            placeholder="Select items..."
            styles={customStyles}
            />
    </div>
  )
}
