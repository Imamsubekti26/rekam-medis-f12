<?php

namespace App\Livewire;

use Livewire\Component;

class BaseComponent extends Component
{
    /**
     * Daftar role yang diizinkan mengakses komponen ini.
     * Contoh: ['doctor.viewer', 'pharmacist.editor']
     */
    protected $rolePermission = [];

    public function boot()
    {
        $this->applyRoleRestrictions();
    }

    private function applyRoleRestrictions()
    {
        $user = request()->user();

        if (!$user) return;
        $user->is_editor = false;

        // Admin selalu diizinkan
        if ($user->is_admin) {
            $user->is_editor = true;
            return;
        }

        // Ambil method request: GET, POST, PUT, etc.
        $method = request()->getMethod();

        // Normalisasi roles: ['doctor.viewer' => ['role' => 'doctor', 'access' => 'viewer']]
        $allowedRoles = collect($this->rolePermission)->map(function ($roleAccess) {
            [$role, $access] = explode('.', $roleAccess);
            return ['role' => $role, 'access' => $access];
        });

        // Cek apakah role user cocok dengan akses yang diberikan
        foreach ($allowedRoles as $allowed) {
            if ($allowed['role'] === $user->role) {
                // Kalau viewer, hanya boleh GET
                if ($allowed['access'] === 'viewer' && $method === 'GET') {
                    $user->is_editor = false;
                    return;
                }

                // Kalau editor, boleh semua method
                if ($allowed['access'] === 'editor') {
                    $user->is_editor = true;
                    return;
                }
            }
        }
    }
}