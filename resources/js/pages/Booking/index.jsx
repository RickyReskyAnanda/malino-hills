import React, { useContext, useEffect, useState, useRef } from "react";
import Datatable from "./Datatable";
import { deleteItem, getIndex, patchItem } from "../../utils/api";
import { GlobalContext } from "../../contexts/GlobalContext";

import { confirm } from "../../utils/sweetalert";
import Form from "./Form";

const pathUrl = "booking";

function Booking(props) {
    const formRef = useRef();

    const { setBreadcrumbs } = useContext(GlobalContext);
    const [filter, setFilter] = useState({
        year_month:
            new Date().getFullYear() +
            "-" +
            String(parseInt(new Date().getMonth()) + 1).padStart(2, "0"),
    });

    const [isOpenPanel, setIsOpenPanel] = useState(false);
    useEffect(() => {
        setBreadcrumbs({
            path: ["Booking"],
            title: "Booking",
        });
    }, []);

    const [data, setData] = useState([]);

    useEffect(() => {
        getData();
    }, [filter]);

    function getData() {
        const ft = filter.year_month.split("-");
        getIndex(`api/${pathUrl}`, { year: ft[0], month: ft[1] })
            .then((res) => {
                if (res?.data) {
                    setData(res?.data);
                }
            })
            .catch((err) => {
                console.log(err);
            });
    }

    const handleChange = (payload) => {
        const { villa_id, room_number, day, date, sts, villa, villa_count } =
            payload;

        if (sts === 1) {
            setIsOpenPanel(true);

            formRef.current.setName("Guest Name");
            formRef.current.setVilla(
                [{ value: villa_id, label: villa, villa_count: villa_count }],
                room_number,
                date
            );
        } else if (sts === 0) {
            confirm(() => {
                handleUpdate(villa_id, room_number, day, sts);
                patchItem(`api/${pathUrl}`, {
                    villa_id,
                    room_number,
                    status: 0,
                    date:
                        filter.year_month +
                        "-" +
                        String(parseInt(day)).padStart(2, "0"),
                })
                    .then((res) => {})
                    .catch((err) => {});
            });
        }
    };

    const handleUpdate = (id, number, day, sts) => {
        const index = data.findIndex(
            (v) =>
                parseInt(v.villa_id) === parseInt(id) &&
                parseInt(v.number) === parseInt(number)
        );
        let dt = [...data];
        dt[index]["d_" + day] = sts;
        setData(dt);
    };

    return (
        <div className="container-fluid py-4">
            <div className="row">
                <div className="col-12">
                    <div className="card mb-4">
                        <div className="card-header pb-0">
                            <div className="row">
                                <div className="col-md-6">
                                    <h6>Experience</h6>
                                </div>
                            </div>
                        </div>
                        <div className="card-body">
                            <div className="d-flex justify-content-between gap-2 mb-3">
                                <div>
                                    <input
                                        className="form-control"
                                        type="month"
                                        value={filter.year_month}
                                        onChange={(e) =>
                                            setFilter({
                                                ...filter,
                                                year_month: e.target.value,
                                            })
                                        }
                                    />
                                </div>
                                <div>
                                    <button
                                        className="btn btn-sm btn-info"
                                        onClick={() => setIsOpenPanel(true)}
                                    >
                                        Add Reservation
                                    </button>
                                </div>
                            </div>

                            <Datatable
                                data={data}
                                year_month={filter.year_month}
                                onChange={handleChange}
                            />

                            <Form
                                ref={formRef}
                                isOpenPanel={isOpenPanel}
                                onClose={() => {
                                    setIsOpenPanel(false);
                                    getData();
                                }}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Booking;
