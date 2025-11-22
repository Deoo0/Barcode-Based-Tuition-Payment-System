<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery | School Portal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: none;
            overflow: hidden;
            width: 100%;
            max-width: 600px;
        }
        .card-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            text-align: center;
            padding: 25px;
            border-bottom: none;
        }
        .card-body {
            padding: 35px;
        }
        .support-info {
            background-color: #e9f7fe;
            border-left: 4px solid #0d6efd;
            border-radius: 8px;
            padding: 22px;
            margin: 22px 0;
        }
        .icon-container {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: rgba(13, 110, 253, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }
        .btn-back {
            background-color: #6c757d;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .btn-back:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }
        .contact-info {
            margin-top: 20px;
        }
        .contact-info li {
            margin-bottom: 8px;
        }
        .email-link {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
        }
        .email-link:hover {
            text-decoration: underline;
        }
        .info-section {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <div class="icon-container">
                <i class="fas fa-key fa-2x text-primary"></i>
            </div>
            <h3>Password Recovery</h3>
        </div>
        <div class="card-body">
            <div class="support-info">
                <h4 class="text-primary"><i class="fas fa-info-circle me-2"></i>Important Notice</h4>
                <p class="mb-0">For password recovery or change, please make a visit to the <strong>School IT Support</strong> office.</p>
            </div>
            
            <div class="info-section">
                <h5>Why visit IT Support in person?</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0"><i class="fas fa-check text-success me-2"></i>Identity verification for security</li>
                    <li class="list-group-item px-0"><i class="fas fa-check text-success me-2"></i>Immediate password reset</li>
                    <li class="list-group-item px-0"><i class="fas fa-check text-success me-2"></i>Additional security setup if needed</li>
                    <li class="list-group-item px-0"><i class="fas fa-check text-success me-2"></i>Personal assistance with any login issues</li>
                </ul>
            </div>
            
            <div class="contact-info">
                <div class="row">
                    <div class="col-md-6">
                        <h5><i class="fas fa-map-marker-alt me-2"></i>Location</h5>
                        <p>Main Administration Building, Room 205</p>
                        
                        <h5><i class="fas fa-clock me-2"></i>Hours</h5>
                        <p>Monday-Friday<br>8:00 AM - 5:00 PM</p>
                    </div>
                    <div class="col-md-6">
                        <h5><i class="fas fa-envelope me-2"></i>Email Support</h5>
                        <p>For inquiries, contact us at:</p>
                        <p class="mb-0">
                            <a href="mailto:aclcitsupport@gmail.com" class="email-link fs-5">
                                <i class="fas fa-envelope me-2"></i>aclcitsupport@gmail.com
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                <a href="{{ route('login') }}" class="btn btn-back text-white">
                    <i class="fas fa-arrow-left me-2"></i>Back to Login
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>