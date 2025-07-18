import React, { useEffect, useState, useRef, forwardRef, useImperativeHandle } from "react";
import SlidingPanel from "react-sliding-side-panel";
import "react-sliding-side-panel/lib/index.css";
import { useFormik } from "formik";

import { createSchema } from "../../Schemas/BookingSchema";
import Input from "../../components/Makro/Form/Input";

import DateRangePickerInput from "./DateRangePickerInput";
// import SelectApi from "../../components/Makro/Form/SelectApi";
import VillaMultiSelect from "./VillaMultiSelect";
import { postItem } from "../../utils/api";
import toastify from './../../utils/toastify'

const pathUrl = "booking-bulk";

const Form = forwardRef(({ isOpenPanel, onClose }, ref) => {
    
    const [isLoading, setIsLoading] = useState(false);
    const [villas, setVillas] = useState([]);
    const [selectedOptions, setSelectedOptions] = useState([]);
    const [bookings, setBookings] = useState([]);
    const [dateRanges, setDateRanges] = useState({});
    
    const dateRangeRef = useRef();
    const scrollRef = useRef(null);

    useImperativeHandle(ref, () => ({
        setName(name){
            formik.setFieldValue("name", name);
        },
        setVilla(villa, roomNumber, date) {
            handleVillaMultiSelect(villa)
            setTimeout(() => { 
                handleCheckboxChange(villa[0].value, roomNumber, true)

                handleDateRangePicker({
                    startDate: date,
                    endDate: date
                }, villa[0].value);


                dateRangeRef.current.setValue(date,date);

             },50);
            
        },
        setRoom(room) {

        }
    }))


    useEffect(() => {
        if (!isOpenPanel) return;

        const timeout = setTimeout(() => {
            const el = scrollRef.current;
            if (!el) return;

            const onWheel = (e) => {
                const isAtTop = el.scrollTop === 0;
                const isAtBottom =
                    el.scrollHeight - el.scrollTop === el.clientHeight;

                if ((e.deltaY < 0 && isAtTop) || (e.deltaY > 0 && isAtBottom)) {
                    e.preventDefault();
                }
            };

            el.addEventListener("wheel", onWheel, { passive: false });

            return () => {
                el.removeEventListener("wheel", onWheel);
            };
        }, 100); // 🕐 Tunggu 100ms

        return () => clearTimeout(timeout);
    }, [isOpenPanel]);

    const formik = useFormik({
        initialValues: {
            name: "",
            reservations: [],
        },
        validationSchema: createSchema,
        onSubmit: (values) => {
            setIsLoading(true);
            postItem(`api/${pathUrl}`, values)
                .then((res) => {
                    setIsLoading(false);
                    toastify(res);
                    handleClose();
                })
                .catch((err) => {
                    setIsLoading(false);
                    toastify(err);
                });
        },
    });
    const handleDateRangePicker = (value, villa_id) => {
      setDateRanges((prev) => ({
          ...prev,
          [villa_id]: {
              start_date: value.startDate,
              end_date: value.endDate,
          },
      }));
  
      // Jika sudah ada bookings, update juga sekarang
      setBookings((prev) =>
          prev.map((b) =>
              b.villa_id === villa_id
                  ? { ...b, start_date: value.startDate, end_date: value.endDate }
                  : b
          )
      );
  };
  
  
 

    const handleVillaMultiSelect = (selected) => {
        // Convert ke array kosong jika null
        const newSelected = selected || [];
        setSelectedOptions(newSelected);

        // Ambil semua value yang sedang dipilih
        const selectedValues = newSelected.map((v) => v);

        setVillas((prev) => {
            // Buang villa yang tidak lagi dipilih
            const updated = prev.filter((v) => selectedValues.includes(v.name));

            // Tambahkan villa baru yang belum ada di array
            selectedValues.forEach((value) => {
                const alreadyExists = updated.find((v) => v.name === value);
                if (!alreadyExists) {
                    updated.push({
                        name: value.label,
                        id: value.value,
                        room: value.villa_count,
                        order: updated.length + 1,
                    });
                }
            });

            // Perbarui urutan
            updated.forEach((v, i) => {
                v.order = i + 1;
            });

            return [...updated]; // Return array baru untuk trigger re-render
        });
    };

    useEffect(() => {
        console.log("Villas updated:", bookings);
        formik.setFieldValue("reservations", bookings);
    }, [bookings]);

    useEffect(() => {
        // Filter bookings yang masih relevan berdasarkan villas yang tersedia
        setBookings((prevBookings) => {
            const validVillaIds = villas.map((villa) => villa.id);

            // Hanya pertahankan bookings yang villa_id-nya masih ada
            return prevBookings.filter((booking) => {
                const matchedVilla = villas.find(
                    (v) => v.id === booking.villa_id
                );
                if (!matchedVilla) return false;

                // Jika room_number tidak lebih besar dari jumlah room sekarang
                return booking.room_number <= matchedVilla.room;
            });
        });
    }, [villas]);

    const handleCheckboxChange = (villa_id, room_number, checked) => {
      setBookings((prev) => {
          const index = prev.findIndex(
              (item) =>
                  item.villa_id === villa_id &&
                  item.room_number === room_number
          );
  
          if (checked && index === -1) {
              const dateRange = dateRanges[villa_id] || {};
              return [
                  ...prev,
                  {
                      villa_id,
                      room_number,
                      booked: true,
                      start_date: dateRange.start_date || null,
                      end_date: dateRange.end_date || null,
                  },
              ];
          } else if (!checked && index !== -1) {
              const updated = [...prev];
              updated.splice(index, 1);
              return updated;
          }
          return prev;
      });
  };
  
    const isChecked = (villa_id, room_number) => {
        return bookings.some(
            (item) =>
                item.villa_id === villa_id && item.room_number === room_number
        );
    };


    const handleClose = () => {
        setIsLoading(false);
        setVillas([]);
        setSelectedOptions([]);
        setBookings([]);
        setDateRanges({});
        formik.resetForm();
        onClose();
    }
    return (
        <SlidingPanel
            type={"right"}
            isOpen={isOpenPanel}
            size={40}
            // backdropClicked={() => onClose()}
        >
            <div
                className="card position-absolute"
                style={{ height: "100vH", maxWidth: "40vw", width: "40vw" }}
            >
                <div className="card-header border-bottom">
                    <h5 className="mb-0">Add Reservation</h5>
                </div>
                <div
                    className="card-body "
                    ref={scrollRef}
                    style={{ overflowY: "auto" }}
                >
                    <Input
                        type="text"
                        title="Guest Name"
                        name="name"
                        formik={formik}
                        onChange={formik.handleChange}
                        onBlur={formik.handleBlur}
                        disabled={isLoading}
                        placeholder="Enter the guest's name"
                    />
                    <VillaMultiSelect value={selectedOptions} onChange={handleVillaMultiSelect} />

                    {villas?.map((d, i) => (
                        <div
                            className="border py-2 px-3 rounded my-3"
                            key={"villaCard" + d.id}
                        >
                            <h6>{d.name}</h6>

                            <DateRangePickerInput
                                ref={dateRangeRef}
                              onChange={(e)=>handleDateRangePicker(e, d.id,)}
                            />

                            <div className="w-100 d-flex flex-wrap gap-4 justify-content-start my-3">
                                {Array.from(
                                    { length: d.room },
                                    (_, index) => index + 1
                                ).map((number) => (
                                    <div
                                        class="form-check p-0 d-flex"
                                        key={
                                            "checkChecked" + d.id + "_" + number
                                        }
                                    >
                                        <input
                                            type="checkbox"
                                            name="room"
                                            id={
                                                "checkChecked" +
                                                d.id +
                                                "_" +
                                                number
                                            }
                                            style={{
                                                transform: "scale(1.2)",
                                                marginRight: "5px",
                                            }}
                                            checked={isChecked(d.id, number)}
                                            onChange={(e) =>
                                                handleCheckboxChange(
                                                    d.id,
                                                    number,
                                                    e.target.checked
                                                )
                                            }
                                        />
                                        <label
                                            class="form-check-label m-0"
                                            for={
                                                "checkChecked" +
                                                d.id +
                                                "_" +
                                                number
                                            }
                                        >
                                            Room {number}
                                        </label>
                                    </div>
                                ))}
                            </div>
                        </div>
                    ))}
                </div>
                <div className="card-footer border-top d-flex  justify-content-end gap-2 py-3">
                    <div
                        className="btn btn-outline-secondary rounded-1 btn-sm m-0"
                        onClick={() => handleClose()}
                    >
                        Batal
                    </div>
                    <div
                        className="btn btn-info rounded-0 btn-sm rounded-1 m-0"
                        onClick={formik.handleSubmit}
                    >
                        Reservasi
                    </div>
                </div>
            </div>
        </SlidingPanel>
    );
})
export default Form;    