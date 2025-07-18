import React, { useState, useEffect, useRef, forwardRef, useImperativeHandle } from "react";
import format from "date-fns/format";
import { DateRange } from "react-date-range";
import 'react-date-range/dist/styles.css'; // main style file
import 'react-date-range/dist/theme/default.css'; // theme css file
const DateRangePickerInput = forwardRef(({ onChange }, ref) => {

  const [showCalendar, setShowCalendar] = useState(false);
  const [selectedDate, setSelectedDate] = useState([
    {
      startDate: new Date(),
      endDate: new Date(),
      key: "selection",
    },
  ]);

  const calendarRef = useRef(null);

  useImperativeHandle(ref, () => ({
    setValue(startDate, endDate) {
      setSelectedDate([
        {
          startDate: new Date(startDate),
          endDate: new Date(endDate),
          key: "selection",
        },
      ]);
    }
  }))



  const handleSelect = (ranges) => {
    const { startDate, endDate } = ranges.selection;
    setSelectedDate([ranges.selection]);

    if (startDate.getTime() !== endDate.getTime()) {
      setShowCalendar(false);
    }
  };

  useEffect(() => {
    onChange({
      startDate: format(selectedDate[0].startDate, "yyyy-MM-dd"),
      endDate: format(selectedDate[0].endDate, "yyyy-MM-dd"),
    });
  }, [selectedDate]);

  useEffect(() => {
    function handleClickOutside(event) {
      if (calendarRef.current && !calendarRef.current.contains(event.target)) {
        setShowCalendar(false);
      }
    }

    document.addEventListener("mousedown", handleClickOutside);
    return () => document.removeEventListener("mousedown", handleClickOutside);
  }, []);

  return (
    <div className="form-group" style={{ position: "relative" }}>
      <label htmlFor="dateRange">Select Reservation Date</label>
      <input
        type="text"
        className="form-control rounded-1"
        readOnly
        value={`${format(selectedDate[0].startDate, "dd/MM/yyyy")} - ${format(
          selectedDate[0].endDate,
          "dd/MM/yyyy"
        )}`}
        onClick={() => setShowCalendar(!showCalendar)}
      />

      {showCalendar && (
        <div
          ref={calendarRef}
          style={{
            position: "absolute",
            top: "110%",
            left: 0,
            zIndex: 999,
            boxShadow: "0 6px 20px rgba(0,0,0,0.1)",
            borderRadius: "10px",
            overflow: "hidden",
            backgroundColor: "#fff",
            animation: "fadeIn 0.2s ease-in-out",
          }}
        >
          <DateRange
            editableDateInputs={true}
            onChange={handleSelect}
            moveRangeOnFirstSelection={false}
            ranges={selectedDate}
            rangeColors={["#3f51b5"]}
          />
        </div>
      )}

      <style>
        {`
          @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
          }
        `}
      </style>
    </div>
  );
});
export default DateRangePickerInput;