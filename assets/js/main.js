// Main JavaScript for Wisata Jogja

$(document).ready(function() {
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Rating Stars
    $('.rating-stars i').on('click', function() {
        var rating = $(this).data('rating');
        var wisataId = $(this).closest('.rating-stars').data('wisata-id');
        
        // Visual update
        $(this).addClass('active');
        $(this).prevAll('i').addClass('active');
        $(this).nextAll('i').removeClass('active');
        
        // Submit rating via AJAX
        submitRating(wisataId, rating);
    });
    
    // Hover effect for rating stars
    $('.rating-stars i').on('mouseenter', function() {
        $(this).addClass('active');
        $(this).prevAll('i').addClass('active');
        $(this).nextAll('i').removeClass('active');
    });
    
    $('.rating-stars').on('mouseleave', function() {
        var currentRating = $(this).data('current-rating') || 0;
        $(this).find('i').each(function(index) {
            if (index < currentRating) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });
    });
    
    // Favorite Toggle
    $('.btn-favorite').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var wisataId = $(this).data('wisata-id');
        var button = $(this);
        
        toggleFavorite(wisataId, button);
    });
    
    // Auto-hide alerts
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
    // Smooth scroll
    $('a[href^="#"]').on('click', function(e) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });
    
    // Search form
    $('#searchForm').on('submit', function(e) {
        var searchQuery = $('#searchInput').val().trim();
        if (searchQuery === '') {
            e.preventDefault();
            alert('Masukkan kata kunci pencarian');
        }
    });
    
    // Image preview for file upload
    $('input[type="file"]').on('change', function() {
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(input.files[0]);
        }
    });
    
    // Confirm delete
    $('.btn-delete').on('click', function(e) {
        if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            e.preventDefault();
        }
    });
    
});

// Submit Rating Function
function submitRating(wisataId, rating) {
    $.ajax({
        url: baseUrl + 'wisata/submit_rating',
        method: 'POST',
        data: {
            wisata_id: wisataId,
            rating: rating
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Update rating display
                $('.rating-stars[data-wisata-id="' + wisataId + '"]').data('current-rating', rating);
                
                // Show success message
                showToast('Rating berhasil disimpan', 'success');
                
                // Reload page to update averages
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                showToast(response.message || 'Gagal menyimpan rating', 'error');
            }
        },
        error: function(xhr) {
            if (xhr.status === 401) {
                showToast('Silakan login terlebih dahulu', 'error');
                setTimeout(function() {
                    window.location.href = baseUrl + 'login';
                }, 2000);
            } else {
                showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
            }
        }
    });
}

// Toggle Favorite Function
function toggleFavorite(wisataId, button) {
    $.ajax({
        url: baseUrl + 'favorit/toggle',
        method: 'POST',
        data: {
            wisata_id: wisataId
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                if (response.action === 'added') {
                    button.removeClass('btn-outline-danger').addClass('btn-danger favorited');
                    button.find('i').removeClass('far').addClass('fas');
                    button.html('<i class="fas fa-heart me-2"></i> Hapus Favorit');
                    showToast('Ditambahkan ke favorit', 'success');
                } else {
                    button.removeClass('btn-danger favorited').addClass('btn-outline-danger');
                    button.find('i').removeClass('fas').addClass('far');
                    button.html('<i class="far fa-heart me-2"></i> Tambah Favorit');
                    showToast('Dihapus dari favorit', 'success');
                }
            } else {
                showToast(response.message || 'Gagal mengubah favorit', 'error');
            }
        },
        error: function(xhr) {
            if (xhr.status === 401) {
                showToast('Silakan login terlebih dahulu', 'error');
                setTimeout(function() {
                    window.location.href = baseUrl + 'login';
                }, 2000);
            } else {
                showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
            }
        }
    });
}

// Toast Notification
function showToast(message, type) {
    var bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
    var toast = $('<div class="toast align-items-center text-white ' + bgClass + ' border-0" role="alert">')
        .append('<div class="d-flex"><div class="toast-body">' + message + '</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>');
    
    $('.toast-container').append(toast);
    var bsToast = new bootstrap.Toast(toast[0]);
    bsToast.show();
    
    setTimeout(function() {
        toast.remove();
    }, 5000);
}

// Loading Spinner
function showLoading() {
    $('.spinner-overlay').addClass('active');
}

function hideLoading() {
    $('.spinner-overlay').removeClass('active');
}

// Format Rupiah
function formatRupiah(angka) {
    var number_string = angka.toString().replace(/[^,\d]/g, ''),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    
    if (ribuan) {
        var separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return 'Rp ' + rupiah;
}

// Get base URL (set in view)
var baseUrl = window.location.origin + '/wisata_ci3/';
