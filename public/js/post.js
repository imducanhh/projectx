$(document).ready(function() {

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

    function ChangeToSlug() {
        var title, slug;

        //Lấy text từ thẻ input title 
        title = document.getElementById("title").value;

        //Đổi chữ hoa thành chữ thường
        slug = title.toLowerCase();

        //Đổi ký tự có dấu thành không dấu
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        //Xóa các ký tự đặt biệt
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        //Đổi khoảng trắng thành ký tự gạch ngang
        slug = slug.replace(/ /gi, "-");
        //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        //Xóa các ký tự gạch ngang ở đầu và cuối
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        //In slug ra textbox có id “slug”
        document.getElementById('slug').value = slug;
    }

    // CKediter
    ClassicEditor
        .create(document.querySelector('#content'), )
        .catch(error => {
            console.error(error);
        });

    // Hiển thị modal thêm mới bài viết
    $('#btnAdd').on('click', function() {
        $('#modalAddPost').modal('toggle');
    });

    // Thêm mới bài viết
    $('#btnAddPost').on('click', function(e) {
        e.preventDefault();
        var title = document.getElementById('title').value;
        var slug = document.getElementById('slug').value;
        var content = document.getElementById('content').value;
        $.ajax({
            url: '/admin/addpost-process',
            data: {
                title: title,
                slug: slug,
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

    // Xóa bài viết
    $(document).on('click', '.btn-delete', function(e) {
        var id = $(this).data('id');

        // toastr["success"]("My name is Inigo Montoya. You killed my father. Prepare to die!");

        swal({
            title: "Bạn có chắc chắn xóa bài viết này không?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'get',
                    url: '/delete-post/'+id,
                    success: function() {
                        swal("Bài viết đã bị xóa!", {
                            icon: "success",
                        });
                        $('#tablePost').DataTable().ajax.reload();
                    }
                })
            }
        });
    })

    // Datatable của bài viết
    $('#tablePost').DataTable({
        "language": {
            processing: "Đang xử lý...",
            search: "Tìm kiếm: &nbsp;:",
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
        // ajax: '/admin/getposts',
        ajax: {
            url: '/admin/getposts',
            type: 'post'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'content', name: 'content' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
    });

});
