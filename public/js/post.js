$(document).ready(function() {
    $('select').selectpicker();
    
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

    ClassicEditor
        .create( document.querySelector( '#content' ), {
            image: {
                toolbar: [ 'imageTextAlternative' ]
            }
        } )
        .catch( error => {
            // console.error( error );
        } );

    ClassicEditor
        .create( document.querySelector( '#content_up' ), {
            image: {
                toolbar: [ 'imageTextAlternative' ]
            }
        } )
        .catch( error => {
            // console.error( error );
        } );

    // Hiển thị modal thêm mới bài viết
    $('#btnAdd').on('click', function() {
        $('#modalAddPost').modal('toggle');
    });

    // Thêm mới bài viết
    $('#btnAddPost').on('click', function(e) {
        e.preventDefault();
        var title = document.getElementById('title').value;
        var slug = document.getElementById('slug').value;
        var category = document.getElementById('category').value;
        var content = document.getElementById('content').value;
        $.ajax({
            url: '/admin/addpost-process',
            data: {
                title: title,
                slug: slug,
                category: category,
                content: content
            },
            dataType: 'json',
            type: 'post',
            cache: false,
            success: function(res) {
                if (res.message == 1) {
                    toastr["success"]("Thêm mới thành công!");
                    $('#tablePost').DataTable().ajax.reload();
                    $('#modalAddPost').modal('hide');
                } else if (res.message == 0) {
                    toastr["error"]("Thêm mới thất bại!");
                }
            }
        });
    });

    // Cập nhật bài viết
    $(document).on('click', '.btn-update', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        $.ajax({
            url: '/admin/getpost-process/'+id,
            success: function(res) {
                if (res.post != null) {
                    $('#modalUpdatePost').modal('toggle');
                    $('#title_up').val(res.post.title);
                    $('#slug_up').val(res.post.slug);
                    // $('#content_up').val(res.post.content);
                } else if (res.post == null) {
                    toastr["error"]("Thêm mới thất bại!");
                }
            }
        });
    });

    // Cập nhật bài viết
    $('#btnUpdatePost').on('click', function(e) {
        e.preventDefault();
        var title = document.getElementById('title_up').value;
        var slug = document.getElementById('slug_up').value;
        var category_id = document.getElementById('category_up').value;
        var content = document.getElementById('content_up').value;
        $.ajax({
            url: '/admin/updatepost-process',
            data: {
                title: title,
                slug: slug,
                category_id: category_id,
                content: content
            },
            dataType: 'json',
            type: 'post',
            cache: false,
            success: function(res) {
                if (res.message == 1) {
                    toastr["success"]("Cập nhật thành công!");
                    $('#tablePost').DataTable().ajax.reload();
                    $('#modalUpdatePost').modal('hide');
                } else if (res.message == 0) {
                    toastr["error"]("Cập nhật thất bại!");
                }
            }
        });
    });

    // Xóa bài viết
    $(document).on('click', '.btn-delete', function(e) {
        var id = $(this).data('id');
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'get',
                    url: '/delete-post/'+id,
                    success: function() {
                        swal("Bài viết đã bị xóa!", {
                            icon: "success",
                            position: 'top-end',
                            showConfirmButton: false,
                        });
                        $('#tablePost').DataTable().ajax.reload();
                    }
                })
            }
        });
    })

    // Datatable của bài viết
    $('#tablePost').DataTable({
        "targets": 'no-sort',
        "bSort": false,
        "order": [],
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
        "bLengthChange": false,
        processing: true,
        serverSide: true,
        ajax: {
            url: '/admin/getposts',
            type: 'post'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, width: '4%'},
            { data: 'image', name: 'image', searchable: false, width: '10%' },
            { data: 'title', name: 'title',width: '21%' },
            { data: 'content', name: 'content' },
            { data: 'created_at', name: 'created_at', width: '11%' },
            { data: 'action', name: 'action', orderable: false, searchable: false, width: '15%' }
        ],
    });
});
