<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Thêm khách hàng' ?></title>
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
                            <a class="nav-link text-white active" href="/admin/customers">
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
                        <a href="/admin/customers" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= $_SESSION['error'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="/admin/customers/store" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ho_ten" class="form-label">Họ tên <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control <?= isset($_SESSION['errors']['ho_ten']) ? 'is-invalid' : '' ?>" 
                                                   id="ho_ten" name="ho_ten" 
                                                   value="<?= htmlspecialchars($_SESSION['old_data']['ho_ten'] ?? '') ?>">
                                            <?php if (isset($_SESSION['errors']['ho_ten'])): ?>
                                                <div class="invalid-feedback"><?= $_SESSION['errors']['ho_ten'] ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control <?= isset($_SESSION['errors']['email']) ? 'is-invalid' : '' ?>" 
                                                   id="email" name="email" 
                                                   value="<?= htmlspecialchars($_SESSION['old_data']['email'] ?? '') ?>">
                                            <?php if (isset($_SESSION['errors']['email'])): ?>
                                                <div class="invalid-feedback"><?= $_SESSION['errors']['email'] ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="so_dien_thoai" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control <?= isset($_SESSION['errors']['so_dien_thoai']) ? 'is-invalid' : '' ?>" 
                                                   id="so_dien_thoai" name="so_dien_thoai" 
                                                   value="<?= htmlspecialchars($_SESSION['old_data']['so_dien_thoai'] ?? '') ?>">
                                            <?php if (isset($_SESSION['errors']['so_dien_thoai'])): ?>
                                                <div class="invalid-feedback"><?= $_SESSION['errors']['so_dien_thoai'] ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ngay_sinh" class="form-label">Ngày sinh <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control <?= isset($_SESSION['errors']['ngay_sinh']) ? 'is-invalid' : '' ?>" 
                                                   id="ngay_sinh" name="ngay_sinh" 
                                                   value="<?= htmlspecialchars($_SESSION['old_data']['ngay_sinh'] ?? '') ?>">
                                            <?php if (isset($_SESSION['errors']['ngay_sinh'])): ?>
                                                <div class="invalid-feedback"><?= $_SESSION['errors']['ngay_sinh'] ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="hinh_anh" class="form-label">Hình ảnh</label>
                                            <input type="file" class="form-control" id="hinh_anh" name="hinh_anh" accept="image/*">
                                            <div class="form-text">Chọn file ảnh (JPG, PNG, GIF)</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="trang_thai" class="form-label">Trạng thái</label>
                                            <select class="form-select" id="trang_thai" name="trang_thai">
                                                <option value="active" <?= ($_SESSION['old_data']['trang_thai'] ?? 'active') == 'active' ? 'selected' : '' ?>>
                                                    Hoạt động
                                                </option>
                                                <option value="inactive" <?= ($_SESSION['old_data']['trang_thai'] ?? '') == 'inactive' ? 'selected' : '' ?>>
                                                    Không hoạt động
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-save"></i> Lưu khách hàng
                                    </button>
                                    <a href="/admin/customers" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Hủy
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Xóa session errors và old_data sau khi hiển thị
unset($_SESSION['errors'], $_SESSION['old_data']);
?>