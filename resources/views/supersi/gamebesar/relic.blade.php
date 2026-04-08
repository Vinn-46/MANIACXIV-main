@extends('supersi.layout.index', ['pageActive' => 'super-si.gamebesar.session.relic', 'pageTitle' => 'Game Besar Hapus Relic'])
@section("content")
    <button onclick="confirm()">Hapus Relic</button>
    <script src="sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (isset($msg)) 
        <script> 
            alert($msg);
        </script>
    @endif

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        const confirm = () => { 
            Swal.fire({
                title: "Yakin akan menghapus Relic?",
                text: "Perubahan ini bersifat permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor:"#059212",
                cancelButtonColor: "#da2505",
                confirmButtonText: "Hapus"
                }).then((result) => {
                if (result.isConfirmed) {
                    //AJAX
                    $.ajax({
                        url: "{{ route('gamebesar.relic.hapus') }}",
                        method: 'POST',     
                        dataType: 'json',  
                        data: {            
                            "_token": "{{ csrf_token() }}",    
                        },
                        success: function(response) {                   // Jika sever mengrimkan sinyal berhasil, maka akan di jalankan perintah
                            Swal.fire({
                                title: "Deleted!",
                                text: "Relic telah dihapus",
                                icon: "success"
                            });
                        },
                        error: function(err) {  
                            Swal.fire({
                                title: "Error!",
                                text: err.message,
                                icon: "error"
                            });
                        }
                    });
                }
            });
        }
    </script>
@endsection