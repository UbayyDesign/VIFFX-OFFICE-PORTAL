<?php

namespace App\Models;

use App\Models\NotificationItem;
use Database\Factories\UserFactory;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Relations\MorphMany;use Illuminate\Support\Facades\DB;
#[Fillable(['name', 'email', 'password', 'role', 'avatar', 'team_id', 'phone', 'position', 'is_active', 'parent_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, CanResetPassword;

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // =========================
    // 📋 PORTAL RELATIONSHIPS
    // =========================

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function notificationItems()
    {
        return $this->hasMany(NotificationItem::class);
    }

    /**
     * Database notifications (Laravel built-in)
     *
     * @return MorphMany
     */
    public function notifications(): MorphMany
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->orderByDesc('created_at');
    }

    /**
     * Unread notifications helper
     *
     * @return MorphMany
     */
    public function unreadNotifications(): MorphMany
    {
        return $this->notifications()->whereNull('read_at');
    }

    public function kpiRecords()
    {
        return $this->hasMany(KpiRecord::class);
    }

    public function hasKpiAccount(): bool
    {
        return DB::connection('kpi')
            ->table('users')
            ->where('email', $this->email)
            ->exists();
    }

    public function getKpiRole(): ?string
    {
        return DB::connection('kpi')
            ->table('users')
            ->where('email', $this->email)
            ->value('role');
    }

    // =========================
    // 🔥 KPI HIERARCHY RELATIONSHIPS
    // =========================

    /**
     * Get the parent (atasan) of this user in the hierarchy
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * Get direct subordinates (bawahan langsung) of this user
     */
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    // =========================
    // 🔥 HIERARCHY HELPER METHODS
    // =========================

    /**
     * Get all subordinate IDs recursively (OPTIMIZED)
     * Returns array of all child IDs at all levels
     */
    public function getAllChildrenIds()
    {
        $ids = [];

        // Get direct children without loading relations (faster)
        $children = User::where('parent_id', $this->id)->pluck('id');

        foreach ($children as $childId) {
            $ids[] = $childId;

            $child = User::find($childId);
            if ($child) {
                $ids = array_merge($ids, $child->getAllChildrenIds());
            }
        }

        return $ids;
    }

    /**
     * Get complete hierarchy: self + all subordinates
     * Used for filtering data by visible users
     */
    public function getHierarchyIds()
    {
        return array_merge([$this->id], $this->getAllChildrenIds());
    }

    // =========================
    // 🔥 ROLE HELPER METHODS
    // =========================

    /**
     * Check if user is admin or HRD (can see all data)
     */
    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'hrd']);
    }

    /**
     * Check if user is Business Manager
     */
    public function isBM()
    {
        return $this->role === 'bm';
    }

    /**
     * Check if user is Business Development Manager
     */
    public function isBDM()
    {
        return $this->role === 'bdm';
    }

    /**
     * Check if user is Chief (Ketua)
     */
    public function isChief()
    {
        return $this->role === 'chief';
    }

    /**
     * Check if user is Marketing Manager
     */
    public function isMM()
    {
        return $this->role === 'mm';
    }

    /**
     * Check if user is Assistant Manager
     */
    public function isAsman()
    {
        return $this->role === 'asman';
    }

    // =========================
    // 🔥 SCOPE: FILTER BY VISIBILITY
    // =========================

    /**
     * Scope: Return only users visible to the given user
     * - Admin/HRD: see all users
     * - Others: see self + all subordinates
     * 
     * Usage: User::visibleTo($currentUser)->get()
     */
    public function scopeVisibleTo($query, $user)
    {
        if ($user->isAdmin()) {
            return $query;
        }

        $ids = $user->getHierarchyIds();

        return $query->whereIn('id', $ids);
    }
}
