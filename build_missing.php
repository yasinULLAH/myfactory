<?php
$baseDir = __DIR__;

// 1. Create missing directories
$dirs = [
    '/app/Views/qc',
    '/app/Views/maintenance',
    '/app/Views/sales',
    '/app/Views/hr',
    '/app/Views/reports'
];
foreach ($dirs as $dir) {
    if (!file_exists($baseDir . $dir)) {
        mkdir($baseDir . $dir, 0777, true);
    }
}

// 2. Generate Models
$models = [
    'QC' => <<<EOT
<?php
namespace App\Models;
use App\Core\Model;
class QC extends Model {
    public function getAll() {
        return \$this->db->query("SELECT q.*, u.full_name as inspector_name FROM qc_records q LEFT JOIN users u ON q.inspector_id = u.id ORDER BY q.created_at DESC")->fetchAll();
    }
}
EOT,
    'Machine' => <<<EOT
<?php
namespace App\Models;
use App\Core\Model;
class Machine extends Model {
    public function getAll() {
        return \$this->db->query("SELECT * FROM machines ORDER BY id DESC")->fetchAll();
    }
}
EOT,
    'SalesOrder' => <<<EOT
<?php
namespace App\Models;
use App\Core\Model;
class SalesOrder extends Model {
    public function getAll() {
        return []; // Placeholder for sales logic
    }
}
EOT,
    'Employee' => <<<EOT
<?php
namespace App\Models;
use App\Core\Model;
class Employee extends Model {
    public function getAll() {
        return []; // Placeholder
    }
}
EOT
];

foreach ($models as $name => $content) {
    file_put_contents($baseDir . "/app/Models/{$name}.php", $content);
}

// 3. Generate Controllers
$controllers = [
    'QCController' => <<<EOT
<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\QC;
class QCController extends Controller {
    public function index() {
        \$this->checkAuth();
        \$model = new QC();
        \$data = ['title' => 'Quality Control', 'records' => \$model->getAll()];
        \$this->view('qc/index', \$data);
    }
}
EOT,
    'MaintenanceController' => <<<EOT
<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Machine;
class MaintenanceController extends Controller {
    public function index() {
        \$this->checkAuth();
        \$model = new Machine();
        \$data = ['title' => 'Machine Maintenance', 'machines' => \$model->getAll()];
        \$this->view('maintenance/index', \$data);
    }
}
EOT,
    'SalesController' => <<<EOT
<?php
namespace App\Controllers;
use App\Core\Controller;
class SalesController extends Controller {
    public function index() {
        \$this->checkAuth();
        \$data = ['title' => 'Sales & Dispatch'];
        \$this->view('sales/index', \$data);
    }
}
EOT,
    'HRController' => <<<EOT
<?php
namespace App\Controllers;
use App\Core\Controller;
class HRController extends Controller {
    public function index() {
        \$this->checkAuth();
        \$data = ['title' => 'HR & Attendance'];
        \$this->view('hr/index', \$data);
    }
}
EOT,
    'ReportController' => <<<EOT
<?php
namespace App\Controllers;
use App\Core\Controller;
class ReportController extends Controller {
    public function index() {
        \$this->checkAuth();
        \$data = ['title' => 'Reports & Analytics'];
        \$this->view('reports/index', \$data);
    }
}
EOT
];

foreach ($controllers as $name => $content) {
    file_put_contents($baseDir . "/app/Controllers/{$name}.php", $content);
}

// 4. Generate Views
$views = [
    'qc/index.php' => <<<EOT
<?php ob_start(); ?>
<div class="animate__animated animate__fadeIn">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
        <h3 class="text-lg font-semibold mb-4">Quality Control Records</h3>
        <table class="w-full text-sm text-left datatable">
            <thead><tr><th>ID</th><th>Type</th><th>Ref ID</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
                <?php foreach(\$records as \$r): ?>
                <tr><td><?= \$r['id'] ?></td><td><?= \$r['reference_type'] ?></td><td><?= \$r['reference_id'] ?></td><td><?= \$r['status'] ?></td><td><?= \$r['inspection_date'] ?></td></tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>$(document).ready(function(){ $('.datatable').DataTable({responsive:true}); });</script>
<?php \$content = ob_get_clean(); require_once __DIR__ . '/../layouts/main.php'; ?>
EOT,
    'maintenance/index.php' => <<<EOT
<?php ob_start(); ?>
<div class="animate__animated animate__fadeIn">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
        <h3 class="text-lg font-semibold mb-4">Machine Maintenance</h3>
        <table class="w-full text-sm text-left datatable">
            <thead><tr><th>Machine Name</th><th>Code</th><th>Status</th><th>Last Maintenance</th></tr></thead>
            <tbody>
                <?php foreach(\$machines as \$m): ?>
                <tr><td><?= htmlspecialchars(\$m['name']) ?></td><td><?= htmlspecialchars(\$m['code']) ?></td><td><?= \$m['status'] ?></td><td><?= \$m['last_maintenance'] ?></td></tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>$(document).ready(function(){ $('.datatable').DataTable({responsive:true}); });</script>
<?php \$content = ob_get_clean(); require_once __DIR__ . '/../layouts/main.php'; ?>
EOT,
    'sales/index.php' => "<?php ob_start(); ?><div class='p-6 bg-white rounded-xl shadow-sm'><h3>Sales & Dispatch</h3><p>Module scaffolding complete.</p></div><?php \$content = ob_get_clean(); require_once __DIR__ . '/../layouts/main.php'; ?>",
    'hr/index.php' => "<?php ob_start(); ?><div class='p-6 bg-white rounded-xl shadow-sm'><h3>HR & Attendance</h3><p>Module scaffolding complete.</p></div><?php \$content = ob_get_clean(); require_once __DIR__ . '/../layouts/main.php'; ?>",
    'reports/index.php' => "<?php ob_start(); ?><div class='p-6 bg-white rounded-xl shadow-sm'><h3>Reports & Analytics</h3><p>Select a report to generate (Production, Inventory, Procurement, etc.).</p></div><?php \$content = ob_get_clean(); require_once __DIR__ . '/../layouts/main.php'; ?>"
];

foreach ($views as $path => $content) {
    file_put_contents($baseDir . "/app/Views/{$path}", $content);
}

echo "Files generated successfully.\n";
