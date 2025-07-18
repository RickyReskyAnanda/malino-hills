import { toast } from 'react-toastify';

const toastify = (response, callback = null,addedOptions={}) => {
  if (response.loading) {
    return toast("Loading...", { autoClose: false });
  }

  const options = {
    autoClose: 5000,
    hideProgressBar: false,
    closeOnClick: true,
    pauseOnHover: true,
    draggable: true,
    progress: undefined,
    onClose:()=>{
      if(callback)
      callback();
    }
  }

  switch(response.status) {
    case 'SUCCESS':
      toast.success(response.message, addedOptions ? {...options,...addedOptions} : options);
      break;
    case 'WARNING':
    case 'FAILED':
      toast.warning(response.message, addedOptions ? {...options,...addedOptions} : options);
      break;
    case 'ERROR':
      toast.error(response.message, addedOptions ? {...options,...addedOptions} : options);
      break;
    case 'INFO':
      toast.info(response.message, addedOptions ? {...options,...addedOptions} : options);
      break;
    default:
      toast(response.message, addedOptions ? {...options,...addedOptions} : options);
      break;
  }
};

export default toastify;
