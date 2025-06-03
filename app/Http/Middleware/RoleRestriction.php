<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleRestriction
{
    /**
     * Batasi akses berdasarkan role dan aksesnya
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param array<string> $roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // Admin selalu boleh
        if ($user->is_admin) {
            $user->is_editor = true;
            return $next($request);
        }

        // Cek pembatasan berdasarkan role
        $method = $request->getMethod();

        // Role dokter tidak boleh akses menu dokter, apoteker, obat
        if ($user->role === 'doctor') {
            $restrictedUris = ['doctor', 'pharmacist', 'medicine'];
            foreach ($restrictedUris as $uri) {
                if ($request->is($uri) || $request->is($uri.'/*')) {
                    return redirect()->back()->withErrors('Akses ditolak untuk dokter.');
                }
            }
        }

        // Role apoteker tidak boleh akses menu dokter, apoteker
        if ($user->role === 'pharmacist') {
            $restrictedUris = ['doctor', 'pharmacist'];
            foreach ($restrictedUris as $uri) {
                if ($request->is($uri) || $request->is($uri.'/*')) {
                    return redirect()->back()->withErrors('Akses ditolak untuk apoteker.');
                }
            }
        }

        // Normalisasi role.permission => ['role' => 'doctor', 'access' => 'viewer/editor']
        $allowedRoles = collect($roles)->map(function ($roleAccess) {
            [$role, $access] = explode('.', $roleAccess);
            return ['role' => $role, 'access' => $access];
        });

        foreach ($allowedRoles as $allowed) {
            if ($allowed['role'] === $user->role) {
                if ($allowed['access'] === 'viewer' && $method === 'GET') {
                    $user->is_editor = false;
                    return $next($request);
                }

                if ($allowed['access'] === 'editor') {
                    $user->is_editor = true;
                    return $next($request);
                }
            }
        }

        return redirect()->back()->withErrors('Kamu tidak memiliki akses ke halaman yang dituju.');
    }
}



// <?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;

// /**
//  * Filter role who can access the route. Admin is allways!
//  */
// class RoleRestriction
// {
//     /**
//      * Summary of handle
//      * @param \Illuminate\Http\Request $request
//      * @param \Closure $next
//      * @param array<string> $roles
//      * @return \Symfony\Component\HttpFoundation\Response
//      */
//     public function handle(Request $request, Closure $next, string ...$roles): Response
//     {
//         $user = $request->user();

//         // Admin selalu diizinkan
//         if ($user->is_admin) {
//             $user->is_editor = true;
//             return $next($request);
//         }

//         // Ambil method request: GET, POST, PUT, etc.
//         $method = $request->getMethod();

//         // Normalisasi roles: ['doctor.viewer' => ['role' => 'doctor', 'access' => 'viewer']]
//         $allowedRoles = collect($roles)->map(function ($roleAccess) {
//             [$role, $access] = explode('.', $roleAccess);
//             return ['role' => $role, 'access' => $access];
//         });

//         // Cek apakah role user cocok dengan akses yang diberikan
//         foreach ($allowedRoles as $allowed) {
//             if ($allowed['role'] === $user->role) {
//                 // Kalau viewer, hanya boleh GET
//                 if ($allowed['access'] === 'viewer' && $method === 'GET') {
//                     $user->is_editor = false;
//                     return $next($request);
//                 }

//                 // Kalau editor, boleh semua method
//                 if ($allowed['access'] === 'editor') {
//                     $user->is_editor = true;
//                     return $next($request);
//                 }
//             }
//         }

//         return redirect()->back()->withErrors('Kamu tidak memiliki akses ke halaman yang dituju.');
//     }
// }
