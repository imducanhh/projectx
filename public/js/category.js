$(document).ready(function() {
    $('select').selectpicker();

    $('#name').val("");
    $('#slug').val("");
    $('#content').val("");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-left",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    // ClassicEditor
    //     .create( document.querySelector( '#content' ), {
    //         image: {
    //             toolbar: [ 'imageTextAlternative' ]
    //         }
    //     } )
    //     .catch( error => {
    //         // console.error( error );
    //     } );

    // Hiển thị modal thêm mới danh mục
    $('#btnAdd').on('click', function() {
        $('#modalAddCategory').modal('toggle');
    });

    // Datatable của danh mục
    $('#tableCategory').DataTable({
        "language": {
            processing: "Đang xử lý...",
            search: "Tìm kiếm: &nbsp;",
            lengthMenu: "Xem _MENU_ mục",
            info: "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
            infoEmpty: "Đang xem 0 đến 0 trong tổng số 0 mục",
            infoFiltered: "(được lọc từ _MAX_ mục)",
            infoPostFix: "",
            loadingRecords: "Đang tải...",
            zeroRecords: "Không tìm thấy dòng nào phù hợp",
            emptyTable: "Không có dữ liệu trong bảng",
            paginate: {
                first: "Đầu",
                previous: "Trước",
                next: "Tiếp",
                last: "Cuối"
            },
            aria: {
                sortAscending: ": Sắp xếp cột theo thứ tự tăng dần",
                sortDescending: ": Sắp xếp cột theo thứ tự giảm dần"
            }
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: '/admin/getcategories',
            type: 'post'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'image', name: 'image' },
            { data: 'content', name: 'content' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
    });

    // Thêm mới danh mục
    $('#btnAddCategory').on('click', function(e) {
    	e.preventDefault();
        var name = document.getElementById('name').value;
        var slug = document.getElementById('slug').value;
        var content = document.getElementById('content').value;
        
        $.ajax({
            url: '/admin/addcategory-process',
            data: {
                name: name,
                slug: slug,
                content: content
            },
            dataType: 'json',
            type: 'post',
            cache: false,
            success: function(res) {
                if (res.message == 1) {
                    toastr["success"]("Thêm mới thành công!");
                    $('#tableCategory').DataTable().ajax.reload();
                    $('#modalAddCategory').modal('hide');
                } else if (res.message == 0) {
                    toastr["error"]("Thêm mới thất bại!");
                }
            }
        });
    });
});