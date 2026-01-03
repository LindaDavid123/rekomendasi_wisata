// Admin Panel JavaScript

$(document).ready(function() {
    
    // Sidebar toggle
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
    });
    
    // Load dashboard statistics charts
    if ($('#ratingsChart').length) {
        loadRatingsChart();
    }
    
    if ($('#usersChart').length) {
        loadUsersChart();
    }
    
    if ($('#categoriesChart').length) {
        loadCategoriesChart();
    }
    
    // Image preview
    $('input[type="file"]').on('change', function() {
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = $(input).closest('form').find('.image-preview');
                if (preview.length) {
                    preview.attr('src', e.target.result).show();
                }
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
    
    // DataTable initialization (if available)
    if ($.fn.DataTable) {
        $('.data-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "pageLength": 10,
            "ordering": true,
            "searching": true
        });
    }
    
});

// Load Ratings Per Month Chart
function loadRatingsChart() {
    $.ajax({
        url: baseUrl + 'admin/dashboard/get_statistics?type=ratings_per_month',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var labels = data.map(item => item.month);
            var values = data.map(item => item.total);
            
            var ctx = document.getElementById('ratingsChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Rating',
                        data: values,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Rating per Bulan'
                        }
                    }
                }
            });
        }
    });
}

// Load Users Per Month Chart
function loadUsersChart() {
    $.ajax({
        url: baseUrl + 'admin/dashboard/get_statistics?type=users_per_month',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var labels = data.map(item => item.month);
            var values = data.map(item => item.total);
            
            var ctx = document.getElementById('usersChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah User Baru',
                        data: values,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgb(54, 162, 235)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Pendaftaran User per Bulan'
                        }
                    }
                }
            });
        }
    });
}

// Load Popular Categories Chart
function loadCategoriesChart() {
    $.ajax({
        url: baseUrl + 'admin/dashboard/get_statistics?type=popular_categories',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var labels = data.map(item => item.kategori);
            var values = data.map(item => item.total);
            
            var ctx = document.getElementById('categoriesChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Wisata',
                        data: values,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 206, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(153, 102, 255)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Kategori Wisata'
                        }
                    }
                }
            });
        }
    });
}

// Base URL (adjust if needed)
var baseUrl = window.location.origin + '/wisata_ci3/';
