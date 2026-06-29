<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Team;
use App\Models\Candidate;
use App\Models\Announcement;
use App\Models\CalendarEvent;
use App\Models\NotificationItem;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Teams must exist before creating users with team_id foreign keys.
        $teams = [
            ['name' => 'Marketing',    'department' => 'Marketing'],
            ['name' => 'HRD',          'department' => 'Human Resource'],
            ['name' => 'IT',           'department' => 'Technology'],
            ['name' => 'Finance',      'department' => 'Finance'],
            ['name' => 'Operations',   'department' => 'Operations'],
            ['name' => 'Sales',        'department' => 'Sales'],
        ];
        foreach ($teams as $t) {
            Team::firstOrCreate(['name' => $t['name']], $t);
        }

        // Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@vif.com'],
            [
                'name'     => 'Dandi Pradana',
                'email'    => 'admin@vif.com',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'position' => 'Administrator',
                'team_id'  => 1,
            ]
        );

        // Extra users
        $userRina = User::firstOrCreate(['email' => 'rina@vif.com'], ['name' => 'Rina Sari', 'email' => 'rina@vif.com', 'password' => Hash::make('password'), 'role' => 'manager', 'team_id' => 1]);
        $userBudi = User::firstOrCreate(['email' => 'budi@vif.com'], ['name' => 'Budi Santoso', 'email' => 'budi@vif.com', 'password' => Hash::make('password'), 'role' => 'user', 'team_id' => 2]);
        $userSiti = User::firstOrCreate(['email' => 'siti@vif.com'], ['name' => 'Siti Rahma', 'email' => 'siti@vif.com', 'password' => Hash::make('password'), 'role' => 'user', 'team_id' => 3]);

        // KPI test users matched to KPI deployment
        $userHrdKpi = User::firstOrCreate(['email' => 'hrd@viffx.com'], [
            'name' => 'HRD KPI',
            'email' => 'hrd@viffx.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'position' => 'HRD KPI',
            'team_id' => 2,
        ]);
        $userJessicaKpi = User::firstOrCreate(['email' => 'jessica@viffx.com'], [
            'name' => 'Jessica',
            'email' => 'jessica@viffx.com',
            'password' => Hash::make('password'),
            'role' => 'bdm',
            'position' => 'Business Development Manager',
            'team_id' => 1,
        ]);

        // Announcements
        Announcement::firstOrCreate(['title' => 'Meeting Bulanan'], [
            'title'       => 'Meeting Bulanan',
            'description' => 'Meeting bulanan akan diadakan pada 25 Mei 2024 pukul 10.00 WIB. Semua staff wajib hadir.',
            'icon'        => '📅',
            'icon_bg'     => 'bg-yellow-500/15',
            'is_new'      => true,
            'created_by'  => $admin->id,
        ]);
        Announcement::firstOrCreate(['title' => 'Update KPI System'], [
            'title'       => 'Update KPI System',
            'description' => 'Penambahan fitur new dashboard dan export excel telah selesai dilakukan.',
            'icon'        => '💻',
            'icon_bg'     => 'bg-blue-500/15',
            'is_new'      => false,
            'created_by'  => $admin->id,
        ]);
        Announcement::firstOrCreate(['title' => 'Libur Nasional'], [
            'title'       => 'Libur Nasional',
            'description' => 'Informasi libur nasional dan cuti bersama tahun 2024 telah diupdate di kalender.',
            'icon'        => '🏖️',
            'icon_bg'     => 'bg-red-500/15',
            'is_new'      => false,
            'created_by'  => $admin->id,
        ]);

        // Calendar Events
        CalendarEvent::firstOrCreate(
            ['title' => 'Meeting Marketing', 'start_time' => now()->setTime(10, 0)],
            [
                'title'      => 'Meeting Marketing',
                'start_time' => now()->setTime(10, 0),
                'end_time'   => now()->setTime(11, 0),
                'location'   => 'Ruang Meeting 1',
                'created_by' => $admin->id,
            ]
        );
        CalendarEvent::firstOrCreate(
            ['title' => 'Interview Candidate', 'start_time' => now()->setTime(14, 0)],
            [
                'title'      => 'Interview Candidate',
                'start_time' => now()->setTime(14, 0),
                'end_time'   => now()->setTime(15, 0),
                'location'   => 'Ruang HRD',
                'created_by' => $admin->id,
            ]
        );

        // Candidates
        $candidates = [
            ['name' => 'Ahmad Fauzi',    'email' => 'ahmad@mail.com',  'position_applied' => 'Frontend Developer', 'status' => 'interview'],
            ['name' => 'Dewi Lestari',   'email' => 'dewi@mail.com',   'position_applied' => 'Marketing Staff',    'status' => 'pending'],
            ['name' => 'Hendra Wijaya',  'email' => 'hendra@mail.com', 'position_applied' => 'Backend Developer',  'status' => 'accepted'],
            ['name' => 'Maya Putri',     'email' => 'maya@mail.com',   'position_applied' => 'HRD Manager',        'status' => 'pending'],
            ['name' => 'Rizky Pratama',  'email' => 'rizky@mail.com',  'position_applied' => 'UI/UX Designer',     'status' => 'rejected'],
        ];
        foreach ($candidates as $c) {
            Candidate::firstOrCreate(['email' => $c['email']], $c);
        }

        // Notifications
        NotificationItem::firstOrCreate([
            'user_id' => $admin->id,
            'title' => 'Selamat datang di portal VIFFX',
            'message' => 'Admin berhasil login dan notifikasi portal aktif.',
            'tone' => 'success',
            'icon' => 'check',
        ]);

        NotificationItem::firstOrCreate([
            'user_id' => $userBudi->id,
            'title' => 'Update status kandidat',
            'message' => 'Status kandidat baru telah diperbarui oleh tim HR.',
            'tone' => 'info',
            'icon' => 'calendar',
        ]);

        NotificationItem::firstOrCreate([
            'user_id' => $userSiti->id,
            'title' => 'Backup database selesai',
            'message' => 'Backup database harian berhasil diselesaikan.',
            'tone' => 'success',
            'icon' => 'server',
        ]);
    }
}

