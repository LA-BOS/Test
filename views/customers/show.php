<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Chi tiết khách hàng' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 bg-dark text-white min-vh-100">
                <div class="p-3">
                    <h4>Admin Panel</h4>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="<?= BASE_URL ?>/admin/customers">
                                <i class="fas fa-users"></i> Khách hàng
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-10">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2><?= $title ?></h2>
                        <div>
                            <a href="<?= BASE_URL ?>/admin/customers/edit/<?= $customer['id'] ?>" class="btn btn-warning me-2">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <a href="<?= BASE_URL ?>/admin/customers" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <?php if ($customer['hinh_anh']): ?>
                                        <img src="<?= BASE_URL . $customer['hinh_anh'] ?>" 
                                             alt="Avatar" class="rounded-circle mb-3" 
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-3" 
                                             style="width: 150px; height: 150px;">
                                            <i class="fas fa-user fa-4x text-white"></i>
                                        </div>
                                    <?php endif; ?>
                                    <h4><?= htmlspecialchars($customer['ho_ten']) ?></h4>
                                    <p class="text-muted">ID: #<?= $customer['id'] ?></p>
                                    <?php if ($customer['trang_thai'] == 'active'): ?>
                                        <span class="badge bg-success fs-6">Hoạt động</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger fs-6">Không hoạt động</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Thông tin chi tiết</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <strong><i class="fas fa-user"></i> Họ tên:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            <?= htmlspecialchars($customer['ho_ten']) ?>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <strong><i class="fas fa-envelope"></i> Email:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="mailto:<?= htmlspecialchars($customer['email']) ?>">
                                                <?= htmlspecialchars($customer['email']) ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <strong><i class="fas fa-phone"></i> Số điện thoại:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="tel:<?= htmlspecialchars($customer['so_dien_thoai']) ?>">
                                                <?= htmlspecialchars($customer['so_dien_thoai']) ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <strong><i class="fas fa-birthday-cake"></i> Ngày sinh:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            <?= date('d/m/Y', strtotime($customer['ngay_sinh'])) ?>
                                            <small class="text-muted">
                                                (<?= date_diff(date_create($customer['ngay_sinh']), date_create('today'))->y ?> tuổi)
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <strong><i class="fas fa-toggle-on"></i> Trạng thái:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            <?php if ($customer['trang_thai'] == 'active'): ?>
                                                <span class="badge bg-success">Hoạt động</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Không hoạt động</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <strong><i class="fas fa-calendar-plus"></i> Ngày tạo:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            <?= date('d/m/Y H:i:s', strtotime($customer['created_at'])) ?>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <strong><i class="fas fa-calendar-check"></i> Cập nhật lần cuối:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            <?= date('d/m/Y H:i:s', strtotime($customer['updated_at'])) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Thao tác</h5>
                                </div>
                                <div class="card-body">
                                    <div class="btn-group" role="group">
                                        <a href="<?= BASE_URL ?>/admin/customers/edit/<?= $customer['id'] ?>" class="btn btn-warning">
                                            <i class="fas fa-edit"></i> Sửa thông tin
                                        </a>
                                        <button onclick="deleteCustomer(<?= $customer['id'] ?>)" class="btn btn-danger">
                                            <i class="fas fa-trash"></i> Xóa khách hàng
                                        </button>
                                        <a href="<?= BASE_URL ?>/admin/customers" class="btn btn-secondary">
                                            <i class="fas fa-list"></i> Danh sách khách hàng
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function deleteCustomer(id) {
            if(confirm('Bạn có chắc chắn muốn xóa khách hàng này?\nHành động này không thể hoàn tác!')) {
                window.location.href = BASE_URL + '/admin/customers/delete/' + id;
            }
        }
    </script>
</body>
</html>