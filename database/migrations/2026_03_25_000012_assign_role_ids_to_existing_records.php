<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Assign role_id to existing records so role middleware works.
        $roleIds = DB::table('roles')
            ->whereIn('name', ['admin', 'doctor', 'patient', 'staff'])
            ->pluck('id', 'name');

        $adminId = $roleIds->get('admin');
        $patientId = $roleIds->get('patient');
        $staffId = $roleIds->get('staff');

        if (! $adminId || ! $patientId || ! $staffId) {
            // Roles migration should run first; if not, fail loudly for clarity.
            throw new RuntimeException('Default roles are missing. Run migrations in order.');
        }

        DB::table('business_owners')
            ->whereNull('role_id')
            ->update(['role_id' => $adminId]);

        DB::table('customers')
            ->whereNull('role_id')
            ->update(['role_id' => $patientId]);

        // Your existing appointment project creates employees from admin without role selection.
        // Default them to `staff` so they can at least access staff pages.
        DB::table('employees')
            ->whereNull('role_id')
            ->update(['role_id' => $staffId]);
    }

    public function down(): void
    {
        DB::table('business_owners')->update(['role_id' => null]);
        DB::table('customers')->update(['role_id' => null]);
        DB::table('employees')->update(['role_id' => null]);
    }
};

