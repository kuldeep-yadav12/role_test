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


document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".swiper").forEach((swiperEl) => {
        new Swiper(swiperEl, {
            loop: true
            , navigation: {
                nextEl: swiperEl.querySelector(".swiper-button-next")
                , prevEl: swiperEl.querySelector(".swiper-button-prev")
                ,
            }
            ,
        });
    });
});

$(document).ready(function () {
    $(document).off('click', '.like-btn, .dislike-btn').on('click', '.like-btn, .dislike-btn', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const $btn = $(this);
        const blogId = $btn.data('id');
        const type = $btn.data('type');

        $.ajax({
            url: '/like-toggle',
            method: 'POST',
            data: {
                blog_id: blogId,
                type: type
            },
            success: function (data) {
                const $wrapper = $btn.closest('.card'); 
                $wrapper.find('.like-count').text(data.likes);
                $wrapper.find('.dislike-count').text(data.dislikes);
            },
            error: function (xhr) {
                alert('You must be logged in or something went wrong.');
                console.log(xhr.responseText);
            }
        });
    });
});


$('.delete-image').on('click', function (e) {
    e.preventDefault();

    if (!confirm('Are you sure you want to delete this image?')) return;

    let url = $(this).attr('href');

    $.ajax({
        url: url,
        type: 'DELETE',

        success: function (response) {
            if (response.success) {
                location.reload();
            } else {
                alert('Failed to delete image.');
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert('An error occurred while deleting the image.');
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('image-gallery');
    const reorderUrl = el.dataset.url;

    new Sortable(el, {
        animation: 150,
        onEnd: function () {
            let order = [];
            document.querySelectorAll('.image-box').forEach((item, index) => {
                order.push({
                    id: item.getAttribute('data-id'),
                    position: index + 1
                });
            });

            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(reorderUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify({ order: order })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Order updated');
                    } else {
                        alert('Failed to reorder images');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error while reordering');
                });
        }
    });
});
