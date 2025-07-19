$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});


document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-comments').forEach(button => {
        button.addEventListener('click', function () {
            const blogId = this.getAttribute('data-id');
            const commentBox = document.getElementById('comments-' + blogId);
            commentBox.style.display = commentBox.style.display === 'none' ? 'block' :
                'none';
        });
    });
});

$(document).on('click', '.like-comment-btn', function () {
    const commentId = $(this).data('id');
    $.post(`/comments/${commentId}/like`, {
    }, function (res) {
        $(`#like-count-${commentId}`).text(res.likes);
    });
});

$(document).on('click', '.delete-comment-btn', function () {
    const commentId = $(this).data('id');
    if (confirm('Are you sure you want to delete this comment?')) {
        $.ajax({
            url: `/comments/${commentId}`
            , type: 'DELETE'
            , success: function () {
                $(`#comment-${commentId}`).remove();
            }
        });
    }
});

$(document).on('click', '.edit-comment-btn', function () {
    const commentId = $(this).data('id');
    const commentPara = $(`#comment-${commentId} p`);
    const currentBody = commentPara.text().trim().split(':').slice(1).join(':').trim();
    const newBody = prompt('Edit your comment:', currentBody);

    if (newBody) {
        $.ajax({
            url: `/comments/${commentId}`
            , type: 'PUT'
            , data: {
                body: newBody
            }
            , success: function (res) {
                if (res.success) {
                    commentPara.html(`<strong>${res.user_name}:</strong> ${res.body}`);
                }
            }
            , error: function (xhr) {
                alert(xhr.responseJSON.message || 'Something went wrong');
            }
        });
    }
});
