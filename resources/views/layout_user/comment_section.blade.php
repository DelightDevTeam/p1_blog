<div class="comments-section" data-post-id="{{ $post->id }}">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0 pb-0">
            <h5 class="mb-0">
                <i class="fas fa-comments text-primary me-2"></i>
                Comments 
                <span class="badge bg-primary ms-2" id="comments-count">0</span>
            </h5>
        </div>
        <div class="card-body">
            <!-- Comment Form -->
            @auth
                <div class="comment-form mb-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0 me-3">
                            <img src="{{ auth()->user()->profile_picture ? asset('profile_picture/' . auth()->user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random' }}" 
                                 class="rounded-circle" width="40" height="40" alt="{{ auth()->user()->name }}">
                        </div>
                        <div class="flex-grow-1">
                            <form id="comment-form" class="position-relative">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <input type="hidden" name="parent_id" id="reply-to-id" value="">
                                
                                <div class="form-group">
                                    <textarea class="form-control border-0 bg-light" 
                                              id="comment-text" 
                                              name="comment" 
                                              rows="3" 
                                              placeholder="Share your thoughts..."
                                              style="resize: none; border-radius: 20px;"></textarea>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div class="reply-info d-none" id="reply-info">
                                        <small class="text-muted">
                                            <i class="fas fa-reply me-1"></i>
                                            Replying to <span id="reply-to-name"></span>
                                            <button type="button" class="btn btn-sm btn-link p-0 ms-2" id="cancel-reply">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </small>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm px-4" id="submit-comment">
                                        <i class="fas fa-paper-plane me-1"></i>
                                        Post Comment
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Please <a href="{{ route('login') }}" class="alert-link">login</a> to leave a comment.
                </div>
            @endauth

            <!-- Comments Container -->
            <div id="comments-container" class="comments-list">
                <!-- Comments will be loaded here via AJAX -->
            </div>

            <!-- Loading Spinner -->
            <div id="loading-comments" class="text-center py-4 d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <!-- No Comments Message -->
            <div id="no-comments" class="text-center py-4 d-none">
                <i class="fas fa-comment-slash text-muted mb-3" style="font-size: 3rem;"></i>
                <p class="text-muted mb-0">No comments yet. Be the first to share your thoughts!</p>
            </div>
        </div>
    </div>
</div>

<!-- Comment Template (Hidden) -->
<template id="comment-template">
    <div class="comment-item mb-3" data-comment-id="">
        <div class="d-flex">
            <div class="flex-shrink-0 me-3">
                <img src="" class="rounded-circle" width="40" height="40" alt="">
            </div>
            <div class="flex-grow-1">
                <div class="comment-content bg-light rounded p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-0 fw-bold comment-author"></h6>
                            <small class="text-muted comment-date"></small>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item reply-btn" type="button">
                                    <i class="fas fa-reply me-2"></i>Reply
                                </button></li>
                                <li class="edit-options d-none">
                                    <button class="dropdown-item edit-btn" type="button">
                                        <i class="fas fa-edit me-2"></i>Edit
                                    </button>
                                </li>
                                <li class="delete-options d-none">
                                    <button class="dropdown-item delete-btn text-danger" type="button">
                                        <i class="fas fa-trash me-2"></i>Delete
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="comment-text mb-2"></div>
                    
                    <div class="comment-actions d-flex align-items-center">
                        <button class="btn btn-sm btn-link text-muted p-0 me-3 like-btn">
                            <i class="far fa-heart me-1"></i>
                            <span class="likes-count">0</span>
                        </button>
                        <button class="btn btn-sm btn-link text-muted p-0 reply-btn">
                            <i class="fas fa-reply me-1"></i>
                            Reply
                        </button>
                    </div>
                </div>
                
                <!-- Edit Form (Hidden) -->
                <div class="edit-form mt-2 d-none">
                    <textarea class="form-control mb-2" rows="2"></textarea>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-primary save-edit-btn">Save</button>
                        <button class="btn btn-sm btn-secondary cancel-edit-btn">Cancel</button>
                    </div>
                </div>
                
                <!-- Replies Container -->
                <div class="replies-container ms-4 mt-3">
                    <!-- Replies will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.comments-section {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

.comment-form textarea {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.comment-form textarea:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.comment-item {
    transition: all 0.3s ease;
}

.comment-item:hover {
    transform: translateY(-1px);
}

.comment-content {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.comment-content:hover {
    border-color: #007bff;
    box-shadow: 0 2px 8px rgba(0, 123, 255, 0.1);
}

.like-btn.liked {
    color: #dc3545 !important;
}

.like-btn.liked i {
    color: #dc3545;
}

.replies-container {
    border-left: 2px solid #e9ecef;
    padding-left: 1rem;
}

.reply-info {
    background: #e3f2fd;
    padding: 0.5rem;
    border-radius: 0.5rem;
    border-left: 3px solid #2196f3;
}

.dropdown-menu {
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    border-radius: 8px;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.btn-link {
    text-decoration: none;
}

.btn-link:hover {
    text-decoration: underline;
}

.alert {
    border-radius: 12px;
    border: none;
}

.card {
    border-radius: 12px;
    overflow: hidden;
}

.badge {
    border-radius: 20px;
}

/* Animation for new comments */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.comment-item {
    animation: slideIn 0.3s ease-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const commentsSection = document.querySelector('.comments-section');
    const postId = commentsSection.dataset.postId;
    const commentsContainer = document.getElementById('comments-container');
    const commentForm = document.getElementById('comment-form');
    const commentText = document.getElementById('comment-text');
    const submitBtn = document.getElementById('submit-comment');
    const replyToId = document.getElementById('reply-to-id');
    const replyInfo = document.getElementById('reply-info');
    const replyToName = document.getElementById('reply-to-name');
    const cancelReplyBtn = document.getElementById('cancel-reply');
    const commentsCount = document.getElementById('comments-count');
    const loadingComments = document.getElementById('loading-comments');
    const noComments = document.getElementById('no-comments');

    let currentUser = @json(auth()->user());

    // Load comments on page load
    loadComments();

    // Handle comment form submission
    commentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(commentForm);
        const comment = formData.get('comment').trim();
        
        if (!comment) {
            showAlert('Please enter a comment', 'warning');
            return;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Posting...';

        fetch('{{ route("comments.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                post_id: postId,
                comment: comment,
                parent_id: replyToId.value || null
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                commentText.value = '';
                cancelReply();
                loadComments();
                showAlert('Comment posted successfully!', 'success');
            } else {
                showAlert(data.message || 'Error posting comment', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Error posting comment', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-1"></i>Post Comment';
        });
    });

    // Cancel reply
    cancelReplyBtn.addEventListener('click', cancelReply);

    function cancelReply() {
        replyToId.value = '';
        replyInfo.classList.add('d-none');
        commentText.placeholder = 'Share your thoughts...';
    }

    function loadComments() {
        loadingComments.classList.remove('d-none');
        commentsContainer.innerHTML = '';

        fetch(`/comments/post/${postId}`)
            .then(response => response.json())
            .then(comments => {
                loadingComments.classList.add('d-none');
                
                if (comments.length === 0) {
                    noComments.classList.remove('d-none');
                    commentsCount.textContent = '0';
                    return;
                }

                noComments.classList.add('d-none');
                commentsCount.textContent = comments.length;
                
                comments.forEach(comment => {
                    const commentElement = createCommentElement(comment);
                    commentsContainer.appendChild(commentElement);
                });
            })
            .catch(error => {
                console.error('Error loading comments:', error);
                loadingComments.classList.add('d-none');
                showAlert('Error loading comments', 'error');
            });
    }

    function createCommentElement(comment) {
        const template = document.getElementById('comment-template');
        const clone = template.content.cloneNode(true);
        const commentItem = clone.querySelector('.comment-item');
        
        commentItem.dataset.commentId = comment.id;
        
        // Set user image
        const userImg = commentItem.querySelector('img');
        userImg.src = comment.user.profile_picture 
            ? `/profile_picture/${comment.user.profile_picture}`
            : `https://ui-avatars.com/api/?name=${encodeURIComponent(comment.user.name)}&background=random`;
        userImg.alt = comment.user.name;
        
        // Set comment content
        commentItem.querySelector('.comment-author').textContent = comment.user.name;
        commentItem.querySelector('.comment-date').textContent = comment.formatted_date;
        commentItem.querySelector('.comment-text').textContent = comment.comment;
        commentItem.querySelector('.likes-count').textContent = comment.likes_count;
        
        // Handle likes
        const likeBtn = commentItem.querySelector('.like-btn');
        if (comment.is_liked_by_user) {
            likeBtn.classList.add('liked');
            likeBtn.querySelector('i').classList.replace('far', 'fas');
        }
        
        // Handle permissions
        if (currentUser && (currentUser.id === comment.user_id || currentUser.is_admin)) {
            commentItem.querySelector('.edit-options').classList.remove('d-none');
            commentItem.querySelector('.delete-options').classList.remove('d-none');
        }
        
        // Add event listeners
        addCommentEventListeners(commentItem, comment);
        
        // Load replies if any
        if (comment.replies && comment.replies.length > 0) {
            const repliesContainer = commentItem.querySelector('.replies-container');
            comment.replies.forEach(reply => {
                const replyElement = createCommentElement(reply);
                repliesContainer.appendChild(replyElement);
            });
        }
        
        return commentItem;
    }

    function addCommentEventListeners(commentElement, comment) {
        // Like functionality
        const likeBtn = commentElement.querySelector('.like-btn');
        likeBtn.addEventListener('click', function() {
            if (!currentUser) {
                showAlert('Please login to like comments', 'warning');
                return;
            }
            
            fetch(`/comments/${comment.id}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const icon = likeBtn.querySelector('i');
                    const count = likeBtn.querySelector('.likes-count');
                    
                    if (likeBtn.classList.contains('liked')) {
                        likeBtn.classList.remove('liked');
                        icon.classList.replace('fas', 'far');
                    } else {
                        likeBtn.classList.add('liked');
                        icon.classList.replace('far', 'fas');
                    }
                    
                    count.textContent = data.likes_count;
                }
            })
            .catch(error => console.error('Error:', error));
        });

        // Reply functionality
        const replyBtns = commentElement.querySelectorAll('.reply-btn');
        replyBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                if (!currentUser) {
                    showAlert('Please login to reply', 'warning');
                    return;
                }
                
                replyToId.value = comment.id;
                replyToName.textContent = comment.user.name;
                replyInfo.classList.remove('d-none');
                commentText.placeholder = `Reply to ${comment.user.name}...`;
                commentText.focus();
            });
        });

        // Edit functionality
        const editBtn = commentElement.querySelector('.edit-btn');
        if (editBtn) {
            editBtn.addEventListener('click', function() {
                const commentText = commentElement.querySelector('.comment-text');
                const editForm = commentElement.querySelector('.edit-form');
                const textarea = editForm.querySelector('textarea');
                
                textarea.value = commentText.textContent;
                commentText.style.display = 'none';
                editForm.classList.remove('d-none');
            });
        }

        // Save edit
        const saveEditBtn = commentElement.querySelector('.save-edit-btn');
        if (saveEditBtn) {
            saveEditBtn.addEventListener('click', function() {
                const editForm = commentElement.querySelector('.edit-form');
                const textarea = editForm.querySelector('textarea');
                const commentText = commentElement.querySelector('.comment-text');
                
                const newText = textarea.value.trim();
                if (!newText) {
                    showAlert('Comment cannot be empty', 'warning');
                    return;
                }

                fetch(`/comments/${comment.id}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        comment: newText
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        commentText.textContent = newText;
                        editForm.classList.add('d-none');
                        commentText.style.display = 'block';
                        showAlert('Comment updated successfully!', 'success');
                    } else {
                        showAlert(data.message || 'Error updating comment', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error updating comment', 'error');
                });
            });
        }

        // Cancel edit
        const cancelEditBtn = commentElement.querySelector('.cancel-edit-btn');
        if (cancelEditBtn) {
            cancelEditBtn.addEventListener('click', function() {
                const editForm = commentElement.querySelector('.edit-form');
                const commentText = commentElement.querySelector('.comment-text');
                
                editForm.classList.add('d-none');
                commentText.style.display = 'block';
            });
        }

        // Delete functionality
        const deleteBtn = commentElement.querySelector('.delete-btn');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this comment?')) {
                    fetch(`/comments/${comment.id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            commentElement.remove();
                            loadComments(); // Reload to update count
                            showAlert('Comment deleted successfully!', 'success');
                        } else {
                            showAlert(data.message || 'Error deleting comment', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('Error deleting comment', 'error');
                    });
                }
            });
        }
    }

    function showAlert(message, type) {
        // Create alert element
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
});
</script>