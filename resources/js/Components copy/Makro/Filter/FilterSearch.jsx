import React from "react";
import {SearchIcon} from "../../Mikro/SVGIcon"

export default function FilterSearch({ name, label, placeholder, onChange }) {
  const [searchTerm, setSearchTerm] = React.useState("");
  const [delayedSearchTerm, setDelayedSearchTerm] = React.useState("");

  React.useEffect(() => {
    const delayDebounceFn = setTimeout(() => {
      // Send Axios request here
      setDelayedSearchTerm(searchTerm);
      onChange({
        name:name,
        value: searchTerm
      })
    }, 700);

    return () => clearTimeout(delayDebounceFn);
  }, [searchTerm]);

  return (
    <div>
      <p className="m-0"><label>{label || "Pencarian"}</label></p>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">
           <SearchIcon/>
          </span>
        </div>
        <input
          type="text"
          autoComplete="off"
          className="form-control"
          placeholder={ placeholder || "Search something..."}
          onChange={(e) => setSearchTerm(e.target.value)}
        />
      </div>
      
    </div>
  );
}

