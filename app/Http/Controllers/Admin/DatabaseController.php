<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseController extends Controller
{
    /**
     * عرض جميع الجداول والأعمدة
     */
    public function index()
    {
        // جلب قائمة الجداول
        $tables = collect(DB::select('SHOW TABLES'))
            ->map(fn($row) => array_values((array) $row)[0]);

        // لكل جدول، جلب الأعمدة
        $columns = [];
        foreach ($tables as $table) {
            $columns[$table] = collect(DB::select("SHOW COLUMNS FROM `{$table}`"))
                ->map(fn($col) => (array) $col)
                ->toArray();
        }

        return view('admin.database.tables', compact('tables', 'columns'));
    }

    /**
     * إنشاء جدول جديد
     */
    public function createTable(Request $request)
    {
        $request->validate([
            'table_name' => 'required|alpha_dash'
        ]);

        $name = $request->table_name;
        DB::statement("CREATE TABLE `{$name}` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY) ENGINE=InnoDB");

        return redirect()->route('admin.database.tables')
            ->with('success', "تم إنشاء الجدول {$name} بنجاح.");
    }

    /**
     * حذف جدول
     */
    public function dropTable(Request $request)
    {
        $request->validate([
            'table_name' => 'required'
        ]);

        $name = $request->table_name;
        DB::statement("DROP TABLE IF EXISTS `{$name}`");

        return redirect()->route('admin.database.tables')
            ->with('success', "تم حذف الجدول {$name} بنجاح.");
    }

    /**
     * إضافة عمود جديد
     */
    public function addColumn(Request $request)
    {
        $request->validate([
            'table'      => 'required|string',
            'column'     => 'required|alpha_dash',
            'type'       => 'required|string',
            'nullable'   => 'nullable|in:yes,no',
        ]);

        $nullable = $request->nullable === 'yes' ? 'NULL' : 'NOT NULL';
        $sql = "ALTER TABLE `{$request->table}` ADD `{$request->column}` {$request->type} {$nullable}";
        DB::statement($sql);

        return redirect()->route('admin.database.tables')
            ->with('success', "تم إضافة العمود {$request->column} إلى جدول {$request->table}.");
    }

    /**
     * تعديل عمود موجود
     */
    public function editColumn(Request $request)
    {
        $request->validate([
            'table'        => 'required|string',
            'old_column'   => 'required|string',
            'new_column'   => 'required|alpha_dash',
            'type'         => 'required|string',
            'nullable'     => 'nullable|in:yes,no',
        ]);

        $nullable = $request->nullable === 'yes' ? 'NULL' : 'NOT NULL';
        $sql = "ALTER TABLE `{$request->table}` CHANGE `{$request->old_column}` `{$request->new_column}` {$request->type} {$nullable}";
        DB::statement($sql);

        return redirect()->route('admin.database.tables')
            ->with('success', "تم تعديل العمود {$request->old_column} إلى {$request->new_column} في جدول {$request->table}.");
    }

    /**
     * حذف عمود
     */
    public function dropColumn(Request $request)
    {
        $request->validate([
            'table'     => 'required|string',
            'column'    => 'required|string',
        ]);

        $sql = "ALTER TABLE `{$request->table}` DROP COLUMN `{$request->column}`";
        DB::statement($sql);

        return redirect()->route('admin.database.tables')
            ->with('success', "تم حذف العمود {$request->column} من جدول {$request->table}.");
    }

    /**
     * تشغيل استعلام SQL يدوي
     */
    public function runSql(Request $request)
    {
        $request->validate([
            'sql' => 'required|string'
        ]);

        try {
            DB::statement($request->sql);
            return redirect()->route('admin.database.tables')
                ->with('success', "تم تنفيذ الاستعلام بنجاح.");
        } catch (\Throwable $e) {
            return redirect()->route('admin.database.tables')
                ->with('error', "خطأ في الاستعلام: " . $e->getMessage());
        }
    }
    public function columnsPage()
    {
        $tables = collect(DB::select('SHOW TABLES'))->map(fn($row) => array_values((array) $row)[0]);
        $columns = [];

        foreach ($tables as $table) {
            $columns[$table] = collect(DB::select("SHOW COLUMNS FROM `{$table}`"))
                ->map(fn($col) => (array) $col)
                ->toArray();
        }

        return view('admin.database.columns', compact('tables', 'columns'));
    }

    public function sqlPage()
    {
        return view('admin.database.sql');
    }
}
