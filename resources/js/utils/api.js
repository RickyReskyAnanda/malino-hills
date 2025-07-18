import axios from "axios";

export const axiosInstance = axios.create({
  baseURL: document.querySelector('meta[name="base-url"]').getAttribute('content'),
  timeout: 60000, // Atur timeout sesuai kebutuhan
});

axiosInstance.interceptors.response.use(
  (response) => {
    return response;
  },
  async (error) => {
    const originalRequest = error.config;

    // Cek apakah error merupakan koneksi terputus atau error lainnya
    if (error.message === 'Network Error' && !originalRequest._retry) {
      originalRequest._retry = true;

      try {
        // Lakukan retry request setelah jeda tertentu (misalnya 3 detik)
        await new Promise(resolve => setTimeout(resolve, 10000));
        return axiosInstance(originalRequest);
      } catch (error) {
        return Promise.reject(error);
      }
    }

    return Promise.reject(error);
  }
);




export const getIndex = (url, filter = {}) => {
  return axiosInstance.get(url, {
      params: filter,
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
    })
     
    .then(({ data }) => {
      return data;
    })
    .catch((error) => {
      if (error.response.status === 401) {
        alert("Sesi telah habis. Silahkan login kembali");
        setTimeout(() => {
          window.location.reload();
        }, 2000);
      }
      // Error
      if (error?.response) {
        // The request was made and the server responded with a status code
        // that falls out of the range of 2xx
        if (error?.response?.data) return error?.response?.data;
      }
    });
};

export const postItem = (url, payload = {}) => {
  return axiosInstance.post(url,payload, {
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
    })
    .then(({ data }) => {
      return data;
    })
    .catch((error) => {
      if (error.response.status === 401) {
        alert("Sesi telah habis. Silahkan login kembali");
        setTimeout(() => {
          localStorage.removeItem("user");
          window.location.reload();
        }, 2000);
      }
      // Error
      if (error?.response) {
        // The request was made and the server responded with a status code
        // that falls out of the range of 2xx
        if (error?.response?.data) return error?.response?.data;
      }
    });
};

export const patchItem = (url, payload = {}) => {
  return axiosInstance.patch(url,payload, {
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
    })
    .then(({ data }) => {
      return data;
    })
    .catch((error) => {
      if (error.response.status === 401) {
        alert("Sesi telah habis. Silahkan login kembali");
        setTimeout(() => {
          localStorage.removeItem("user");
          window.location.reload();
        }, 2000);
      }
      // Error
      if (error?.response) {
        // The request was made and the server responded with a status code
        // that falls out of the range of 2xx
        if (error?.response?.data) return error?.response?.data;
      }
    });
};

export const updateItem = (url, payload = {}) => {
  return axiosInstance.put(url,payload, {
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
    })
    .then(({ data }) => {
      return data;
    })
    .catch((error) => {
      if (error.response.status === 401) {
        alert("Sesi telah habis. Silahkan login kembali");
        setTimeout(() => {
          localStorage.removeItem("user");
          window.location.reload();
        }, 2000);
      }
      // Error
      if (error?.response) {
        // The request was made and the server responded with a status code
        // that falls out of the range of 2xx
        if (error?.response?.data) return error?.response?.data;
      }
    });
};

export const deleteItem = (url, payload = {}) => {
  return axiosInstance.delete(url,{
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
    })
    .then(({ data }) => {
      return data;
    })
    .catch((error) => {
      if (error.response.status === 401) {
        alert("Sesi telah habis. Silahkan login kembali");
        setTimeout(() => {
          localStorage.removeItem("user");
          window.location.reload();
        }, 2000);
      }
      // Error
      if (error?.response) {
        // The request was made and the server responded with a status code
        // that falls out of the range of 2xx
        if (error?.response?.data) return error?.response?.data;
      }
    });
};


export const updateItemWithFile = (url, payload) => {
  return axiosInstance.post(url,{...payload, _method:"put"}, {
      headers: {
        "Content-Type": 'multipart/form-data',
        Accept: "application/json",
      },
    })
    .then(({ data }) => {
      return data;
    })
    .catch((error) => {
      if (error.response.status === 401) {
        alert("Sesi telah habis. Silahkan login kembali");
        setTimeout(() => {
          localStorage.removeItem("user");
          window.location.reload();
        }, 2000);
      }
      // Error
      if (error?.response) {
        // The request was made and the server responded with a status code
        // that falls out of the range of 2xx
        if (error?.response?.data) return error?.response?.data;
      }
    });
};

export const postItemWithFile = (url, payload,onUploadProgress) => {
  return axiosInstance.post(url,{...payload }, {
      headers: {
        "Content-Type": 'multipart/form-data',
        Accept: "application/json",
      },
      onUploadProgress: (progressEvent) => {
        if (onUploadProgress) {
          const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
          onUploadProgress(percentCompleted);
        }
      }
    })
    .then(({ data }) => {
      return data;
    })
    .catch((error) => {
      if (error.response.status === 401) {
        alert("Sesi telah habis. Silahkan login kembali");
        setTimeout(() => {
          localStorage.removeItem("user");
          window.location.reload();
        }, 2000);
      }
      // Error
      if (error?.response) {
        // The request was made and the server responded with a status code
        // that falls out of the range of 2xx
        if (error?.response?.data) return error?.response?.data;
      }
    });
};

export const patchItemWithFile = (url, payload = {}) => {
  return axiosInstance.patch(url,{...payload}, {
      headers: {
        "Content-Type": 'multipart/form-data',
        Accept: "application/json",
      },
    })
    .then(({ data }) => {
      return data;
    })
    .catch((error) => {
      if (error.response.status === 401) {
        alert("Sesi telah habis. Silahkan login kembali");
        setTimeout(() => {
          localStorage.removeItem("user");
          window.location.reload();
        }, 2000);
      }
      // Error
      if (error?.response) {
        // The request was made and the server responded with a status code
        // that falls out of the range of 2xx
        if (error?.response?.data) return error?.response?.data;
      }
    });
};
