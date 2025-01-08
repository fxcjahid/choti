<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{ asset('assets/admin/img/icon.png') }}" type="image/x-icon">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+Display:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('assets/admin/css/admin.css') }}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

    <script type="text/javascript">
        window.FILES = {
            upload_max_filesize: {{ (int) ini_get('upload_max_filesize') }},
            IMAGE: {
                maxWidth: {{ env('Image_Max_Width', 2000) }},
                maxHeight: {{ env('Image_Max_Height', 2000) }},
            }
        }
    </script>
    @routes
</head>

<body class="2xl:m-auto 2xl:max-w-screen-2xl">
    <div id="app" x-data="{ isOpenSidebar: true }">
        @yield('content')
    </div>
</body>

<script src="{{ mix('assets/admin/js/admin.js') }}"></script>
<script src="{{ mix('assets/admin/js/preline.js') }}"></script>
<script src="//unpkg.com/alpinejs"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Initialize the chart
    const ctx = document.getElementById('salesChart').getContext('2d');

    // Define your chart data and configuration
    const salesChart = new Chart(ctx, {
        type: 'line', // Type of chart
        data: {
            labels: ['01 Feb', '02 Feb', '03 Feb', '04 Feb', '05 Feb', '06 Feb', '07 Feb'], // X-axis labels
            datasets: [{
                label: 'Revenue',
                data: [2200, 6400, 6700, 6800, 4000, 7200, 1500], // Data points for current period
                borderColor: '#3b82f6', // Blue line
                backgroundColor: 'rgba(59, 130, 246, 0.2)', // Light blue fill
                fill: true, // Fill under the line
                tension: 0.4, // Smooth curve
            }],
        },
        options: {
            responsive: true, // Adjusts chart size to container
            plugins: {
                legend: {
                    display: true, // Show legend
                    position: 'bottom', // Position the legend
                },
            },
            scales: {
                x: {
                    title: {
                        display: true, // Show X-axis title
                        text: 'Date',
                    },
                    grid: {
                        display: false, // Hide gridlines for X-axis
                    },
                },
            },
        },
    });

    const data = {
        datasets: [{
            data: [68, 25, 7], // Percentages
            backgroundColor: [
                '#2dd4bf', // Teal for Desktop
                '#3b82f6', // Blue for Phone
                '#fda77f' // Orange for Tablet
            ],
            borderWidth: 0,
            cutout: '75%' // Makes it a donut chart
        }],
        labels: ['Desktop', 'Phone', 'Tablet']
    };

    // Chart configuration
    const config = {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw}%`;
                        }
                    }
                }
            }
        }
    };

    // Create the chart
    const ctxPie = document.getElementById('deviceChart').getContext('2d');
    new Chart(ctxPie, config);
</script>


</html>
