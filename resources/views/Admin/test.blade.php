<!-- Recent Orders -->
<div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-list me-2"></i>Riwayat Orderan
            </h6>
            <a href="#" class="btn btn-sm btn-primary">View All</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>LAU-2023-001</td>
                            <td>Budi Santoso</td>
                            <td>Wash & Fold</td>
                            <td><span class="badge bg-success">Completed</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>LAU-2023-002</td>
                            <td>Siti Aminah</td>
                            <td>Dry Cleaning</td>
                            <td><span class="badge bg-warning">Processing</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>LAU-2023-003</td>
                            <td>Andi Wijaya</td>
                            <td>Iron Only</td>
                            <td><span class="badge bg-info">Ready for Pickup</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Service Statistics -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Service Distribution</h6>
                </div>
                <div class="card-body">
                    <canvas id="serviceChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Monthly Income</h6>
                </div>
                <div class="card-body">
                    <canvas id="incomeChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Service Distribution Chart
const serviceCtx = document.getElementById('serviceChart').getContext('2d');
new Chart(serviceCtx, {
    type: 'doughnut',
    data: {
        labels: ['Wash & Fold', 'Dry Cleaning', 'Iron Only', 'Express'],
        datasets: [{
            data: [45, 30, 15, 10],
            backgroundColor: [
                '#4e73df',
                '#1cc88a',
                '#36b9cc',
                '#f6c23e'
            ]
        }]
    }
});

// Monthly Income Chart
const incomeCtx = document.getElementById('incomeChart').getContext('2d');
new Chart(incomeCtx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Income',
            data: [5000000, 6200000, 7500000, 5800000, 8200000, 9000000],
            backgroundColor: '#4e73df'
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp' + value.toLocaleString();
                    }
                }
            }
        }
    }
});
</script>




                <div class="row mb-4">
                    <div class="col-12">
                        
                    </div>
                </div>
                <--! tempat rincian orderan di daftar anggota adimn -->