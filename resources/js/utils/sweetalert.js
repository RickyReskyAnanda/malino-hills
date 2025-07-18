import Swal from 'sweetalert2'
export const confirm = (callback) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        console.log(result)
        if (result.isConfirmed) {
          callback()
        }
      });
} 